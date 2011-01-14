<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');

/**
 * @package application/modules/default/controllers
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * Helper for retirieving contents for the current view
 * @author Junaid P V
 * @since 0.1.0
 */
class Paithal_View_Helper_GetContentsList extends Zend_View_Helper_Abstract {

    public function getContentsList($params=null) {
        if(!isset ($params)) {
            $params = $this->view->params;
        }
        require_once APPPATH.'/models/ContentsTable.php';
        $contentsTable = new ContentsTable();
        return $contentsTable->getList($params);
    }

}