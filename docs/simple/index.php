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

ini_set('include_path',realpath(dirname(__FILE__).'/../../../../../').':'.realpath(dirname(__FILE__).'/../../../../../../includes').':'.ini_get('include_path'));
ini_set('error_reporting',E_ALL);

    //
    //   include the files needed
    //
    require_once('HTML/Template/Xipe.php');
    require_once('HTML/Template/Xipe/Filter/Basic.php');

    //
    //   make template class instance
    //
    $options = array(   'templateDir'   => dirname(__FILE__),
                        'compileDir'    => 'tmp',   // use the compile dir 'tmp' under the tempalte dir
                        // or use the following line to specifiy a complete path
                        //'compileDir'    => $DOCUMENT_ROOT.'/libs/php/SimpleTemplate/examples/simple/tmp',

                        'verbose'   => true,    // this is default too
                        'locale'    => '',      // there is no language stuff here
                        'logLevel'  => 1,       // write log-file

                        // let me define the filters i want to use
                        'filterLevel'   => 0    // level 0 means no filter by default
                        );
    $tpl = new HTML_Template_Xipe($options);



    //
    //   make filter class instance
    //   and apply filters as needed
    //
    $tplFilter = new HTML_Template_Xipe_Filter_Basic($tpl->getOptions());
    // pre filter
    $tpl->registerPrefilter(array(&$tplFilter,'removeHtmlComments'));
    $tpl->registerPrefilter(array(&$tplFilter,'removeCStyleComments'));
    $tpl->registerPrefilter(array(&$tplFilter,'addIfBeforeForeach'));   // this filter makes the foreach-blocks conditional, so they are only shown if they contain data, see api-doc
    // post filter
    $tpl->registerPostfilter(array(&$tplFilter,'trimLines'));
    $tpl->registerPostfilter(array(&$tplFilter,'optimizeHtmlCode'));



    //
    //   fill variables used in the template
    //   no assign-method necessary
    //
    $advantages = array(    'clean HTML-code',
                            'ALL the power of PHP inside a template',
                            'a compiled template',
                            'easy to use (template) engine');

    $dontLike = array(  'php-tags in your html',
                        'the braces: "{" and "}", since they could be replaced by proper indention',
                        'to learn a new template language');

    $viewSourceCodeUrl = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/simple/index.php';
    $viewTemplateCodeUrl = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/simple/index.tpl';
    $viewClassCodeUrl = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/Engine.php';
    $viewCompiledTemplate = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/simple/tmp/index.tpl.en.php';
    $viewTemplateLog = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/simple/tmp/index.tpl.log';



    //
    //   show the template
    //
    $tpl->compile('index.tpl');
    include($tpl->getCompiledTemplate());

?>
