<?php


    require_once('../../config.php');


    #####################################
    #
    #   make template class instance
    #
    require_once('SimpleTemplate/Engine.php');

    $options = array(   'templateDir'   => $DOCUMENT_ROOT.'/libs/php/examples/SimpleTemplate/fullFeatured',
                        'compileDir'    => $DOCUMENT_ROOT.'/libs/php/examples/SimpleTemplate/fullFeatured/tmp');

    $tpl = new SimpleTemplate_Engine($options);



    #####################################
    #
    #   apply basic filters to the template
    #
    require_once('SimpleTemplate/Filter/Basic.php');

    $tplFilter = new SimpleTemplate_Filter_Basic($tpl->options);
    // pre filter
    $tpl->registerPrefilter('removeHtmlComments',$tplFilter);
    $tpl->registerPrefilter('removeCStyleComments',$tplFilter);
    $tpl->registerPrefilter('addIfBeforeForeach',$tplFilter);   // this filter makes the foreach-blocks conditional, so they are only shown if they contain data, see api-doc
    // post filter
    $tpl->registerPostfilter('trimLines',$tplFilter);
    $tpl->registerPostfilter('optimizeHtmlCode',$tplFilter);



    #####################################
    #
    #   apply TagLib filters to the template
    #
    require_once('SimpleTemplate/Filter/TagLib.php');

    $tagLib = new SimpleTemplate_Filter_TagLib($tpl->options);
    $tpl->registerPrefilter('includeFile',$tagLib);
    $tpl->registerPrefilter('block',$tagLib);
    // do 'block' and 'include' before other tags, so the other tags also work
    // when they were used in a block !!!
    $tpl->registerPrefilter('trim',$tagLib);
    $tpl->registerPrefilter('repeat',$tagLib);



    #####################################
    #
    #   apply translating filters to the template
    #
    require_once('Language/Translate.php');

    $translator = new Language_Translate($DB_DSN,array('tablePrefix'=>'translate_'));

    function translateAndPrint( $string )
    {
        global $translator, $lang;
        $translated = $translator->simpleTranslate($string,$lang);  // only translate exact matches
        echo $translated;
    }

    if( $lang )
    {

        $tpl->setOption('locale',$lang);
        $tpl->registerPostfilter('translateMarkUpString',array( $translator , $lang ) );

        // this filter translates PHP-generated text
        // it simply does out of < ? =$text ? >  this < ? =translateAndPrint($text) ? >
        // but only within the $translator->possibleMarkUpDelimiters, so not every
        // < ?= is translated !!! since that is not wanted anyway,
        // i.e. think of "<td colspan={$colspan}>" - doesnt need translation
        $tpl->registerPostfilter('applyTranslateFunction',array($tplFilter,'translateAndPrint',$translator->possibleMarkUpDelimiters) );

    }


    #####################################
    #
    #   fill variables used in the template
    #   no assign-method necessary
    #
    $repeatValue = 3;
    $trimValue = 'Hi guys, how is it going?';
    $loop = array('one','two','three');

    $viewSourceCodeUrl = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/fullFeatured/index.php";
    $viewTemplateCodeUrl = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/fullFeatured/index.tpl";
    $viewCompiledTemplate = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/fullFeatured/tmp/index.tpl.en.php";
    $viewCompiledTemplateDe = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/fullFeatured/tmp/index.tpl.de.php";
    $viewTemplateLog = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/fullFeatured/tmp/index.tpl.log";
    $viewDbFile = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/examples/SimpleTemplate/translate.sql";

    $viewClassCodeUrl = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/SimpleTemplate/Engine.php";
    $viewFilterCodeUrl = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/SimpleTemplate/Filter/Basic.php";
    $viewTagLibCodeUrl = "http://www.kriesing.de/showsource.php?domain=$HTTP_HOST&file=/libs/php/SimpleTemplate/Filter/TagLib.php";

    #####################################
    #
    #   show the template
    #
    $tpl->compile('index.tpl');
    include($tpl->compiledTemplate);

?>