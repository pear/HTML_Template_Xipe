<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Wolfram Kriesing <wolfram@kriesing.de>                      |
// +----------------------------------------------------------------------+
//
/*
*
*   ##### those are my local revisions, from before moving it to sourceforge :-) #####
*   ##### just kept for informational reasons, might be removed one day
*
*   $Log$
*   Revision 1.7  2002/01/21 23:01:53  cain
*   - added license statement
*
*   Revision 1.6  2002/01/19 23:35:40  cain
*   - added method setOptions
*
*   Revision 1.5  2002/01/16 13:43:22  cain
*   - moved (copy for now) parseDSN here
*
*   Revision 1.4  2002/01/15 11:27:33  cain
*   *** empty log message ***
*
*   Revision 1.3  2002/01/09 05:16:59  cain
*   - added constructor, and getOption method
*
*   Revision 1.2  2001/12/12 18:29:57  cain
*   - named the class properly
*
*   Revision 1.1  2001/12/07 11:16:49  cain
*   *** empty log message ***
*
*
*/

/**
*   this class only defines commonly used methods, etc.
*   it is worthless without being extended
*
*   @package  SimpleTemplate
*   @access   public
*   @author   Wolfram Kriesing <wolfram@kriesing.de>
*
*/
class SimpleTemplate_Options
{
    /**
    *   @var    array   $options    you need to overwrite this array and give the keys, that are allowed
    */
    var $options = array();

    /**
    *   this constructor sets the options, since i normally need this and
    *   in case the constructor doesnt need to do anymore i already have it done :-)
    *
    *   @version    02/01/08
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      boolean true if loggedIn
    */
    function SimpleTemplate_Options( $options=array() )
    {
        if( is_array($options) && sizeof($options) )
            foreach( $options as $key=>$value )
                $this->setOption( $key , $value );
    }

    /**
    *
    *   @access     public
    *   @author     Stig S. Baaken
    *   @param      
    */
    function setOption( $option , $value )
    {
        if (isset($this->options[$option])) {
            $this->options[$option] = $value;
            return true;
        }
        return false;
    }

    /**
    *   set a number of options which are simply given in an array
    *
    *   @access     public
    *   @author
    *   @param
    */
    function setOptions( $options )
    {
        if( is_array($options) && sizeof($options) )
            foreach( $options as $key=>$value )
                $this->setOption( $key , $value );
    }

    /**
    *
    *   @access     public
    *   @author     copied from PEAR: DB/commmon.php
    *   @param      boolean true on success
    */
    function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }
#        return $this->raiseError("unknown option $option");
        return false;
    }

} // end of class
?>