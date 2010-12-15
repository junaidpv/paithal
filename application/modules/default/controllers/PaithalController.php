<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');

/**
 * @package application/modules/default/controllers
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'Zend/Controller/Action.php';
/**
 * Parent controller for all action controllers in the system
 * So all common initialization and finalization operations can
 * be coordinated here
 *
 * @author Junaid P V
 * @since 0.1.0
 */
class PaithalController extends Zend_Controller_Action {
    public function  __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }
    /**
     * All controllers common initialization are here
     */
    public function  init() {
        parent::init();
        
    }
}