<?php


    #####################################
    #
    #   include the files needed
    #
    require_once('SimpleTemplate/Engine.php');
    require_once('SimpleTemplate/Filter/Basic.php');

    #####################################
    #
    #   make template class instance
    #
    $options = array(   'templateDir'   => $DOCUMENT_ROOT.'/libs/php/SimpleTemplate/examples/simple',
                        'compileDir'    => 'tmp',   // use the compile dir 'tmp' under the tempalte dir
                        // or use the following line to specifiy a complete path
                        //'compileDir'    => $DOCUMENT_ROOT.'/libs/php/SimpleTemplate/examples/simple/tmp',

                        'verbose'   => true,    // this is default too
                        'locale'    => '',      // there is no language stuff here
                        'logLevel'  => 1,

                        // let me define the filters i want to use
                        'filterLevel'   => 0
                        );
    $tpl = new SimpleTemplate_Engine($options);



    #####################################
    #
    #   make filter class instance
    #
    $tplFilter = new SimpleTemplate_Filter_Basic($tpl->getOptions());
    // pre filter
    $tpl->registerPrefilter(array(&$tplFilter,'removeHtmlComments'));
    $tpl->registerPrefilter(array(&$tplFilter,'removeCStyleComments'));
    $tpl->registerPrefilter(array(&$tplFilter,'addIfBeforeForeach'));   // this filter makes the foreach-blocks conditional, so they are only shown if they contain data, see api-doc
    // post filter
    $tpl->registerPostfilter(array(&$tplFilter,'trimLines'));
    $tpl->registerPostfilter(array(&$tplFilter,'optimizeHtmlCode'));



    #####################################
    #
    #   fill variables used in the template
    #   no assign-method necessary
    #
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



    #####################################
    #
    #   show the template
    #
    $tpl->compile('index.tpl');
    include($tpl->getCompiledTemplate());

?>