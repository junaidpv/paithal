<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package appplication/model
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'Zend/Db/Table/Row/Abstract.php';
/**
 * Class representing a session row in sessions table
 * @author Junaid P V
 * @since 0.1.0
 */
class SessionRow extends Zend_Db_Table_Row_Abstract {
    /**
     * Check whether this session is valid or not
     * @param integer $user_id unique user id
     * @param string $ip ip address of client
     * @return bool
     */
    public function isValid($ip=null) {
        // session valid only if session is marked as valid
        if ($this->session_status == SessionsTable::SESSION_VALID) {
            // if ip need to be matched
            if (isset($ip) && $this->session_ip != $ip) {
                return false;
            }
            return true;
        }
        return false;
    }
    /**
     * Update current session by changng session timestamp
     */
    public function update() {
        $this->session_last_ts = time();
        $this->save();
    }

    /**
     * End this session
     */
    public function end () {
        $this->session_status = SessionsTable::SESSION_INVALID;
        $this->save();
    }

}