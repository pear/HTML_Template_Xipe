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
*   Revision 1.5  2002/03/04 18:36:07  mccain
*   - only a comment
*
*   Revision 1.4  2002/02/26 12:34:48  mccain
*   - added some nicer error handling and warning, so setup is easier
*
*   Revision 1.3  2002/02/07 22:45:55  mccain
*   - make the options stuff work
*
*   Revision 1.2  2002/02/07 22:03:46  mccain
*   - added informational comment
*
*   Revision 1.1.1.1  2002/02/07 21:52:22  mccain
*
*   ##### those are my local revisions, from before moving it to sourceforge :-) #####
*   ##### just kept for informational reasons, might be removed one day
*
*   Revision 1.28  2002/02/05 12:54:31  cain
*   - use new Tree class interface
*   - problem with Log-class
*
*   Revision 1.27  2002/02/01 10:41:48  cain
*   - use benchmark class to measure times
*
*   Revision 1.26  2002/01/21 23:01:53  cain
*   - added license statement
*
*   Revision 1.25  2002/01/21 04:29:20  cain
*   - used a different tree-method to retreive xml-data
*
*   Revision 1.24  2002/01/19 23:33:34  cain
*   - use Log-class properly
*   - let user configure logging
*   - xml config works now
*   - extend class from myPEAR_Common for the options methods
*
*   Revision 1.23  2002/01/18 05:53:53  cain
*   - started on the applyXmlConfig method
*
*   Revision 1.22  2002/01/16 05:58:25  cain
*   - still working on the xml-config feature
*
*   Revision 1.21  2002/01/15 11:24:12  cain
*   - working on XML-config
*
*   Revision 1.20  2002/01/09 05:16:39  cain
*   - now filters can also have a number of additional parameters
*   - and object references are preserved
*
*   Revision 1.19  2001/12/30 08:14:00  cain
*   - use @ on is_dir
*
*   Revision 1.18  2001/12/21 10:23:57  cain
*   - use locale, for multilingual
*   - save reference for filter-object if given
*   - made the path check also work on windows
*
*   Revision 1.17  2001/12/20 15:31:44  cain
*   - added rudimentary logging
*
*   Revision 1.16  2001/12/18 15:56:03  cain
*   - comments
*
*   Revision 1.15  2001/12/18 00:13:20  cain
*   - comments
*
*   Revision 1.14  2001/12/16 20:56:43  cain
*   - whitespace
*
*   Revision 1.13  2001/12/15 14:10:53  cain
*   - implemented xml config file check, xml parser still missing
*   - made internal filters not be in pre or post filters
*
*   Revision 1.12  2001/12/13 10:50:29  cain
*   - use Internal-filter
*
*   Revision 1.11  2001/12/11 09:53:12  cain
*   - trimed method parse since all filter are where they belong, in the filter class
*   - add method applyFilters
*   - moved autoBraces to filter class too, since it is a filter :-)
*
*   Revision 1.10  2001/12/10 15:12:07  cain
*   - updated phpdocs
*
*   Revision 1.9  2001/12/10 13:39:04  cain
*   - added some comments
*
*   Revision 1.8  2001/12/10 05:09:42  cain
*   - bugfix for empty lines after an opening brace
*
*   Revision 1.7  2001/12/07 23:09:22  cain
*   - filters with objects didnt work, fixed this bug
*
*   Revision 1.6  2001/12/07 22:36:20  cain
*   - bugfix in autoBraces
*
*   Revision 1.5  2001/12/07 16:40:30  cain
*   - added forceCompile option
*   - added optimizePhpTags filter to call if 'autoBraces' is on, fixes the 'else' bug
*
*   Revision 1.4  2001/12/07 14:27:37  cain
*   - added autoBraces feature
*
*   Revision 1.3  2001/12/07 12:09:19  cain
*   - added pre and post filters
*   - read entire file now when compiling to make it easier to apply filters
*
*   Revision 1.2  2001/12/07 11:21:40  cain
*   - use compileDir properly
*
*   Revision 1.1  2001/12/06 10:04:01  cain
*   *** empty log message ***
*
*
*/

require_once('Benchmark/Timer.php');
require_once('SimpleTemplate/Options.php');
require_once('SimpleTemplate/Filter/Internal.php');
require_once('Log/Log.php');

/**
*   the intention is to use normal php in the template without the need to write
*   <?php or <?= all the time
*   but smarty, IT[X] and so on just dont give me enough power (i need referencing the reference of a variable and so on)
*   and i want to have the entire power of php inside the template, without
*   making the code look so ugly as it sometimes does, only because you want to write a varibale
*   so this template engine will not do much, but fulfill my needs
*
*   @package    SimpleTemplate
*
*/
class SimpleTemplate_Engine extends SimpleTemplate_Options
{

# FIXXME a problem we have here: is that if i use {include(a.php)} the varibales of this file overwrite the ones
# set for the template where it is included, ... ***create a namespace for each file*** somehow, which is unique for every tempalte ... but how
# without the need for the user to change its programming behaviour,
# one solution would be copying everything from $GLOBALS into a unique varibale and replacing all variables in the
# template using this unique variable, but this makes it a HUGE overhead, but would work

# FIXXME2 by testing a site i realized, that a lot of php tags inside a tempalte slow slow down rendering
# very much, somehoe it seems php is not too good in rendering html-pages with a lot of php tags inside
# so we can write a filter, which can be applied that translates the entire template to use echo's only :-)
# some work ha?

# TODO
# - enable a taglib/filter for sql statements inside the template, even though i will never use it :-)
#   if we put that in a seperate file we can load it only on request, saves some php-compiling time
# - add a taglib/filter for translate, smthg like: {%t $phpValue %}, to explicitly translate a string
#   in case someone doesnt like to use the filter "applyTranslateFunction"
# - add a filter for converting strings to html-entities, could work like "applyTranslateFunction" on
#   mark up delimiters, or could be a taglib-tag too ... whatever
#
# MAY BE features
# - url obfuscating (or whatever that is called), rewrite urls and decode them when retreiving a call to a specific page ... somehow
#   i dont know if that belongs in a template engine, may be just write in the tutorial how to attach those products easily
#   using a filter or whatever
# -
#
#
    /**
    *   for customizing the class
    *   @access private
    *   @var    array   $options    the options for initializing the template class
    */
    var $options = array(   'compileDir'    =>  '',      // by default its always the same one as where the template lies in, this might not be desired
                            'delimiter'     =>  array('{','}'),
                            'templateDir'   =>  '',
                            'autoBraces'    =>  true,   // see method 'autoBraces' for explaination
                            'forceCompile'  =>  false,  // only suggested for debugging
                            'xmlConfigFile' =>  'config.xml', // name of the xml config file which might be found anywhere in the directory structure
                            'locale'        =>  'en',   // default language
                            'logFileExtension'=>'log',
                            'logLevel'      =>  1       // 1 - only logs new compiles, 0 - logs nothing, 2 - logs everything even only deliveries
                        );

    /**
    *   saves the preFilters which will be applied before compilation
    *
    *   @access private
    *   @var    array   $preFilters     methods/functions that will be called as prefilter
    */
    var $preFilters = array();

    /**
    *   saves the postFilters which will be applied after compilation
    *
    *   @access private
    *   @var    array   $preFilters     methods/functions that will be called as postfilter
    */
    var $postFilters = array();

    /**
    *   @access private
    *   @var    boolean $xmlConfigUpdated   is true if an xml config file that applies to the current template is newer than the compiled template
    */
    var $xmlConfigUpdated = false;

    /**
    *   @access private
    *   @var    array   $xmlConfigFiles this array contains all the xml config files that need to be applied to the current template
    */
    var $xmlConfigFiles = array();

    /**
    *   @var    float   the time compiling/delivering took
    */
    var $compileTime = 0;

    /**
    *   the constructor, pass the options to it as needed
    *
    *   @see        $options
    *   @version    01/12/03
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function SimpleTemplate_Engine( $options=array() )
    {
        foreach( $options as $key=>$aOption )
            $this->setOption( $key , $aOption );

        if(!@is_dir($this->options['compileDir']) )
            return new PEAR_Error('The compile-directory doesnt exist yet!');
    }

    /**
    *   gets the delimiter which starts a template-tag, default is '{'
    *
    *   @version    01/12/07
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @return     string      the begin delimiter
    */
    function getBeginDelimiter()
    {
        return $this->options['delimiter'][0];
    }

    /**
    *   gets the delimiter which ends a template-tag, default is '}'
    *
    *   @version    01/12/07
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @return     string      the end delimiter
    */
    function getEndDelimiter()
    {
        return $this->options['delimiter'][1];
    }

    /**
    *   gets the template directory
    *
    *   @version    01/12/14
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @return     string      path
    */
    function getTemplateDir()
    {
        return $this->options['templateDir'];
    }

    /**
    *   DONT USE YET, since i didnt find a way to make it workin, because no
    *   variables in the template is known if i include it here
    *   use: $ tpl->compile('index.tpl');
    *        include($ tpl->compiledTemplate);
    *   instead
    *
    *   @version    01/12/03
    *   @access     public
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function show( $file )
    {
        if( $this->compile($file) )
        {
            include( $this->compiledTemplate );
        }
        else
            $this->showError("ERROR: couldnt get compiled template!!!<br>");
    }

    /**
    *   here all the replacing, filtering and writing of the compiled file is done
    *   well this is not much work, but still its in here :-)
    *
    *   @access     private
    *   @version    01/12/03
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param
    *   @return
    */
    function parse()
    {
        // read the entire file into one variable
        if( $input = @file($this->currentTemplate) )
            $fileContent = implode( '' , $input );
        else
            $fileContent = '';                      // if the file doesnt exist, write a template anyway, an empty one but write one

        // parse the template file for xml-config tags
        $fileContent = $this->checkForXmlConfigInTemplate( $fileContent );

        // pass option to know the delimiter in the filter, but parse the xml-config before!!!, see line above
        $defaultFilter = new SimpleTemplate_Filter_Internal($this->options);

        //  apply pre filter
        $fileContent = $this->applyFilters( $fileContent , $this->preFilters );

        // this filter does all the default replacement of the delimiters
        $internalFilters = array();                 // empty them every time, in case this method is called multiple times in one script
        $internalFilters[] = array('makePhpTags',$defaultFilter);
        // if the option autoBraces is on apply the _first_ postFilter right here
        // which does the autBracing
        if( $this->options['autoBraces'] == true )
            $internalFilters[] = array('autoBraces',$defaultFilter);

        $fileContent = $this->applyFilters( $fileContent , $internalFilters );

        //  apply post filter
        $fileContent = $this->applyFilters( $fileContent , $this->postFilters );

        // write the compiled template into the compiledTemplate-File
        if( ($cfp = fopen( $this->compiledTemplate , 'w' )) )
        {
            fwrite($cfp,$fileContent);
            fclose($cfp);
            chmod($this->compiledTemplate,0770);
        }

        return true;
    }

    /**
    *   compile the template
    *
    *   @see        SimpleTemplate
    *   @access     public
    *   @version    01/12/03
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $file   relative to the 'templateDir' which you set when calling the constructor
    *   @return
    */
    function compile( $file )
    {

        $timer = new Benchmark_Timer;
        $timer->start();

        // reset those variables so this instance can be called multiple times
        // and doesnt use old values
        $this->xmlConfigUpdated = false;
        $this->xmlConfigFiles = array();

        // if the compileDir doesnt start with a / then its under the template dir
        if( strpos( $this->options['compileDir'] , $_SERVER['DOCUMENT_ROOT'] )!==0 )
            $this->setOption( 'compileDir' , $this->options['templateDir'].'/'.$this->options['compileDir']);

        // if the tempalteDir is at the beginning attached, remove it, since we add
        // it automatically in here ... that's how it first worked :-)
        if(strpos($file,$this->options['templateDir'])===0)
            $file = str_replace( $this->options['templateDir'] , '' , $file );

        // remove the slash if there is one in front, just to be clean
        if( $file[0] == '/' )
            $file = substr($file,1);

        $compileDest = $this->getOption('compileDir');
#print "compileDest=$compileDest<br>";
        if( !@is_dir($compileDest) )                // check if the compile dir has been created
        {
            $this->showError(   "'compileDir' could not be accessed<br>".
                                "1. pleace create the 'compileDir' which is: <b>'$compileDest'</b><br>2. give write-rights to it");
        }

        if( !is_writeable($compileDest))
# i dont know how to check if "enter" rights are given
        {
            $this->showError(   "can not write to 'compileDir', which is <b>'$compileDest'</b><br>".
                                "1. pleace give write and enter-rights to it");
        }

#print "file=$file<br>";
        $directory = dirname( $file );
        $filename = basename($file);

        // extract dirname to create directori(es) in compileDir in case they dont exist yet
        // we just keep the directory structure as the application uses it, so we dont get into conflict with names
        // i dont see no reason for hashing the directories or the filenames
        if( $directory!='.' )   // $directory is '.' also if no dir is given
        {
            $path = explode('/',$directory);
            foreach( $path as $aDir )
            {
                $compileDest = $compileDest."/$aDir";
                if( !@is_dir($compileDest) )
                {
                    umask(0000);                        // make that the users of this group (mostly 'nogroup') can erase the compiled templates too
                    if( !@mkdir($compileDest,0770) )
                    {
                        $this->showError(   "couldn't make directory: <b>'$aDir'</b> under <b>'".$this->getOption('compileDir')."'</b><br>".
                                            "1. please give write permission to the 'compileDir', so SimpleTemplate can create directories inside");
                    }
                }
            }
        }

        $this->currentTemplate = $this->options['templateDir'].'/'.$file;
        $this->compiledTemplate = $compileDest.'/'.$filename.'.'.$this->options['locale'].'.php';

        $logFile = $compileDest.'/'.$filename.'.'.$this->getOption('logFileExtension');

        // cant the log-class do that???
        $startTime = split(" ",microtime());
        $startTime = $startTime[1]+$startTime[0];

#        $this->logObject = Log::factory('file',$logFile);
// actually the above line should work :-(
require_once('Log/file.php');
$this->logObject = new Log_file($logFile);

        $this->logObject->log('compilation/deliverance started');
        $this->logObject->log('Locale:'.$this->options['locale']);

        $this->checkXmlConfig();

        $recompile = false;
        if( $this->getOption('forceCompile') )
        {
            if( $this->getOption('logLevel') > 0 )
                $this->logObject->log('recompile because option "forceCompile" is true');
            $recompile = true;
        }

        if( $recompile==false )                     // if recompile is true dont bother to check if template has changed
        if( !$this->isUpToDate() )                  // check if the template has changed
        {
            if( $this->getOption('logLevel') > 0 )
                $this->logObject->log('recompile because tpl has changed/was removed: '.$this->currentTemplate);
            $recompile = true;
        }

        if( $recompile ||
            $this->xmlConfigUpdated )               // or any of the config files
        {
            if(sizeof($this->xmlConfigFiles))
                foreach( $this->xmlConfigFiles as $aConfigFile )
                    $this->applyXmlConfig($aConfigFile);

            if( !$this->parse() )
                return false;
        }

        $endTime = split(" ",microtime());
        $endTime = $endTime[1]+$endTime[0];
        $itTook = ($endTime - $startTime)*100;
        if( $this->getOption('logLevel') > 0 )
            $this->logObject->log("(compilation and) deliverance took: $itTook ms\n");

        $timer->stop();
        $this->compileTime = $timer->timeElapsed();

        return true;
    }

    /**
    *   checks if the compiled template is still up to date
    *
    *   @access     private
    *   @version    01/12/03
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string      $fileToCheckAgainst if given this file is checked if it is newer than the compiled template
    *                                               this is useful if for example only an xml-config file has changed but not the
    *                                               template itself
    *   @return     boolean     true if it is still up to date
    */
    function isUpToDate( $fileToCheckAgainst='' )
    {
        if( $fileToCheckAgainst == '' )
            $checkFile = $this->currentTemplate;
        else
            $checkFile = $fileToCheckAgainst;

        if( !file_exists( $this->compiledTemplate ) ||
            filemtime( $checkFile ) > filemtime( $this->compiledTemplate )
          )
        {
            return false;
        }

        return true;
    }

    /**
    *   register a prefilter, which will be executed BEFORE the template
    *   is being compiled
    *
    *   @access     public
    *   @version    01/12/03
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $functionName   the funtion to call
    *   @param      object  $object         if given the function is meant to be a method of this object
    */
    function registerPrefilter( $functionName , $params=null )
    {
        if( $params != null )
        {
            // use a reference to the object $params here, so the filters can also set internal properties
            // and the next call to this filter still sees it, if we used no reference
            // TagLib->block i.e. wouldnt work
            if( !is_array($params) )
                $this->preFilters[] = array($functionName,&$params);   // use reference here !!! see comment above in registerPrefilter
            else
            {
                if( is_object($params[0]) )
                {
                    $params[0] = &$params[0];       // be sure to use references, reason, see above
                    $this->preFilters[] = array($functionName,$params);
                }
                else
                    $this->preFilters[] = array($functionName,$params);
            }
        }
        else
            $this->preFilters[] = $functionName;

    }

    /**
    *   register a postfilter, which will be executed AFTER the template
    *   was compiled
    *
    *   @access     public
    *   @version    01/12/07
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $functionName   the funtion to call
    *   @param      object  $object         if given the function is meant to be a method of this object
    */
    function registerPostfilter( $functionName , $params=null )
    {
        if( $params != null )
        {
            if( !is_array($params) )
                $this->postFilters[] = array($functionName,&$params);   // use reference here !!! see comment above in registerPrefilter
            else
            {
                if( is_object($params[0]) )
                {
                    $params[0] = &$params[0];
                    $this->postFilters[] = array($functionName,$params);
                }
                else
                    $this->postFilters[] = array($functionName,$params);
            }
        }
        else
            $this->postFilters[] = $functionName;
    }

    /**
    *   actually it will only be used to apply the pre and post filters
    *
    *   @access     public
    *   @version    01/12/10
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  $input      the string to filter
    *   @param      array   $filters    an array of filters to apply
    *   @return     string  the filtered string
    */
    function applyFilters( $input , $filters )
    {
        if( sizeof($filters) )
        foreach( $filters as $aFilter )
        {
# FIXXME use log class
            $startTime = split(" ",microtime());
            $startTime = $startTime[1]+$startTime[0];
            $sizeBefore = strlen($input);

            if( !is_array($aFilter) )
                $input = call_user_func( $aFilter , $input );
            else
            {
                if( !is_array($aFilter[1]) )
                {
                    $input = call_user_method( $aFilter[0] , $aFilter[1] , $input );
                }
                else        // if $aFilter[1] is an array then additional parameters shall be passed to the function/method
                {
                    if( !is_object($aFilter[1][0]) )
                    {                                   // not tested...
                        array_unshift( $aFilter[1] , $input );  // input is always the first parameter, so put it at first !!!
                        $input = call_user_func_array( $aFilter , $aFilter[1] );
                    }
                    else
                    {
                        $object = &$aFilter[1][0];   // get the object-reference!!! that shall be called
                        array_splice( $aFilter[1] , 0 , 1 , $input );  // replace the object with $input, so the first paramter is $input !!!
                        $input = call_user_method_array( $aFilter[0] , $object , $aFilter[1] );
                    }
                }
            }

            $sizeAfter = strlen($input);
# FIXXME use log class
            $endTime = split(" ",microtime());
            $endTime = $endTime[1]+$endTime[0];
            $itTook = ($endTime - $startTime)*100;
            if( is_array($aFilter) )
                $appliedFilter = $aFilter[0];
            else
                $appliedFilter = $aFilter;

            if( $this->getOption('logLevel') > 0 )
                $this->logObject->log("applying filter: '$appliedFilter' \ttook=$itTook ms, \tsize before: $sizeBefore Byte, \tafter: $sizeAfter Byte");
        }


        return $input;
    }

    /**
    *   checks along the path of the current template for xml config files
    *   and applys them if they exist
    *
    *   @access     public
    *   @version    01/12/14
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function checkXmlConfig()
    {
        $configFile = $this->options['xmlConfigFile'];
        // start at the templateDir and go until the directory where the
        // current template is in and apply all xml-config files found on the way
        $curTplDir = dirname($this->currentTemplate);
        $path = explode( '/' , str_replace( $this->options['templateDir'] , '' , $curTplDir ));
        if(sizeof($path))
        {
            $curDir = $this->options['templateDir'];
            foreach($path as $aDir)
            {
                $curDir.= $aDir ? '/'.$aDir : '' ;

                $possibleConfigFile = $curDir.'/'.$configFile;
                if( file_exists($possibleConfigFile))
                {
                    $this->xmlConfigFiles[] = $possibleConfigFile;  // remember the xml config files that need to be applied to the current template
                    if( !$this->isUpToDate($possibleConfigFile) )   // check if one of the xml config files is newer than the compiled template
                    {
                        $this->xmlConfigUpdated = true;             // if so remember that so the template gets recompiled
                        if( $this->getOption('logLevel') > 0 )
                            $this->logObject->log('recompile because XML-config file is newer than compiled template: '.$possibleConfigFile);
                    }
                }
            }
        }

    }

    /**
    *   applies the given xml config file
    *
    *   @access     public
    *   @version    01/12/14
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function applyXmlConfig( $configFileOrString , $isString=false )
    {
/*
if( $isString )
{
    print "__APPLY config string in $this->currentTemplate<br>";
}
else
    print "__APPLY config file: $configFileOrString<br>";
*/
        // include this so i can get the xml file prepared in the tree shape
        // and i can use the tree methods to retreive the options i need to set :-)
        require_once('Tree/Tree.php');

        if( $isString )
        {
            $config = Tree::setupMemory( 'XML' );
            $config->setupByRawData( $configFileOrString );
        }
        else
        {
            $config = Tree::setupMemory( 'XML' , $configFileOrString );
            $config->setup();
        }

        //
        //  apply xml given options to this class
        //
        if( $id = $config->getIdByPath('SimpleTemplate/options') )  // are any options given?
        {
            $delimiter = $config->getElementByPath('delimiter',$id);
            if( $delimiter )// set new delimiters?
            {
                $begin = $delimiter['attributes']['begin'];
                $end = $delimiter['attributes']['end'];
                if( $begin && $end )                // only if both delimiters are given !!!
                {
                    $setOptions['delimiter'] = array(trim($begin),trim($end));
                }
            }
            if( $autoBraces = $config->getIdByPath('autoBraces',$id) )// set autoBraces?
            {
                $setOptions['autoBraces'] = false;
                if( strtolower(trim($config->data[$autoBraces]['attributes']['value'])) == 'true' )
                    $setOptions['autoBraces'] = true;
            }
            if( $localeId = $config->getIdByPath('locale',$id) )// set locale?
            {
                $locale = trim($config->data[$localeId]['attributes']['value']);
                if( $locale )
                    $setOptions['locale'] = $locale;
            }

            // apply the options to this class
            $this->setOptions($setOptions);

            $this->applyOptionsToFilterClasses($setOptions);
#print_r($setOptions);
        }

# TODO check for prefilter defines in xml config
        if( $id = $config->getIdByPath('SimpleTemplate/preFilter') )  // are any preFilter given?
        {
        }
    }

    /**
    *   this method applies the given options to all the filters which are registered as object-methods
    *   by definition every filter class that needs to know the delimiters or any option
    *   set in this class here, needs to have an array options and make the methods setOptions available
    *   which simply gets the options passed, the name for the options must be defined as in here
    *
    *   @access     public
    *   @version    01/12/19
    *   @param      array   $setOptions options to apply
    *   @return     string  the modified template file, the config part is removed
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function applyOptionsToFilterClasses($setOptions)
    {
        $filters = array();

        // go thru all filters and get each class ONCE in the variable $filters
        $allFilters = array_merge( $this->preFilters , $this->postFilters );
        foreach( $allFilters as $aFilter )
#        foreach( $this->preFilters as $aFilter )
        {
            if( is_array($aFilter[1]) )
                $curClass = &$aFilter[1][0];
            else
                $curClass = &$aFilter[1];

# obviously each reference to the filter classes is different, its not enough to set
# the options just once for each class that is used for the filter :-(
# i dont really understand how php does that, or why, may be i have some error somewhere too :-)

#            if( !$filters[get_class($curClass)] )
            {
                $filters[get_class($curClass)] = true;
                call_user_func( array($curClass,'setOptions') , $setOptions );
            }
        }
    }

    /**
    *   find xml-tags for configuration inside the template
    *
    *   @access     public
    *   @version    01/12/19
    *   @param      string  $fileContent    the template file's content
    *   @return     string  the modified template file, the config part is removed
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function checkForXmlConfigInTemplate( $fileContent )
    {
        if( preg_match( '/<SimpleTemplate>.*<\/SimpleTemplate>/Uis' , $fileContent , $configString ) )
        {
            $this->applyXmlConfig( $configString[0] , true );
            $fileContent = preg_replace( '/<SimpleTemplate>.*<\/SimpleTemplate>/Uis' , '' , $fileContent );
        }
        return $fileContent;
    }

    /**
    *   show an error on the html page, format it, so it is obvious
    *
    *   @access     public
    *   @version    02/02/25
    *   @param      string  $message    the error message
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    */
    function showError( $message )
    {
        echo '<span style="color:red; background-color:FBFEA1; font-weight:bold;">SimpleTemplate ERROR</span><br>';
        echo '<span style="color:008000; background-color:FBFEA1;">';
        echo $message;
        echo '</span><br><br>';
    }
}
?>