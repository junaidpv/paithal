<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package appplication/model
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'PaithalDbTable.php';
require_once 'SessionRow.php';

/**
 * Table adapter for sessions table
 * @author Junaid
 * @since 0.1.0
 */
class SessionsTable extends PaithalDbTable {
    const SESSION_VALID = 'valid';
    const SESSION_INVALID = 'invalid';

    protected $_name = 'sessions';
    protected $_primary = 'session_id';
    protected $_rowClass = 'SessionRow';
    /**
     * Primary key is not autoincrementing one
     * @var bool
     */
    protected $_sequence = false;

    /**
     * $data = array(
     *      'id' => session id,
     *      'user_id' => user id,
     *      'ip' => session ip,
     * );
     * @param UserRow $user
     */
    public function start($user) {
        $timeStamp = time();
        $sessionId = Zend_Session::getId();
        $rows = $this->find($sessionId);
        $session = null;
        if (count($rows) > 0) {// a row with same session id exists
            $session = $rows->getRow(0);
            if ($session->session_status == self::SESSION_VALID) {
                $exception = new Exception('Session collision occured.');
                throw $exception;
            } elseif ($session->session_status == self::SESSION_INVALID) {
                // row exists but session is not valid
                // so we reuse it
                $session->session_user_id = $user->user_id;
                $session->session_ip = $_SERVER['REMOTE_ADDR'];
                $session->session_start_ts = $timeStamp;
                $session->session_last_ts = $timeStamp;
                $session->session_status = self::SESSION_VALID;
                $session->save();
            }
        } else { // row does not exist with given session id, so create it
            // create new session row
            $session = $this->createRow();
            $session->session_id = $sessionId;
            $session->session_user_id = $user->user_id;
            $session->session_ip = $_SERVER['REMOTE_ADDR'];
            $session->session_start_ts = $timeStamp;
            $session->session_last_ts = $timeStamp;
            $session->session_status = self::SESSION_VALID;
            $session->save();
        }
        return $session;
    }

    public function end($userIdInCookie, $sessionIdInCookie) {
        $sessionId = Zend_Session::getId();
        if ($userIdInCookie == $sessionId) {
            $select = $this->select()
                    ->where('session_id = ?', $sessionId)
                    ->where('session_user_id = ?', $userIdInCookie);
            $rows = $this->fetchAll($select);
            if (count($rows) == 1) {
                $rows->getRow(0)->session_status = self::SESSION_INVALID;
                return true;
            }
        }
        return false;
    }

    /**
     * Fetch current session data from database if one.
     * @return SessionRow
     */
    public function get($userIdInCookie, $sessionIdInCookie) {
        $sessionId = Zend_Session::getId();
        if ($userIdInCookie == $sessionId) {
            $select = $this->select()
                    ->where('session_id = ?', $sessionId)
                    ->where('session_user_id = ?', $userIdInCookie);
            $rows = $this->fetchAll($select);
            if (count($rows) == 1) {
                return $rows->getRow(0);
            } else {
                return null;
            }
        }
    }

}