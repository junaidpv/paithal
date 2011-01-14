<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');

/**
 * @package application/views/helpers
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'Zend/View/Helper/Abstract.php';

/**
 * Helper for rendering built in scripts
 * @author Junaid P V
 * @since 0.1.0
 */
class Paithal_View_Helper_RenderCommon extends Zend_View_Helper_Abstract {

    public function renderCommon($script) {
        if(!isset ($script) || strlen($script)<1) {
            throw new Exception('Common rendering: script not specified');
        }
        return $this->view->render("$script.php");
    }

}