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
*   Revision 1.1.1.1  2002/02/07 21:52:23  mccain
*
*   ##### those are my local revisions, from before moving it to sourceforge :-) #####
*   ##### just kept for informational reasons, might be removed one day
*
*   Revision 1.10  2002/01/21 23:01:53  cain
*   - added license statement
*
*   Revision 1.9  2002/01/15 11:25:24  cain
*   - comment
*
*   Revision 1.8  2002/01/09 05:28:12  cain
*   - some phpdoc adjustment
*
*   Revision 1.7  2002/01/06 12:20:50  cain
*   - fixed bug, which let blocks only be used when they have the same indention before the copy tag
*
*   Revision 1.6  2001/12/21 14:52:20  cain
*   - make blocks useable in every template no matter if included via php or via tagLilb
*
*   Revision 1.5  2001/12/19 22:39:04  cain
*   - added block and include tag parsers
*
*   Revision 1.4  2001/12/19 14:51:50  cain
*   - added method includeFile
*   - make use of the delimiters
*
*   Revision 1.3  2001/12/18 15:55:38  cain
*   - added method trim
*   - finished 'repeat'
*
*   Revision 1.2  2001/12/18 00:12:56  cain
*   - comments
*
*   Revision 1.1  2001/12/15 14:03:07  cain
*   - this file will contain tagLib like filters
*
*
*
*/

require_once('myPEAR/Common.php');

/**
*   this file is intended to realize stuff like this
*   - add custom tags, which are no PHP (but replaced by it)!!! therefore they go like this: {%...%} where { and } are the delimiters
*       {%repeat $x times%}, {%repeat $x times, loopname=$loopCounter%}, replace by a simple for loop, if
*       loopname is given use this as the loop varibale name
*
*       {%copy block x here%} this replaces a defined block which is somewhere in the file
*           {%block x%}
*       {%include directory/file.tpl %}  this might define different blocks, which can be copied by using the above tag {%copy ...%}
*
*       {%strip whitespaces%}
*       {%strip%}
*
*       {%trim $x after 20 characters and add '...'%}
*       {%trim $x 20 '...'%}
*
*
*   @package    SimpleTemplate/Filter
*   @version    01/12/15
*/
class SimpleTemplate_Filter_TagLib extends myPEAR_Common
{
// i need the method setOption, that's why i extend myPEAR_Common

    /**
    *   for passing values to the class, i.e. like the delimiters
    *   @access private
    *   @var    array   $options    the options for initializing the filter class
    */
    var $options = array(   'delimiter'     =>  array(),    // first value of the array is the begin delimiter, second the end delimiter
                            'templateDir'   =>  '' );       // we need the template dir for the include directive

# remove the constructor one day, i feel that passing the delimiters to this class makes it all somehow unclean
# but therefore we have to move addIfBeforeForeach too, since it depends on having the delimiters

    /**
    *   actually i made a constructor only to pass the delimiters to this class
    *   at a definite point
    *
    *   @version    01/12/15
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      array   $options    need to be given, use the options from your tempalte class
    */
    function SimpleTemplate_Filter_TagLib($options=array())
    {
        if(sizeof($options))
            foreach( $options as $key=>$aOption )
                $this->setOption( $key , $aOption );
    }

    /**
    *   NOT IMPLEMENTED, AND I WONT
    *   removes spaces and new lines
    *   ACTUALLY i think this is unnecessary, simply use filters trimLines and optimizeHtml, this
    *   does everything, at least it works perfect for me
    *
    *   @version    01/12/15
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function strip( $input )
    {
        return $input;
    }

    /**
    *   {%repeat $x times%}, {%repeat $x times using $loopCounter%}, replace by a simple for loop, if
    *   a variable is given use this as the loop varibale name
    *
    *   @version    01/12/15
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function repeat( $input )
    {
        // find those repeats which dont have no variable that is given as the loop variable
        // we need to do this, since the next regExp needs this variable name, because
        // we can not use the $5 to check if it is given (down there in the second regExp)... bummer
        $counterName = '$_someUniqueVariableName';  // generate something here
        $input = preg_replace(  '/'.preg_quote($this->options['delimiter'][0]).
                                '%\s*repeat\s+([^\s%]+)([^\$]*)%'.preg_quote($this->options['delimiter'][1]).
                                '/',

                                #"PRE-REPEAT:<br>1='$1'<br>2='$2'<br>3='$3'<br>4='$4'<br>5='$5'<br>" , // for testing
                                $this->options['delimiter'][0].
                                "%repeat $1 $counterName%".
                                $this->options['delimiter'][1],

                                $input);

        $input = preg_replace(  '/\n(.*)'.          // save the indention in $1
                                preg_quote($this->options['delimiter'][0]).
                                '%\s*repeat\s+'.    // find begin delimiter repeat at least one space behind and variable spaces before
                                '([^\s]+)'.         // find everything until the next space, which is the count variable $2
                                '(([^\$%]*)?(\$[^\s]+)?)?'. // find the loop varibale name $5, a lot of stuff around it is optional (?)
                                                    // the variable name has to start with a $ and spaces are excluded, so we trim it too
                                '\s*%'.             // optional numbner of spaces before closing delimiter
                                preg_quote($this->options['delimiter'][1]).
                                '/',

                                "\n$1".$this->options['delimiter'][0].
                                "for($5=0;$5<$2;$5++)".
                                $this->options['delimiter'][1],

                                #"REPEAT:<br>1='$1'<br>2='$2'<br>3='$3'<br>4='$4'<br>5='$5'<br>6='$6'<br>" , // for testing
                                $input);  // replace unnecessary spaces, so the next regexp is shorter and easier

        return $input;
        /* TESTS

        { $xx->methodCall=7}
        { $x=1}
        { $x1=1}
        { $x2=1}
        { $x_y=1}
        { $variableName_howEver_Long_it_mig111htBe=1}
        { $x4=1}

        <!--{%repeat $x->methodCall($easyVar)%} this works too, but i am too lazy to declare a class here-->
        {%repeat $xx->methodCall%}
            repeat 1
        <br>
        {%repeat sizeof($x)%}
            repeat 2
        <br>
        {%repeat $x times%}
            repeat 3
        <br>
        {%repeat $x1 times $y1%}
            repeat 4
        <br>
        {%    repeat     $x2    times    $y2   %}
            repeat 5
        <br>
        {%repeat $x_y times using $y%}
            repeat 6
        <br>
        {%repeat $variableName_howEver_Long_it_mig111htBe times with $y3%}
            repeat 7
        <br>
        {%repeat sizeof($x4) times $y4%}
            repeat 8
        <br>
        */
    }

    /**
    *   trims strings after X characters and adds a given string, if given
    *   use as PRE filter
    *   @todo   the length can not be a variable yet, do this someday
    *
    *   tested with
    *   {$x1='What a long string'}<br>
    *   {$x2='I am here '}<br>
    *   {$that->fuck='He ho'}<br>
    *   <br><br>
    *   1. {%trim $x1 after 5 characters and add "JUST simple ..."%}<br>
    *   2. {%trim $x2 3 "REPLACE with this"%}<br>
    *   3. {%   trim    $that->fuck fucking off unitl it dies after no more than  200 characters ,kajdfa sdkjas dlkjas dfkjasdf lksjd fksjdf lksjdf lksjd flkj l reaplce with ""%}
    *   <br>
    *   4. {%trim $x2 3%}<br>
    *   5. {%trim $x2  after 3 letters %}<br>
    *   6. {%trim   $x2  3   %}<br>
    *   7. {%trim $x2 to the length of 3%}<br>
    *
    *   @version    01/12/18
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function trim( $input )
    {
        return preg_replace(    '/'.preg_quote($this->options['delimiter'][0]).
                                '%\s*trim\s+'.      // find the '{%trim ' with at least one space behind and any number of spaces between % and trim
                                '([^\s]+)'.         // find all until the next space, that will be our variable name $1
                                '[^\d]+'.           // find anything until a decimal number comes
                                '(\d+)'.            // put the decimal number in $2
                                '(\s+.*"(.*)")?'.   // this is saucy, we only need the most inner pair of (),
                                                    // that will be our string we use to add at the end in case we trim it
                                                    // all those other () are only for making each block optional (?), esp. for test 5 to work
                                '\s*%'.preg_quote($this->options['delimiter'][1]).
                                '/' ,               // allow any kind of spaces before the end delimiter

                                $this->options['delimiter'][0].
                                'echo ((strlen($1) > $2))?(substr($1,0,$2)."$4"):$1'.
                                $this->options['delimiter'][1],
                                #"TRIM:<br>1='$1'<br>2='$2'<br>3='$3'<br>4='$4'<br>5='$5'<br>" , // for testing

                                $input );
    }

    /**
    *   {%include xxx.tagLib%}
    *
    *   @version    01/12/18
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function includeFile( $input )
    {
        if( preg_match_all( '/{%\s*include\s+(.+)\s*%}/U' , $input , $includes ) )
        {
#print_r($includes);
            if(sizeof($includes[1]))
            foreach( $includes[1] as $index=>$aInclude )
            {
                // get the relative path to templateDir or absolute if given
                if( $aInclude[0] != '/' )           // add trailing slash if missing
                    $aInclude = '/'.$aInclude;
                $fileToInclude = $this->options['templateDir'].$aInclude;

                if( file_exists($fileToInclude) )   // do only include a file that really exists, otherwise the tag also stays there, so the programmer removes it
                {
                    // read the file
                    $fileContent = implode("\n",file($fileToInclude));
                    // replace the string from $includes[0] with the file
                    $input = preg_replace( '/'.preg_quote($includes[0][$index],'/').'/' , $fileContent , $input );
                }
            }

        }
        return $input;
    }

    /**
    *   parses {%block xxx%} tags
    *
    *   @version    01/12/18
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input  the original template code
    *   @return     string  the modified template
    */
    function block( $input )
    {
        // do somehow add the block-end tag first, use autoBraces, but needs modification first
        // for now you need to write the {%/block%} end tag
        $regExpToFindBlocks = '/{%\s*block\s+(.+)\s*%}.*{%\/\s*block\s*%}/Us';
        // retreive the block names only, since a block might contain another block
        // by not getting the block content here we can also put blocks in blocks...
        preg_match_all( $regExpToFindBlocks , $input , $blocks );

        if( sizeof($blocks[0]))
        {
            foreach( $blocks[1] as $index=>$aBlockName )
            {
                // we trim the block name here, so we only get the real block name
                // and we dont have to add this 'no spaces' in the regExp
                $realBlockName = trim($aBlockName);

                // !!!
                // get the block content now, because it might containes another copy-tag !!!
                // which was replaced by the according block, write it in $blockContent
                $blockRegExp = '/{%\s*block\s+'.$aBlockName.'\s*%}(.*){%\/\s*block\s*%}/Us';
                preg_match( $blockRegExp , $input , $blockContent );
                // and replace the block definitions with nothing
                $input = preg_replace( $blockRegExp , '' , $input );

                $this->blocks[$realBlockName] = $blockContent[1];

                // we need to get the number of spaces before each '{%copy' to maintain indention
                preg_match_all(  '/\n(\s*){%\s*copy\s+block\s+'.$realBlockName.'.*%}/' , $input , $copyTags );

                // now we need to go thru every '{%copy' tag that has to be replaced and get its indention
                // to keep it in front, this adds the indention that is given in the block too !!!

                if(sizeof($copyTags[0]))
                foreach( $copyTags[0] as $cpIndex=>$aCopyTag )
                {
                    $indentedBlockContent = preg_replace( '/\n/' , "\n".$copyTags[1][$cpIndex] , $blockContent[1] );
                    $input = preg_replace( '/'.$copyTags[0][$cpIndex].'/' , $indentedBlockContent , $input );
                }
            }
        }

        // go thru all blocks to replace copy-tags that are still left
        // in the first foreach we had only replaced copy tags which use blocks that
        // are defined in the same file
        if( sizeof($this->blocks) )
        foreach( $this->blocks as $realBlockName=>$blockContent )
        {
            // we need to get the number of spaces before each '{%copy' to maintain indention
            preg_match_all(  '/\n(\s*){%\s*copy\s+block\s+'.$realBlockName.'.*%}/' , $input , $copyTags );
            // now we need to go thru every '{%copy' tag that has to be replaced and get its indention
            // to keep it in front, this adds the indention that is given in the block too !!!
            if(sizeof($copyTags[0]))
            foreach( $copyTags[0] as $cpIndex=>$aCopyTag )
            {
                $indentedBlockContent = preg_replace( '/\n/' , "\n".$copyTags[1][$cpIndex] , $blockContent );
                $input = preg_replace( '/'.$copyTags[0][$cpIndex].'/' , $indentedBlockContent , $input );
            }
        }

        // we have replaced all that was to replace, remove {%copy-tags
        // that were not replaced by anything
        $input = preg_replace(  '/\n(\s*){%\s*copy\s+block\s+.*%}/' , '' , $input );

        return $input;

        /*
        tested with

        {% block x %}<br>
            hi i am your first block
            even a line break i
            contain
        {%/block %}

        {%block this_block%}
            this is this block INSERTED<br>
        {%/block %}

        1.<br>
        {%copy block this_block here %}
        <br><br>
        2.<br>
        {%    copy     block     x      here %}
        <br><br>
        3.<br>
        {%   copy     block    this_block%}
        <br><br>
        4.<br>
        {%copy block     this_block   %}
        <br><br>

        */
    }
}

?>