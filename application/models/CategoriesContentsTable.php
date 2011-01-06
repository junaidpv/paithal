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
 * Table adapter for categories_contents table
 * @author Junaid
 * @since 0.1.0
 */
class CategoriesContentsTable extends PaithalDbTable {
    protected $_name = 'categories_contents';

}