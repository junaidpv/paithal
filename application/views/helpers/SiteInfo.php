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
class Paithal_View_Helper_SiteInfo extends Zend_View_Helper_Abstract {

    public function siteInfo($key) {
        $settings = Paithal::getInstance()->settings;
        if(!isset ($settings[$key])) {
            throw new Exception("No value for $key in site settings");
        }
        return $settings[$key];
    }

}