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

    /**
     *
     * @return Zend_Db_Select
     */
    private function getBasicSelect() {
        require_once 'RevisionsTable.php';
        $revisionsTable = new RevisionsTable();
        require_once 'CommentsTable.php';
        $commentsTable = new CommentsTable();

        $db = $this->getDefaultAdapter();
        $select = $db->select()
                        ->from($this->getName())
                        ->from($revisionsTable->getName())
                        ->from($commentsTable->getName(), array('comment_count' => 'COUNT(*)'))
                        ->where('rev_id = content_rev_id')
                        ->where('comment_content_id = content_id');
        return $select;
    }

    /*
      public function get($name, $path) {
      require_once 'ContentDirectories.php';
      $cDirTable = new ContentDirectoriesTable();
      $cDir = $cDirTable->get($path);
      if (isset($cDir)) {
      $select = $this->select()
      ->where('content_name = ?', $name)
      ->where('content_cdir_id = ?', $cDir);
      $rows = $this->fetchAll($select);
      return $rows->getRow(0);
      }
      return NULL;
      } */

    public function getByIds($ids) {
        $select = $this->getBasicSelect();
        foreach($ids as $id) {
            $select = $select->where('content_id = ?', $id);
        }
        return $this->getDefaultAdapter()->fetchAll($select);
    }

    public function getByFullName($fullName) {
        
        $select = $this->getBasicSelect()
                        ->where('content_name = ?', $fullName);
        $rows = $db->fetchAll($select);
        return $rows;
    }

    /**
     * Return contents that have been included in one of given categories.
     * @param string|array $categories
     * @return array
     */
    public function getByCategories($categories) {
        require_once 'CategoriesContentsTable.php';
        $categoriesContentsTable = new CategoriesContentsTable();
        $select = $this->getBasicSelect()
                        ->from($categoriesContentsTable->getName());
        $i = 0;
        $catCount = count($categories);
        for ($i = 0; $i < $catCount; $i++) {
            if ($i == 0) {
                $select = $select->where('cat_name = ?', $categories[$i]);
            } else {
                $select = $select->orWhere('cat_name = ?', $categories[$i]);
            }
        }
        $select = $select->where('catc_cat_id = cat_id')
                        ->where('content_id = catc_content_id');
        return $db->fetchAll($select);
    }

    public function getByTags($tags) {
        require_once 'TagsContentsTable.php';
        $tagsContentsTable = new TagsContentsTable();
        $select = $this->getBasicSelect()
                        ->from($tagsContentsTable->getName());
        $i = 0;
        $catCount = count($tags);
        for ($i = 0; $i < $catCount; $i++) {
            if ($i == 0) {
                $select = $select->where('tag_name = ?', $tags[$i]);
            } else {
                $select = $select->orWhere('tag_name = ?', $tags[$i]);
            }
        }
        $select = $select->where('tagc_tag_id = tag_id')
                        ->where('content_id = tagc_content_id');
        return $db->fetchAll($select);
    }

}