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
    $options = array(   'templateDir'   => $DOCUMENT_ROOT.'/libs/php/SimpleTemplate/examples/xmlConfig',
                        'compileDir'    => $DOCUMENT_ROOT.'/libs/php/SimpleTemplate/examples/xmlConfig/tmp');
    $tpl = new SimpleTemplate_Engine($options);

#$tpl->setOption('forceCompile',true);

    #####################################
    #
    #   make filter class instance
    #
    $tplFilter = new SimpleTemplate_Filter_Basic($tpl->options);
    // pre filter
    $tpl->registerPrefilter('removeHtmlComments',$tplFilter);
    $tpl->registerPrefilter('removeCStyleComments',$tplFilter);
    $tpl->registerPrefilter('addIfBeforeForeach',$tplFilter);   // this filter makes the foreach-blocks conditional, so they are only shown if they contain data, see api-doc

    // post filter
#    $tpl->registerPostfilter('trimLines',$tplFilter);
#    $tpl->registerPostfilter('optimizeHtmlCode',$tplFilter);

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

    $url = 'http://www.kriesing.de/showsource.php?domain=wolfram.kriesing.de&file=/libs/php/SimpleTemplate/examples/xmlConfig/';
    $viewSourceCodeUrl = $url.'index.php';
    $viewTemplateCodeUrl = $url.'index.tpl';
    $viewCompiledTemplate = $url.'tmp/index.tpl.en.php';
    $viewTemplateLog = $url.'tmp/index.tpl.log';
    $viewConfigXmlUrl = $url.'config.xml';



    #####################################
    #
    #   show the template
    #
    $tpl->compile('index.tpl');
    include($tpl->compiledTemplate);

?>