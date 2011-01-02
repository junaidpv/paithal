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
 * Table adapter for contents table
 * @author Junaid
 * @since 0.1.0
 */
class ContentDirectoriesTable extends PaithalDbTable {
    protected $_name = 'content_directories';
    protected $_primary = 'cdir_id';

    /**
     *  Returns a content directory row object
     * @param string $fullPath
     * @return ContentDirectoryRow
     */
    public function get($fullPath) {
        $select = $this->select();
        $lasBSlashPos = strrpos($fullPath, '/');
        if(!$lasBSlashPos) { // if the poisiont returned is FALSE
            // backslash is not in the path given
            // if

            $select = $select->where('cdir_name = ?', $fullPath)
                    ->where('cdir_path = NULL');
        }
        else {
            // path is from 0 to last backslash position found
            $path = substr($fullPath, 0, $lasBSlashPos);
            // dir name is from last backslash 
            $dirName = substr($fullPath, $lasBSlashPos+1);
            $select = $select->where('cdir_name = ?', $dirName)
                    ->where('cdir_path = ?',$path);
        }
        $rows = $this->fetchAll($select);
        return $rows->getRow(0);
    }
}