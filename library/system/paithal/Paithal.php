<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package system/paithal
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
/**
 * System main class that controll all flows of execution
 * This class implement singleten pattern
 * @author Junaid P V
 * @since 0.1.0
 */
class Paithal {
    /**
     * The only instance of this class as class variable
     * @var Paithal
     */
    private static  $_instance;

    /**
     * This class can have only one instance.
     * Direct instance creation not allowed
     */
    private function  __construct() {
        
    }

    /**
     * Return the one and only instance of the class
     * @return Paithal
     */
    public function getInstance() {
        if(!(self::$_instance instanceof  self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}