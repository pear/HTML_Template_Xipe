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
/**
*
*   $Log$
*   Revision 1.6  2002/05/13 11:56:07  mccain
*   - added filter which converts everything to proper html by default
*
*   Revision 1.5  2002/04/15 20:23:44  mccain
*   - removed translate stuff
*
*   Revision 1.4  2002/03/22 19:48:24  mccain
*   - fixed a bug in the applyTranslate... now also method calls work
*
*   Revision 1.3  2002/02/07 22:45:55  mccain
*   - make the options stuff work
*
*   Revision 1.2  2002/02/07 22:03:46  mccain
*   - added informational comment
*
*   Revision 1.1.1.1  2002/02/07 21:52:23  mccain
*
*   ##### those are my local revisions, from before moving it to sourceforge :-) #####
*   ##### just kept for informational reasons, might be removed one day
*
*   Revision 1.22  2002/01/21 23:01:53  cain
*   - added license statement
*
*   Revision 1.21  2002/01/15 23:57:12  cain
*   - bugfixed the applyTranslateFuntion
*
*   Revision 1.20  2002/01/15 11:24:49  cain
*   - commit a little bug, which didnt let me use * ...
*
*   Revision 1.19  2002/01/09 05:28:12  cain
*   - some phpdoc adjustment
*
*   Revision 1.18  2002/01/09 05:15:00  cain
*   - removed the translate filter from here, which was only for playing
*
*   Revision 1.17  2001/12/30 08:13:40  cain
*   - added some translation
*
*   Revision 1.16  2001/12/21 14:51:27  cain
*   - started on the translation stuff
*
*   Revision 1.15  2001/12/19 22:39:28  cain
*   - tried something with nested html comments
*
*   Revision 1.14  2001/12/18 00:12:56  cain
*   - comments
*
*   Revision 1.13  2001/12/16 20:56:32  cain
*   - added optimizeHtmlCode
*
*   Revision 1.12  2001/12/15 14:08:43  cain
*   - fixed bug in addIfBeforeForeach
*
*   Revision 1.10  2001/12/12 18:27:21  cain
*   - changed some comments
*
*   Revision 1.9  2001/12/11 09:51:50  cain
*   - added constructor to pass the delimiters
*   - added filters: makePhpTags, autoBraces
*   - updated addIfBeforeForeach filter
*
*   Revision 1.8  2001/12/11 08:44:40  cain
*   - added cool filter 'addIfBeforeForeach' (well the name is not cool, but it says what it does)
*
*   Revision 1.7  2001/12/10 15:12:07  cain
*   - updated phpdocs
*
*   Revision 1.6  2001/12/10 13:38:35  cain
*   - renamed method
*
*   Revision 1.5  2001/12/10 12:11:24  cain
*   - started method applyHtmlEntities
*
*   Revision 1.4  2001/12/10 05:09:15  cain
*   - added filter removeEmptyLines
*   - fixed trimLines
*
*   Revision 1.3  2001/12/07 23:09:30  cain
*   - add some filters
*
*   Revision 1.2  2001/12/07 22:35:49  cain
*   - added some comment
*
*   Revision 1.1  2001/12/07 16:40:44  cain
*   - first useful filter
*
*
*/

require_once('SimpleTemplate/Options.php');

/**
*   the default filter(s) i use and SimpleTemplate needs
*
*   @package    SimpleTemplate/Filter
*   @access     public
*   @version    01/12/10
*   @author     Wolfram Kriesing <wolfram@kriesing.de>
*/
class SimpleTemplate_Filter_Basic extends SimpleTemplate_Options
{
// i need the method setOption, that's why i extend myPEAR_Common

    /**
    *   for passing values to the class, i.e. like the delimiters
    *   @access private
    *   @var    array   $options    the options for initializing the filter class
    */
    var $options = array(   'delimiter'     => array() );   // first value of the array is the begin delimiter, second the end delimiter

# remove the constructor one day, i feel that passing the delimiters to this class makes it all somehow unclean
# but therefore we have to move addIfBeforeForeach too, since it depends on having the delimiters

    /**
    *   apply (almost) all filters available in this class
    *   thanks to hint from Alan Knowles
    *   i am only applying those filters which i think are useful in mostly every case
    *   i.e. applyHtmlEntites i am not applying since it would convert every output to html
    *   and that is not desired in every case
    *
    *   @version    02/05/22
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  the actual input string, to which the filters will be applied
    *   @return     string  the resulting string
    */
    function allPrefilters( $input )
    {
        $input = $this->removeHtmlComments($input);
        $input = $this->removeCStyleComments($input);
        $input = $this->addIfBeforeForeach($input);
        return $input;
    }

    /**
    *   see allPrefilters()
    *
    *   @see        allPrefilters()
    *   @version    02/05/22
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  the actual input string, to which the filters will be applied
    *   @return     string  the resulting string
    */
    function allPostfilters( $input )
    {
        $input = $this->removeEmptyLines($input);
        $input = $this->trimLines($input);
        $input = $this->optimizeHtmlCode($input);
        return $input;
    }

    /**
    *   remove unnecessary php-tags, looks for ? > only spaces here < ?php  and merges them
    *   but watch out might be dangerous, since it also does that on < ?=
    *   better dont use it as it is if u are not 100% sure it will work (u were warned :-) )
    *
    *   @version    01/12/07
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function optimizePhpTags($input)
    {
        return preg_replace('/\?>\s*<\?php/Us','',$input);
    }

    /**
    *   removes HTML comments, use as preFilter
    *
    *   @version    01/12/07
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function removeHtmlComments($input)
    {
        return preg_replace('/<!--.*-->/Us','',$input); //worked until now, that i had nested html comments, not cool, but may happen when using {%include ...%}
// gotta live with that for now :-( see manual, recursive patterns
/*       return preg_replace('/<!--((?>[^(<!--)(-->)])|(?R))*-->/Usx','',$input);*/
    }

    /**
    *   removes C-style comments, use as preFilter
    *   but dont remove it if it is inside an html/xml tag <...>
    *   and dont remove it when there is a colon in front, like for a url
    *
    *   @version    01/12/07
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function removeCStyleComments($input)
    {
/*        $input = preg_replace( '/\/\/.+\n/U',"\n",$input);  // remove '//' but only on one line
removes <!DOCTYPE ... //W3C// > too :-(

        $input = preg_replace( '/(([^<].+)'.   // dont remove lines where double slashes are inside a html/xml tag <..>
                                '|([^:]))'.     // dont remove if there is a colon in front of the //, this is a url
                                '\/\/.+'.       // find the actual //
                                '(.+[^>])'.     // that checks for the closing >
                                '\n/U',"\n",$input);  // remove '//' but only on one line
removes the entire line if there is a // also only at the end

 doesnt work properly on this ...
<script>
    // fuck comment
    ftp://fuckyou.com
    http://fuckyou.com
</script>
http://fuck it
<a href="http://www.home.de">home</a>
http://dhsfsk

but this works:
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<a href="http://www.home.de">home</a>


*/


        $input = preg_replace('/\/\*.+\*\//Us','',$input);  // remove /* */ on multiple lines too
        return $input;
    }

    /**
    *   removes empty lines, leave indention as they are (i need this filter in autoBrace as it is!!!)
    *
    *   @version    01/12/09
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function removeEmptyLines($input)
    {
        return preg_replace('/\n\s*\n/s',"\n",$input);
    }

    /**
    *   removes trailing spaces from lines
    *   use only as a POST-filter, if you are using 'autoBrace', since it needs the indention
    *
    *   @version    01/12/09
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function trimLines($input)
    {
        return preg_replace('/\n\s*/s',"\n",$input);
    }

    /**
    *   concatenates HTML tags which are spread over many lines
    *   removes spaces inbetween a > and a <
    *   removes new lines before > and />
    *   use only as a POST-filter, if you are using 'autoBrace', since it needs the indention
    *
    *   @version    01/12/16
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function optimizeHtmlCode($input)
    {
# all those in here are in use, but not tested all the way, i.e. what happens with compares in JS/PHP using < or >

        // make lines at least 100 characters long
# dont know hoe yet...
#        $input = preg_replace('/((.*)\n(.*)){100,}/Us','$2 $3',$input);

        // removes new lines before > and />
        $input = preg_replace('/\n([\/>])/U','$1',$input);

        // concatenates HTML tags which are spread over many lines,
        // and replace spaces which are before and after the new line by one space only
        $input = preg_replace('/<(.+)[\s\n\s]+(.+)>/U','<$1 $2>',$input);

        // remove only spaces between > and <
        $input = preg_replace('/>(\040)*</U','><',$input);

        return $input;
    }

    /**
    *   concatenates short lines, to longer once, reduce number of lines
    *   use only as a POST-filter, if you are using 'autoBrace', since it needs the indention
    *
    *   @version    01/12/16
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function concatLines($input)
    {
# i think i better dont write this filter, since it might be screwy for
# <pre> tags, JS and what every else ... think about it
# its not done yet anyway

/*        $lines = explode("\n",$input);

        $output = array();
        $curOutputLine = 0;
        foreach( $lines as $aLine)
        {
            // is the line at least 100 characters long?
            if( strlen($output[$curOutputLine])>100 )
            {
                $curOutputLine++;
                $output[$curOutputLine] = '';
            }

            $newLine = trim($aLine);
            if(  )

            $output[$curOutputLine].= $newLine;
        }

        return implode("\n",$output);
*/
    }

    /**
    *   this places a {if(sizeof($x))} before a {foreach($x as ..)}
    *   so i dont have to make this check in every place myself (since i mostly need the
    *   check anyway or PHP will freak if $x is an empty array)
    *   its just the same as "show a block only if it really contains data"
    *   use as a PRE filter, works only if autoBraces is used and indention of at least 2 characters
    *   out of this:
    *     {foreach($x as $oneX)}
    *         {$oneX}
    *     {else}
    *         no x's available
    *   it makes
    *     {if(sizeof($x))}
    *      {foreach($x as $oneX)}
    *         {$oneX}
    *     {else}
    *         no x's available
    *   NOTE:   that you can also use {else} on a 'foreach', because it will then be used for
    *           the 'if' because the 'foreach' gets indented on more space
    *   NOTE1:  this filter can only be applied if the delimiters are not set via the xml
    *           options inside the file, this doesnt work yet ... :-(
    *           since the xml data change the delimiter, which was passed to the constructor when
    *           making an instance of this class
    *
    *   @version    01/12/11
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function addIfBeforeForeach($input)
    {
        return preg_replace('/\n(\s*)'.             // get the indented spaces in $1, starting at the beginning of a line (^ didnt work here, at least not for me)
                            preg_quote($this->options['delimiter'][0]).
                            '\s*foreach\s*\('.    // check for the '{foreach(' and spaces anywhere inbetween, '\s*' does that
                            '\s*'.                  // spaces after the '(' might be allowed
                            '(\$.*)'.               // get the variable name in $2
                            '\s'.                   // and search for the next space, since that means the variable name ended here
                            '/U',                   // and be greedy ... dont know why but we need it (i dont understand what greedy means anyway)

                            "\n$1".
                            $this->options['delimiter'][0].
                            "if(is_array($2) && sizeof($2)>0)".
                            $this->options['delimiter'][1].
                            "\n$1 ".                // indent it one more space than before, so an 'else' goes with the 'if' :-)
                            $this->options['delimiter'][0].
                            "foreach($2 ",

                            $input);
    }

    /**
    *
    *
    *   @version    01/12/11
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function convertEcho($input)
    {
# FIXXME problem here is if i want to replace {$x} but not {$x=7} with {echo $x}
# then i also have to check for $class->property, $a['array'] and so on ... dont know what to do now

# i wanted this filter so i dont always have to write { $x=7}, the space is what i need now, so it doesnt get an 'echo' inserted

        return preg_replace('/\{\$([a-zA-Z0-9_]*|'.
                            '[a-zA-Z0-9_]*->[a-zA-Z0-9_]*\(.*)\}/',"<?=\$$1 ?>",$input);
    }

    /**
    *   applies htmlentites to all the '{$' strings, so the
    *   printout will always be valid html
    *   do only use as a POST-filter!!
    *
    *   @version    02/05/13
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified input
    */
    function applyHtmlEntites($input)
    {
        return preg_replace( '/(<\?php=|<\?=)\$(.*)\?>/sU' , '<?=htmlentities($$2)?>' , $input );
    }

}
?>