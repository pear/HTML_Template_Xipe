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
//  $Log$
//

require_once('SimpleTemplate/Options.php');

/**
*   translation filters and helpers
*
*   @package    SimpleTemplate/Filter
*   @access     public
*   @version    02/04/14
*   @author     Wolfram Kriesing <wolfram@kriesing.de>
*/
class SimpleTemplate_Filter_Translate extends SimpleTemplate_Options
{

    /**
    *   apply a function/method to each output which translates the string, so i dont have to
    *   do it by hand every time
    *   use only as POST-filter, since it looks for '< ? =' tags
    *
    *   NOTE:   its quite couragous using this filter, since it might also translate usernames or other stuff
    *           that is dynamically generated, and if it also is in the translate-table then the page may become funny
    *
    *   @version    02/01/08
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @param      string  $functionName   the function to put around a string that is printed
    *   @param      array   $possibleMarkUpDelimiters   delimiters that are around a text that should be translated, see Language_Translate
    *   @see        $Language_Translate::possibleMarkUpDelimiters
    *   @return     string  the modified template
    */
    function applyTranslateFunction( $input , $functionName , $possibleMarkUpDelimiters )
    {
        if( sizeof($possibleMarkUpDelimiters) )
        foreach( $possibleMarkUpDelimiters as $begin=>$end )  // go thru all the delimiters and try to translate the strings
        {
# FIXXME the [ ^ ? > ] makes it impossible to translate the following string
# automatically: < ?=$key? > --- < ?=$aLoop? >
# if i had left a "." instead there it would result in: < ?=translateMathod($key? > --- < ?=$aLoop)? >
# but now we have the problem that ONLY to stuff inside the $possibleMarkUpDelimiters
# the translate function is applied, but we need the $possibleMarkUpDelimiters since
# we dont want to translate every < ?=.. tag, since those might also just be formatting
# things or in a style sheet simply a path or whatsoever, so $possibleMarkUpDelimiters IS DEFINITELY NEEDED
# but must become better

            $input = preg_replace(
                                    // $ [^ ? >]    takes care of only applying the method to the proper block, i think there is some reg-exp modifier for that too, but dont know yet
                                    // (->)?        takes care of class operators to be included in the translation
                                    '/('.$begin.'<\?=)(\$([^?>](->)?)*)(\?>'.$end.')/i' ,
                                    "$1$functionName($2)$5" ,
                                    $input );
        }
        return $input;

/*
    TEST CASES THAT PASSED:
    1. the problem here was the class-operator '->', since the '>' is also in the possibleMarkUpDelimiter
    <td class="listContent">< ?=$language->getName($aBookmark['language'])? ></td>

*/
    }

}
?>