<?php

    #
    #   author      wolfram@kriesing.de
    #
    # $Id$

    require_once('../../../examples/config.php');


    #####################################
    #
    #   make template class instance
    #
    require_once('SimpleTemplate/Engine.php');

    $options = array(   'templateDir'   => dirname(__FILE__),
                        'compileDir'    => 'tmp'    //
                        #,'debug'=>true
                        );

    $tpl = new SimpleTemplate_Engine($options);

    #####################################
    #
    #   apply translating filters to the template
    #
    // this is in PEAR, get the newest version from the cvs
    // for more info see: http://www.php.net/anoncvs.php
    // source is at: http://cvs.php.net/cvs.php/pear/I18N
    require_once('I18N/Messages/Translate.php');
    require_once('SimpleTemplate/Filter/Translate.php');

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
        $translateFilter = new SimpleTemplate_Filter_Translate($tpl->getOptions());
        $tpl->registerPostfilter(   array(&$translateFilter,'applyTranslateFunction'),
                                    array('translateAndPrint',$translator->possibleMarkUpDelimiters) );

    }


    #####################################
    #
    #   fill variables used in the template
    #   no assign-method necessary
    #
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

    #####################################
    #
    #   show the template
    #
    $tpl->compile('index.tpl');
    include($tpl->getCompiledTemplate());

?>