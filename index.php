<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Paithal CMS first running file.
 *
 * @author Junaid P V
 * @version 0.1.0
 * @license GPLv3
 * Date: 2010-12-14
 */

// defining BASEPATH so we always get base path of the application
define('BASEPATH', dirname(__FILE__));

require 'config/config.php';

// Seperate library file in seperate directory
if (isset($config['LIBPATH']))
    define('LIBPATH', $config['LIBPATH']);
else
    define('LIBPATH', dirname(__FILE__) . '/../library');

// defining application path so relative referencing would become easy
if (isset($config['APPPATH']))
    define('APPPATH', $config['APPPATH']);
else    // if no application path set, we set default location
    define('APPPATH', dirname(__FILE__) . '/application');

if (isset($config['syslib']))
    define('SYSLIB', $config['syslib']);
else
    define('SYSLIB', dirname(__FILE__) . '/library');

// Specify location of Zend library, So we can utilize its library
// It is mandatory, because this CMS is built on top of the Zend framework
set_include_path(get_include_path() . PATH_SEPARATOR . LIBPATH. PATH_SEPARATOR . SYSLIB);

require_once 'system/paithal/Paithal.php';
$paithal = Paithal::getInstance();
$paithal->loadConfiguration();
$paithal->initDb();
$paithal->loadSiteSettings();
$paithal->initTheme();

require 'Zend/Controller/Front.php';
require 'Zend/Session.php';
require_once 'Zend/Registry.php';

Zend_Session::start();

// Get one and only Front Controller instance
$frontController = Zend_Controller_Front::getInstance();

// set module controller directories
$frontController->addControllerDirectory(APPPATH.'/controllers/default', 'default');
$frontController->addControllerDirectory(APPPATH.'/controllers/admin', 'admin');
$frontController->addControllerDirectory('application/controllers/view', 'view');

// we never use automatic rendering of view scripts
// we have to build out page parts manually
$frontController->setParam('noViewRenderer', true);
$frontController->dispatch();