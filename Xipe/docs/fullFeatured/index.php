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

ini_set('include_path',ini_get('include_path').':'.dirname(__FILE__).'/../../../../..'.':'.dirname(__FILE__).'/../../../../../../includes/');

    //
    //   make template class instance
    //
    require_once('HTML/Template/Xipe.php');

    $options = array(   'templateDir'   => dirname(__FILE__)
                        //,'debug'=>true
                        );

    $tpl = new HTML_Template_Xipe($options);

    //
    //   apply translating filters to the template
    //
    // this is in PEAR, get the newest version from the cvs
    // for more info see: http://www.php.net/anoncvs.php
    // source is at: http://cvs.php.net/cvs.php/pear/I18N
    require_once('I18N/Messages/Translate.php');
    require_once('HTML/Template/Xipe/Filter/Translate.php');

    $translator = new I18N_Messages_Translate($DB_DSN,array('tablePrefix'=>'translate_'));

    function translateAndPrint( $string )
    {
        global $translator, $lang;
        $translated = $translator->simpleTranslate($string,$lang);  // only translate exact matches
        echo $translated;
    }

    if( $lang )
    {

        $tpl->setOption('locale',$lang);
        $tpl->registerPostfilter(array(&$translator,'translateMarkUpString'), $lang );

        // this filter translates PHP-generated text
        // it simply does out of < ? =$text ? >  this < ? =translateAndPrint($text) ? >
        // but only within the $translator->possibleMarkUpDelimiters, so not every
        // < ?= is translated !!! since that is not wanted anyway,
        // i.e. think of "<td colspan={$colspan}>" - doesnt need translation
        $translateFilter = new HTML_Template_Xipe_Filter_Translate($tpl->getOptions());
/*
        $tpl->registerPostfilter(   array(&$translateFilter,'applyTranslateFunction'),
                                    array('translateAndPrint',$translator->possibleMarkUpDelimiters) );
*/

        // this filter will only translate PHP-variables that start with 'T_', i.e. $T_foo
        // but not $foo as the method above would
        $tpl->registerPostfilter(   array(&$translateFilter,'translateMarkedOnly'),
                                    array('translateAndPrint','T_') );

    }


    //
    //   fill variables used in the template
    //   no assign-method necessary
    //
    $repeatValue = 3;
    $trimValue = 'Hi guys, how is it going?';
    $loop = array('one','two','three');

    $url = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/';
    $viewSourceCodeUrl = $url.'fullFeatured/index.php';
    $viewTemplateCodeUrl = $url.'fullFeatured/index.tpl';
    $viewCompiledTemplate = $url.'fullFeatured/tmp/index.tpl.en.php';
    $viewCompiledTemplateDe = $url.'fullFeatured/tmp/index.tpl.de.php';
    $viewTemplateLog = $url.'fullFeatured/tmp/index.tpl.log';
    $viewDbFile = $url.'translate.sql';

    $url = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/';
    $viewClassCodeUrl = $url.'Engine.php';
    $viewFilterCodeUrl = $url.'Filter/Basic.php';
    $viewTagLibCodeUrl = $url.'Filter/TagLib.php';

    $languages = array('german','english');

    //
    //   show the template
    //
    $tpl->compile('index.tpl');
    include($tpl->getCompiledTemplate());

?>
