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
    private static $_prefix='';

    public static function setTablePrefix($prefix) {
        self::$_prefix = $prefix;
    }
    public static function getTablePrefix() {
        return self::$_prefix;
    }

    /**
     * Auto table name preparation by given table prefix
     */
    protected function  _setupTableName() {
        parent::_setupTableName();
        $this->_name = self::$_prefix.$this->_name;
    }

    public function getName() {
        return $this->_name;
    }

    /**
     * Seperate name and its directory from supplied full path
     * @param string $fullPath
     * @return array
     */
    public function getDirAndName($fullPath) {
        $lasBSlashPos = strrpos($fullPath, '/');
        if(!$lasBSlashPos) { // if the poisiont returned is FALSE
            // backslash is not in the path given
            // if
            $cName = $fullName;
            $cPath = NULL;
        }
        else {
            // path is from 0 to last backslash position found
            $cPath = substr($fullName, 0, $lasBSlashPos);
            // dir name is from last backslash
            $cName = substr($fullName, $lasBSlashPos+1);
        }
        return array('path'=>$cPath, 'name'=> $cName);
    }

}