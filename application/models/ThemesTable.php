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
 * Table adapter for themes table
 * @author Junaid
 * @since 0.1.0
 */
class ThemesTable extends PaithalDbTable {
    protected $_name = 'themes';
    protected $_primary = 'theme_id';

    public function loadTheme($themeName) {
        require_once 'ViewsTable.php';
        $viewsTable = new ViewsTable();
        $select = $this->getDefaultAdapter()->select();
        $select = $select->from($this->getName())
                ->from($viewsTable->getName(), array('view_id', 'view_name', 'view_desc'))
                ->where('view_id = theme_default_view_id')
                ->where('theme_name = ?', $themeName);
        $rows = $this->getDefaultAdapter()->fetchAll($select);
        if(isset ($rows[0])) {
            return $rows[0];
        }
        return null;
    }
}