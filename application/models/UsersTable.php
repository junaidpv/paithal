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

/**
 * Table adapter for users table
 * @author Junaid
 * @since 0.1.0
 */
class UsersTable extends PaithalDbTable {
    protected $_name = 'users';
    protected $_primary = 'user_id';
    
    public function get($user_id) {
        $rows = $this->find($user_id);
        return $rows->getRow(0);
    }

    /**
     * Match user name aginst password.
     * If match success returns user row otherwise null
     *
     * @param string $userName
     * @param string $userPassword
     * @return UserRow
     */
    public function match($userName, $userPassword) {
        $translate = Zend_Registry::get('translate');
        $paithal = Paithal::getInstance();
        $select = $this->select()
                ->where('user_name = ?', $userName)
                ->where('user_password = ?', sha1($userPassword));
        $rows = $this->fetchAll($select);
        if(count($rows)==1) {
            return $rows->getRow(0);
        }
        return null;
    }
}