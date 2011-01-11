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
 * Table adapter for content types table
 * @author Junaid
 * @since 0.1.0
 */
class ContentTypes extends PaithalDbTable {
    protected $_name = 'content_types';
    protected $_primary = 'ctype_id';

    public function exist($contentTypeId) {
        $rows = $this->find($contentTypeId);
        if(count($rows)==1) {
            return true;
        }
        return false;
    }
}