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
class UserController extends PaithalController {

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
    }

    public function indexAction() {
        $this->renderView();
    }

    public function loginAction() {
        $request = $this->_request;
        // only POST request will be considered
        if ($request->isPost()) {
            $userName = $request->getPost('user_name');
            $userPassword = $request->getPost('user_password');
            $returnTo = $request->getPost('return');
            require_once APPPATH . '/models/UsersTable.php';
            $usersTable = new UsersTable();
            // try to match user name aginst given password
            $user = $usersTable->match($userName, $userPassword);
            if ($user) {
                require_once APPPATH . '/models/SessionsTable.php';
                $sessionsTable = new SessionsTable();
                $session = $sessionsTable->start($user);
                setcookie('uid',
                        $user->user_id,
                        3600,
                        $this->_request->getBasePath(),
                        $this->_request->getHttpHost()
                );
                $paithal = Paithal::getInstance();
                $paithal->user = $user;
                $translate = Zend_Registry::get('translate');
                // add a site message inidcating that login was successfull
                $paithal->siteMessages[] = $translate->_('User login was successfull.');
                // if location is given to return move to there
                if (isset($returnTo) && strlen($returnTo) > 1 && $this->view->currentUri !== $returnTo) {
                    // without adding the comparison $this->view->currentUri !== $returnTo
                    // it controller action calls infinitely. So it may be possible to solve it
                    // more efficiently
                    //throw new Exception( "Error: ".$returnTo) ;
                    $requestNew = new Zend_Controller_Request_Http($returnTo);
                    Zend_Controller_Front::getInstance()->dispatch($requestNew);
                }
            }
        }
        $this->renderView('login_view.php');
    }

    public function logoutAction() {
        $userIdInCookie = $this->_request->getCookie('uid');
        $sessionIdInCookie = $this->_request->getCookie('sid');
        $returnTo = $this->_request->getParam('return');
        require_once APPPATH . '/models/SessionsTable.php';
        $sessionsTable = new SessionsTable();
        // if user is already logged in result of this call will be true
        $sessionEndSuccess = $sessionsTable->end($userIdInCookie, $sessionIdInCookie);
        if ($sessionEndSuccess) {
            // if location to return is given move to there
            if (isset($returnTo) && strlen($returnTo) > 1) {
                $requestNew = new Zend_Controller_Request_Http($returnTo);
                Zend_Controller_Front::getInstance()->dispatch($requestNew);
            }
        } else {  // No active session to end!
            $paithal = Paithal::getInstance();
            $translate = Zend_Registry::get('translate');
            $paithal->siteMessages[] = $translate->_('No user logged in.');
        }
    }

}