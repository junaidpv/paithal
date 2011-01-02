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

    public $userId;


        /**
     * This class can have only one instance.
     * Direct instance creation not allowed
     */
    private function __construct() {
        // loads sites configuration
        require BASEPATH . '/sites/sites.php';
    }

    /**
     * Return the one and only instance of the class
     * @return Paithal
     */
    public function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function loadConfiguration() {
        // default site to work
        $this->siteDir = 'default';
        // current domain
        $currentDomain = $_SERVER['HTTP_HOST'];
        // sites configuration
        $sites = $GLOBALS['sites'];
        // if multiple sites are specified and
        // current domain is mapped in it
        if (isset($sites) && in_array($currentDomain, array_keys($sites))) {
            $this->siteDir = $sites[$currentDomain];
        }
        // full name of configuration file to be loaded
        $configFileName = BASEPATH."/sites/{$this->siteDir}/config.php";
        // Load configuration file if it exists
        if(file_exists($configFileName)) {
            // load sites configurations
            require BASEPATH."/sites/{$this->siteDir}/config.php";
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
        // Globally defined site configuration data
        $config = $GLOBALS['config'];
        // if configuration data does not exist,
        // throw an error
        if(!isset ($config)) {
            $exception = new Exception('Configuration not set for the site.');
            throw $exception;
        }
        if(!isset ($config['database'])) {
            $exception = new Exception('Database configuration not set for the site.');
            throw $exception;
        }
        // Prepare database adapter
        require_once 'Zend/Db.php';
        $db = Zend_Db::factory($config['databse']);
        require_once BASEPATH.'/application/models/PaithalDbTable.php';
        // set default database adapter
        PaithalDbTable::setDefaultAdapter($db);
        PaithalDbTable::setTablePrefix($config['database']['prefix']);
    }

    public function loadSiteSettings() {
        require_once BASEPATH.'/application/models/SiteSettingsTable.php';
        $siteSettingsTable = new SiteSettings();
        $this->settings = $siteSettingsTable->get();
    }

    /**
     * Initialize theme related settings
     * 
     */
    public function initTheme() {
        $themeName = $this->settings['theme'];
        $this->themeDir = $this->siteDir.'/'.$this->themeDir;
    }

    public function prepareSession() {
        require_once BASEPATH.'/application/models/SessionTable.php';
        $sessionTable = new SessionsTable();
        $session = $sessionTable->get();
        if(isset ($session) && $session->isValid()) {
            require_once BASEPATH.'/application/UsersTable.php';
            $usersTable = new UsersTable();
            $user = $usersTable->get($session->session_user_id);
            $this->user = $user;
        }
    }

}