<?php
error_reporting(E_ALL);
/**
 * Paithal CMS first running file.
 *
 * @author Junaid P V
 * @version 0.1.0
 * @license GPLv3
 * Date: 2010-12-14
 */

require_once 'Zend/Controller/Front.php';

// Specify location of Zend library, So we can utilize its library
// It is mandatory, because this CMS is built on top of the Zend framework
set_include_path(get_include_path().PATH_SEPARATOR.'../library');

// Get one and only Front Controller instance
$frontController = Zend_Controller_Front::getInstance();

// set cotrollers directory
$frontController->setControllerDirectory(dirname(__FILE__).'/application/controllers');

// we never use automatic rendering of view scripts
// we have to build out page parts manually
$frontController->setParam('noViewRenderer', true);

$frontController->run('application/controllers');