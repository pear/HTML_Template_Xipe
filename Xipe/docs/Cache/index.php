<?php


    #####################################
    #
    #   include the files needed
    #
    require_once('SimpleTemplate/Engine.php');

    #####################################
    #
    #   make template class instance
    #
    $options = array(   'templateDir'   => dirname(__FILE__),
                        'compileDir'    => 'tmp',   // this is default too
                        'enable-Cache'  => true,
                        'logLevel'      => 1
                        #,'debug'=>1
                        );
    $tpl = new SimpleTemplate_Engine($options);




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