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

    public function indexAction() {
        $this->renderView('contents.php');
    }

    public function addAction() {
        $request = $this->_request;
        $submit = $request->getParam('submit', '0');
        if($submit=='1') {
            $params = array();
            $params['content_name'] = $request->getParam('content_name');
            $params['content_title'] = $request->getParam('content_title');
            $params['content_ctype_id'] = $request->getParam('content_ctype_id');
            $params['content_view_id'] = $request->getParam('content_view_id');
            $params['content_publish_ts'] = $request->getParam('content_publish_ts');
            $params['rev_text'] = $request->getParam('rev_text');
            $params['rev_comment'] = $request->getParam('rev_comment');
            require_once APPPATH.'/models/ContentsTable.php';
            $contentsTable = new ContentsTable();
            $contentsTable->addContent($params);
        }
        $this->renderView('add_content.php');
    }

}