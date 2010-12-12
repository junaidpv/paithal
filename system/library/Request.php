<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @package system/library
 * @author Junaid P V (http://junaidpv.in)
 * @copyright Copyright 2010, Junaid
 * @license GPLv3
 */

/**
 * @author Junaid P V
 * @since 0.1.0
 */
class Request {

    /**
     * Request items
     * @var array
     */
    public $request_items = '';

    /**
     * 
     * @param string $query_string Query string to be interpreted.
     * Need to be in url encoded form. Defaut will be taken from GET query.
     */
    public function __construct($query_string) {
        if (!isset($query_string) or !is_string($query_string)) {
            $query_string = $_SERVER['QUERY_STRING'];
        }
        $this->request_items= explode('/', $query_string);
        $count = count($this->request_items);
        // restore each item to the normal form
        for($i = 0; $i < $count; $i++) {
            $this->request_items[$i] = urldecode($this->request_items[$i]);
        }
    }

}