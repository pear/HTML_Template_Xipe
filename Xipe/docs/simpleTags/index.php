<?php


    /*
    *   include the files needed
    */
    require_once('SimpleTemplate/Engine.php');

    /*
    *   make template class instance
    */
    $options = array(   'templateDir'       =>  dirname(__FILE__),
                        'enable-XMLConfig'  =>  true,
                        'forceCompile'      =>true,
                        'filterLevel'=>8,
//                        'makePhpTags'=>false,
                        'logLevel'=>2
                        );
    $tpl = new SimpleTemplate_Engine($options);

    /*
    *   fill some vars
    */
    $tasks = array('one','two');

    function test(){return $GLOBALS['tasks'];}

    class u{
    function test()
    {
        return test();
    }}


    /*
    *   show the template
    */
    $tpl->compile('index.tpl');
    include($tpl->getCompiledTemplate());

?>