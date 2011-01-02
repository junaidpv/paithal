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
require_once 'ContentDirectoryRow.php';

/**
 * Table adapter for contents table
 * @author Junaid
 * @since 0.1.0
 */
class ContentsTable extends PaithalDbTable {
    protected $_name = 'contents';
    protected $_primary = 'content_id';
    protected $_rowClass = 'ContentDirectoryRow';

    public function get($name, $path) {
        require_once 'ContentDirectories.php';
        $cDirTable = new ContentDirectoriesTable();
        $cDir = $cDirTable->get($path);
        if(isset ($cDir)) {
            $select = $this->select()
                    ->where('content_name = ?', $name)
                    ->where('content_cdir_id = ?', $cDir);
            $rows = $this->fetchAll($select);
            return $rows->getRow(0);
        }
        return NULL;
    }

    public function getByFullName($fullName) {
        $select = $this->select();
        $lasBSlashPos = strrpos($fullName, '/');
        if(!$lasBSlashPos) { // if the poisiont returned is FALSE
            // backslash is not in the path given
            // if
            $cName = $fullName;
            $cPath = NULL;
        }
        else {
            // path is from 0 to last backslash position found
            $cPath = substr($fullName, 0, $lasBSlashPos);
            // dir name is from last backslash
            $cName = substr($fullName, $lasBSlashPos+1);
        }
        return $this->get($cName, $cPath);
    }

}