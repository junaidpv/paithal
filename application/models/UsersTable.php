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
}