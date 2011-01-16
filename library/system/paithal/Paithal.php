<?php

if (!defined('BASEPATH'))
    die('Direct script access not allowed');
/**
 * @package system/paithal
 * @author Junaid P V
 * @license GPLv3
 * @since 0.1.0
 */

/**
 * System main class that controll all flows of execution
 * This class implement singleten pattern
 * @author Junaid P V
 * @since 0.1.0
 */
class Paithal {

    /**
     * The only instance of this class as class variable
     * @var Paithal
     */
    private static $_instance;
    /**
     * Site settings arrya read from database
     * @var array
     */
    public $settings;
    public $siteDir;
    public $themeDir;
    /**
     *
     * @var UserRow
     */
    public $user;
    public $baseUrl;
    public $config;
    public $viewName;

    public $formMessages = array();
    public $siteMessages = array();

    /**
     * This class can have only one instance.
     * Direct instance creation not allowed
     */
    private function __construct() {
        $siteConfigFileName = BASEPATH . '/sites/sites.php';
        if (file_exists($siteConfigFileName)) {
            // loads sites configuration
            require BASEPATH . '/sites/sites.php';
        }
    }

    /**
     * Return the one and only instance of the class
     * @return Paithal
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function setBaseUrl($baseurl) {
        self::$_instance->baseUrl = $baseUrl;
    }

    public function loadConfiguration() {
        // default site to work
        $siteDirName = 'default';
        if (isset($GLOBALS['sites'])) {
            // current domain
            $currentDomain = $_SERVER['HTTP_HOST'];
            // sites configuration
            $sites = $GLOBALS['sites'];
            // if multiple sites are specified and
            // current domain is mapped in it
            if (in_array($currentDomain, array_keys($sites))) {
                $siteDirName = $sites[$currentDomain];
            }
        }
        $this->siteDir = BASEPATH . "/sites/{$siteDirName}";
        // full name of configuration file to be loaded
        $configFileName = $this->siteDir. "/config/config.php";
        // Load configuration file if it exists
        if (file_exists($configFileName)) {
            // load sites configurations
            require $configFileName ;
            $this->config = $config;
        }
        // If configuration file does not exist.
        else {
            // throw an error indicating it
            $exception = new Exception('Site configuration file does not exist.');
            throw $exception;
        }
    }

    /**
     * Initialize database
     */
    public function initDb() {
        // if configuration data does not exist,
        // throw an error
        if (!isset($this->config)) {
            $exception = new Exception('Configuration not set for the site.');
            throw $exception;
        }
        if (!isset($this->config ['database'])) {
            $exception = new Exception('Database configuration not set for the site.');
            throw $exception;
        }
        // Prepare database adapter
        require_once 'Zend/Db.php';
        $db = Zend_Db::factory($this->config ['database']['adapter'], $this->config ['database']['params']);
        require_once BASEPATH . '/application/models/PaithalDbTable.php';
        // set default database adapter
        PaithalDbTable::setDefaultAdapter($db);
        PaithalDbTable::setTablePrefix($this->config['database']['prefix']);
    }

    public function loadSiteSettings() {
        require_once APPPATH . '/models/SiteSettingsTable.php';
        $siteSettingsTable = new SiteSettings();
        $this->settings = $siteSettingsTable->get();
    }

    /**
     * Initialize theme related settings
     * 
     */
    public function initTheme() {
        $themeName = $this->settings["theme"];
        $this->themeDir = $this->siteDir . '/themes/' . $themeName;
        require_once APPPATH.'/models/ThemesTable.php';
        $themesTable = new ThemesTable();
        $theme = $themesTable->loadTheme($themeName);
        $this->viewName = '';
        if(isset ($theme) && isset ($theme['view_name'])) {
            $this->viewName = $theme['view_name'];
        }
    }

    public function prepareSession() {
        require_once APPPATH.'/models/SessionsTable.php';
        $userIdInCookie = null;
        $sessionIdInCookie = null;
        if(isset ($_COOKIE['uid']) && strlen($_COOKIE['uid'])) {
            $userIdInCookie = $_COOKIE['user_id'];
        }
        if(isset ($_COOKIE['sid']) && strlen($_COOKIE['sid'])) {
            $sessionIdInCookie = $_COOKIE['sid'];
        }
        $sessionTable = new SessionsTable();
        $session = $sessionTable->get($userIdInCookie, $sessionIdInCookie);
        if (isset($session) && $session->isValid()) {
            require_once APPPATH . '/models/UsersTable.php';
            $usersTable = new UsersTable();
            $this->user = $usersTable->get($session->session_user_id);
            // update session last timestamp
            $session->session_last_ts = time();
        }
    }

}