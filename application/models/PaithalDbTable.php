<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package appplication/model
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'Zend/Db/Table/Abstract.php';

/**
 * Abstract table adapter all Table adapters to be extended
 * @author Junaid P V
 * @since 0.1.0
 */
abstract  class PaithalDbTable extends Zend_Db_Table_Abstract {
    private static $_prefix;

    public static function setTablePrefix($prefix) {
        self::$_prefix = $prefix;
    }

    /**
     * Auto table name preparation by given table prefix
     */
    protected function  _setupTableName() {
        parent::_setupTableName();
        $this->_name = self::$_prefix.$this->_name;
    }

}