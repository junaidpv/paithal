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
abstract  class PaithalController extends Zend_Controller_Action {
    public function  __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }
    /**
     * All controllers common initialization are here
     */
    public function  init() {
        parent::init();
        require_once 'Zend/View.php';
        // create Zend_View manually
        $view = new Zend_View();
        $view->baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        //$this->view->setBasePath(APPPATH.'/views');
        // add Paithal's default view helper path
        $view->addHelperPath(APPPATH.'/views/helpers', 'Paithal_View_Helper');

        // set as controller view object
        // so all child controllers can use the view object
        $this->view = $view;
    }

    public function renderView() {
        $paithal = Paithal::getInstance();
        $this->view->addScriptPath($paithal->themeDir);
        $this->view->render($paithal->viewName);
    }
}