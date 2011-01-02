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
     * @param array $data
     */
    public function start($data) {
        $timeStamp = time();
        $rows = $this->find($data['id']);
        if (count($rows) > 0) {// a row with same session id exists
            $session = $rows->getRow(0);
            if ($session->session_status == self::SESSION_VALID) {
                $exception = new Exception('Session collision occured.');
                throw $exception;
            } elseif ($session->session_status == self::SESSION_INVALID) {
                // row exists but session is not valid
                // so we reuse it
                $session->session_user_id = $data['user_id'];
                $session->session_ip = $data['ip'];
                $session->session_start_ts = $timeStamp;
                $session->session_last_ts = $timeStamp;
            }
        } else { // row does not exist with given session id, so create it
            // create new session row
            $session = $this->createRow();
            $session->session_id = $data['id'];
            $session->session_user_id = $data['user_id'];
            $session->session_ip = $data['ip'];
            $session->session_start_ts = $timeStamp;
            $session->session_last_ts = $timeStamp;
        }
    }

    /**
     * Fetch current session data from database if one.
     * @return SessionRow
     */
    public function get() {
        $sessionId = Zend_Session::getId();
        $rows = $this->find($sessionId);
        return $rows->getRow(0);
    }

}