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
 * Table adapter for comments table
 * @author Junaid
 * @since 0.1.0
 */
class CommentsTable extends PaithalDbTable {
    protected $_name = 'comments';
    protected $_primary = 'comment_id';

}