<?php
    //
    // +----------------------------------------------------------------------+
    // | PHP Version 4                                                        |
    // +----------------------------------------------------------------------+
    // | Copyright (c) 1997, 1998, 1999, 2000, 2001, 2002, 2003 The PHP Group |
    // +----------------------------------------------------------------------+
    // | This source file is subject to version 2.02 of the PHP license,      |
    // | that is bundled with this package in the file LICENSE, and is        |
    // | available at through the world-wide-web at                           |
    // | http://www.php.net/license/2_02.txt.                                 |
    // | If you did not receive a copy of the PHP license and are unable to   |
    // | obtain it through the world-wide-web, please send a note to          |
    // | license@php.net so we can mail you a copy immediately.               |
    // +----------------------------------------------------------------------+
    // | Authors: Wolfram Kriesing <wolfram@kriesing.de>                      |
    // +----------------------------------------------------------------------+
    //  $Id$


    //
    //   include the files needed
    //
//ini_set('include_path',realpath(dirname(__FILE__).'/../../../../../').':'.realpath(dirname(__FILE__).'/../../../../../../includes').':'.ini_get('include_path'));
//ini_set('error_reporting',E_ALL);
    require_once 'HTML/Template/Xipe.php';

    //
    //   make template class instance
    //
    $options = array(   'templateDir'   => dirname(__FILE__),
                        'compileDir'    => 'tmp',   // this is default too
                        'enable-Cache'  => true,
                        'logLevel'      => 1
                        //,'debug'=>1
                        );
    $tpl = new HTML_Template_Xipe($options);




    $tplFile = 'index.tpl';
    // if the final output is not cached do the heavy work here
    if( !$tpl->isCached($tplFile) )
    {
        print 'CACHE MISS, GENERATING CACHE FILE NOW!';
    }


    $tpl->compile($tplFile);                        // call this method also if cached, to generate the property used in getCompiledTemplate()
                                                    // if the file is cached no compilation is done
    include($tpl->getCompiledTemplate());           // include the (cached) file

?>
