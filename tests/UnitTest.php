<?php
//
//  $Id$
//

require_once 'PHPUnit.php';

define('CONSTANT','constant');

class UnitTest extends PhpUnit_TestCase
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
        
        $this->setLooselyTyped(true);
    }

    function tearDown()
    {
    }
}

?>
