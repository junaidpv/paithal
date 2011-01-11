<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');

/**
 * @package application/controllers/manage
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once APPPATH.'/controllers/default/PaithalController.php';
/**
 * Default working controller for admin module
 * @author Junaid P V
 * @since 0.1.0
 */
class Manage_ContentController extends PaithalController {

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }

    public function addAction() {
        $request = $this->_request;
        $submit = $request->getParam('submit', '0');
        if($submit=='1') {
            $contentName = $request->getParam('content_name');
            $contentTitle = $request->getParam('content_title');
            $contentPublishTS = $request->getParam('content_publish_ts');
        }
        $this->renderView('add_content.php');
    }

}