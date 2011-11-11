<?php
//
//  $Id$
//

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'HTML/Template/Xipe.php';

define('CONSTANT','constant');

class MakePhpTagsTest extends PhpUnit_Framework_TestCase
{
    /**
    *   @var    object  the Xipe object to use
    */
    var $_xipe = null;

    function setUp()
    {
        $options = array(   'templateDir'   => realpath(dirname(__FILE__)),
                            'compileDir'    => 'tmp',   // use the compile dir 'tmp' under the tempalte dir
                            'verbose'   => true,        // this is default too
                            'logLevel'  => 0,           // dont write log files
                            'filterLevel'   => 10,      // apply all the most common filters
                            'locale'        =>  '_'    //
                            ,'forceCompile' =>  true
                            ,'autoBraces'   =>  false
                            );
        $this->_xipe =& new HTML_Template_Xipe($options);

    }


    function test_echoConstants()
    {
        $content = $this->_xipe->getRenderedTemplate('tpl/simple.tpl', array('test'=>1));
        $expected = "1constantconstantconstant";
        $this->assertEqualsString($expected,$content);
    }

    /**
    *   test that {$var} gets printed
    *
    *
    */
    function test_echoVariables()
    {
        $content = $this->_xipe->getRenderedTemplate('tpl/simple.tpl',array('test'=>1));
        // replace the constant just so the test passes before and after
        // {CONSTANT} works, we wnat to check something else here
        $content = str_replace(CONSTANT,'',$content);
        $expected = '1';
        $this->assertEqualsString($expected,$content);
    }

    /**
    *   Check that {if|foreach|while|etc.()} wont be printed
    *
    *
    */
    function test_dontEchoControlStructures()
    {
        $content = $this->_xipe->getRenderedTemplate('tpl/simple.tpl',array('test'=>1));
        // replace the constant just so the test passes before and after
        // {CONSTANT} works, we wnat to check something else here
        $content = str_replace(CONSTANT,'',$content);
        $expected = '1';
        $this->assertEqualsString($expected,$content);
    }


    /**
    *   This is just a special assert, which removes whitepsaces, so we can easier check.
    *
    *
    */
    function assertEqualsString($expected,$actual,$message='')
    {
        $expected = trim($expected);
        $expected = str_replace("\r",'',$expected);
        $expected = str_replace("\n",'',$expected);
        $expected = str_replace(' ','',$expected);
        $actual = trim($actual);
        $actual = str_replace("\r",'',$actual);
        $actual = str_replace("\n",'',$actual);
        $actual = str_replace(' ','',$actual);
        $this->assertEquals($expected,$actual,$message);
    }
}
