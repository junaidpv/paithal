<?php

/**
 * @package application/controllers
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */

/**
 * Default working controller
 */
class IndexController extends Zend_Controller_Action {
    public function  __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }

    public function indexAction() {
        echo "Hello";
    }
}