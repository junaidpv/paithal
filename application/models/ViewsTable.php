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
 * Table adapter for views table
 * @author Junaid
 * @since 0.1.0
 */
class ViewsTable extends PaithalDbTable {
    protected $_name = 'views';
    protected $_primary = 'view_id';

}