<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package appplication/model
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */
require_once 'PaithalDbTable.php';
/**
 * Table adapter for site_settings table
 * @author Junaid
 * @since 0.1.0
 */
class SiteSettings extends PaithalDbTable {

    protected $_name = 'site_settings';
    protected $_primary = 'ss_name';
    /**
     * Primary key is not autoincrementing one
     * @var bool
     */
    protected $_sequence = false;

    /**
     * Fetch all site settings from the database
     * @return array
     */
    public function get() {
        $rows = $this->fetchAll();
        $settings = array();
        foreach($rows as $row) {
            $item['ss_name']=$row['ss_name'];
            $item['ss_value'] = $row['ss_value'];
            $settings[] = $item;
        }
        return $settings;
    }
}