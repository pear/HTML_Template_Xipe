<?php
//
//  $Id$
//


ini_set('include_path',realpath(dirname(__FILE__).'/../../../').':'.realpath(dirname(__FILE__).'/../../../../includes').':'.ini_get('include_path'));
require_once 'PHPUnit.php';
require_once 'PHPUnit/GUI/HTML.php';
ini_set('error_reporting',E_ALL);

require_once 'HTML/Template/Xipe.php';

//
//  run the test suite
//
require_once 'PHPUnit/GUI/SetupDecorator.php';
$gui = new PHPUnit_GUI_SetupDecorator(new PHPUnit_GUI_HTML());
// use all php files from in this directory and all subdirs
// but exclude the files UnitTest.php and index.php
$gui->getSuitesFromDir(dirname(__FILE__),'.*[^_]\.php$',array('UnitTest.php','index.php'));
$gui->show();

?>
