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
 * Helper for retirieving current user info
 * @author Junaid P V
 * @since 0.1.0
 */
class Paithal_View_Helper_User extends Zend_View_Helper_Abstract {

    /**
     *
     * @return Paithal_View_Helper_User
     */
    public function user() {
        return $this;
    }

    public function info($key) {
        $paithal = Paithal::getInstance();
        $return = null;
        if ($paithal->user) {
            switch ($key) {
                case 'name':
                    $return = $paithal->user->user_name;
                    break;
                case 'display_name':
                    $return = $paithal->user->user_display_name;
                    break;
                case 'first_name':
                    $return = $paithal->user->user_first_name;
                    break;
                case 'last_name':
                    $return = $paithal->user->user_last_name;
                    break;
                case 'email':
                    $return = $paithal->user->user_email;
                    break;
                case 'created':
                    $return = $paithal->user->user_creation_ts;
                    break;
                default:
                    throw new Exception("No user info for $key");
            }
        } else {
            throw new Exception("Cant retirieve user info $key. User not logged in");
        }
        return $return;
    }

    /**
     * Check whether user is logged in or not
     * @return bool
     */
    public function loggedIn() {
        if(Paithal::getInstance()->user) return true;
        else return false;
    }

}