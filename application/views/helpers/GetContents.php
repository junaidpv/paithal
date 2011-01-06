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
class Paithal_View_Helper_GetContents extends Zend_View_Helper_Abstract {

    public function getContents() {

        foreach ($this->view->contentParams as $paramType => $paramValue) {
            require_once BASEPATH . '/application/models/ContentsTable.php';
            $contentsTable = new ContentsTable();
            if ($paramType == 'ids') {
                $contents = $contentsTable->find($paramValue);
            }
        }
    }

}