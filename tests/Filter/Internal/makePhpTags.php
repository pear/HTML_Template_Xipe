<?php
//
//  $Id$
//

require_once 'UnitTest.php';

class tests_Filter_Internal_makePhpTags extends UnitTest
{
    function test_echoConstants()
    {
        $content = $this->_xipe->getRenderedTemplate('tpl/simple.tpl',array('test'=>1));
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
    *   {@$var} is also printed just like before ....
    *   actually this is bullshit 
    *
    *
    */
    function test_echoAtCharacter()
    {
        $this->test_echoConstants();
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

?>
