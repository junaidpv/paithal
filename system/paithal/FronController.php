<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Paithal
 * An open source content management system
 *
 * @package system/paithal
 * @author Junaid P V (http://junaidpv.in)
 * @copyright Copyright 2010, Junaid
 * @license GPLv3
 */
require_once 'Request.php';
/**
 * FrontController class
 * @author Junaid P V
 * @since 0.1.0
 */
class FrontController {

    public function __construct() {
        $request = new Request();
    }

}
