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

    public function addContent($data=array()) {
        $error = false;
        $translate = Zend_Registry::get('translate');
        $userId = Paithal::getInstance()->user->user_id;
        $timeStamp = time();
        $contentName = $data['content_name'];
        $contentCreationTS = $timeStamp;
        $contentTitle = $data['content_title'];
        $contentUserId = $userId;
        $contentOwnerId = $userId;
        $contentCTypeId = $data['content_ctype_id'];
        $contentViewId = $data['content_view_id'];
        $contentPublishTS = $data['content_publish_ts'];

        if($this->exist($contentName)) {
            $error = true;
            $this->errors['content_name'] = sprintf($translate->_("A content already exist with name: %s."), $contentName);
        }
        if(!isset ($contentTitle) || strlen($contentTitle)) {
            $error = true;
            $this->errors['content_title'] = $translate->_("Content title is required.");
        }
        require_once 'ContentTypesTable.php';
        $contentTypesTable = new ContentTypes();
        if(!isset ($contentCTypeId) || !$contentTypesTable->exist($contentCTypeId)) {
            $error = true;
            $this->errors['content_ctype_id'] = $translate->_("Content type not specified or does not exist.");
        }
        if(!isset ($contentPublishTS)) {
            $error = true;
            $this->errors['content_publish_ts'] = $translate->_("Publish date and time not specified");
        }

        $content = $this->createRow();

        $revModificationTS = $timeStamp;
        $revText = $data['rev_text'];
        $revComment = $data['rev_text'];
        $revUserId = $userId;
        $revUserText = $data['rev_user_text'];
        $revParentId = $data['rev_parent_id'];
        $revFormatId = $data['rev_format_id'];

    }

    public function exist($contentName) {
        $select = $this->select()
                ->where('content_name = ?', $contentName);
        $rows = $this->fetchAll($select);
        if(count($rows)==0) {
            return true;
        }
        return false;
    }

}