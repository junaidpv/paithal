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
abstract class PaithalController extends Zend_Controller_Action {

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }

    /**
     * All controllers common initialization are here
     */
    public function init() {
        parent::init();
        require_once 'Zend/View.php';
        // create Zend_View manually
        $view = new Zend_View();
        $view->baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $view->moduleName = $this->_request->getModuleName();
        $view->controllerName = $this->_request->getControllerName();
        $view->actionName = $this->_request->getActionName();
        require_once 'Zend/Translate.php';
        $locale = 'en';
        $translate = new Zend_Translate(
                        array(
                            'adapter' => 'gettext',
                            'content' => APPPATH . "/languages/$locale/{$view->moduleName}.mo",
                            'locale' => $locale,
                        )
        );
        $view->translate = $translate;
        Zend_Registry::set('translate', $translate);
        //$this->view->setBasePath(APPPATH.'/views');
        // add Paithal's default view helper path
        $view->addHelperPath(APPPATH . '/views/helpers', 'Paithal_View_Helper');

        // set as controller view object
        // so all child controllers can use the view object
        $this->view = $view;
    }

    public function renderView($script=null) {
        $moduleName = $this->_request->getModuleName();
        if ($moduleName == 'default') {
            $paithal = Paithal::getInstance();
            $this->view->addScriptPath($paithal->themeDir);
            if (isset($script)) {
                echo $this->view->render($script);
            } else {
                echo $this->view->render($paithal->viewName . '_view.php');
            }
        } else if ($moduleName == 'admin' || $moduleName == 'manage') {
            $this->view->addScriptPath(APPPATH . "/views/scripts/$moduleName");
            if (isset($script)) {
                echo $this->view->render($script);
            } else {
                echo $this->view->render('index.php');
            }
        }
    }

}