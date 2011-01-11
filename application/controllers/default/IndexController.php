<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');

/**
 * @package application/modules/default/controllers
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'PaithalController.php';
/**
 * Default working controller
 * @author Junaid P V
 * @since 0.1.0
 */
class IndexController extends PaithalController {

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }

    public function indexAction() {
        $this->renderView();
    }

}