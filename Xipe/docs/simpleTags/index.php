<?php
    //
    //  $Id$
    //

//ini_set('include_path',realpath(dirname(__FILE__).'/../../../../../').':'.realpath(dirname(__FILE__).'/../../../../../../includes').':'.ini_get('include_path'));
//ini_set('error_reporting',E_ALL);
    /*
    *   include the files needed
    */
    require_once('HTML/Template/Xipe.php');

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
    $tpl = new HTML_Template_Xipe($options);

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
