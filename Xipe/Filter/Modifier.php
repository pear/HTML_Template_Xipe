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
*
*
*   @package    SimpleTemplate/Filter
*   @access     public
*   @version    02/06/26
*   @author     Wolfram Kriesing <wolfram@kriesing.de>
*/
class SimpleTemplate_Filter_Modifier extends SimpleTemplate_Options
{

    var $_imgDirs = array();
    var $_imgFiles = array();
    var $_imgExt = array();

    /**
    *   this filter trys to read all the <img src> tags and replaces the src tags with the complete file name
    *   Using this filter makes it easier to work without looking up
    *   where the image really is located every time
    *   You simply need to give the image name and this filter searches for
    *   the image in the image root and rewrites the image name including
    *   the complete path to the image, so this saves time when developing and
    *   no php processing is necessary anymore when you have image tags like this:
    *   <img src="{$imgRoot}/dir/name/image">
    *
    *   @version    02/06/27
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  the original template code
    *   @param      string  the virtual image path
    *   @param      string  here you can set the prefered image type
    *                       so that you only need to give the image name w/o its extension
    *                       and if multiple images are found the prefered one is used
    *   @return     string  the modified template
    */
    function imgSrc( $input , $imageRoot , $vImgRoot , $preferedType='gif' , $dropDirs=array('CVS'))
    {
        $_imgTypes = array('gif','jpg','png');

        // put the prefered type first, so we find it first :-)
        $imgTypes = array($preferedType);
        foreach( $_imgTypes as $aImgType )
            if( $aImgType != $preferedType )
                $imgTypes[] = $aImgType;

        $found = array();

        $regExp = '/<img.+src="(.*)"/Ui';
        preg_match_all($regExp,$input,$images);
        if(sizeof($images[1]))
        {
            if( !sizeof($this->_imgDirs) )  // get image dirs if we didnt yet, since this instance might be used multiple times
            {
                $this->_getDirs($imageRoot,$dropDirs);
                $this->_imgDirs = $this->_foundDirs;
            }

            // go thru all the images we have found and find their path
            foreach( $images[1] as $aImage)
            {
                if( $this->_imgFiles[$aImage] )
                    $found[$aImage] = $this->_imgFiles[$aImage];
                else
                {
                    if( sizeof($this->_imgDirs) )
                    foreach( $this->_imgDirs as $aDir ) // go thru all the directories found
                    {
                        // using pathinfo returns also the file's extension
                        $fileInfo = pathinfo($aImage);
                        // if there is an extension we assume that this one is used
                        $_imgTypes = $fileInfo['extension'] ? array('') : $imgTypes;
                        foreach( $_imgTypes as $aType ) // if no file extension given loop through all possible imgTypes
                        {
                            $aType = $aType ? ".$aType" : '';
#print "....check $aDir $aImage$aType<br>";
                            if( @file_exists($aDir.$aImage.$aType))
                            {
                                $this->_imgFiles[$aImage] = str_replace($imageRoot,$vImgRoot,$aDir);
                                $this->_imgExt[$aImage] = $aType;
#print 'found<br>';
                                break(2);
                            }
                            if( @file_exists($aDir.'/'.$aImage.$aType))
                            {
                                $this->_imgFiles[$aImage] = str_replace($imageRoot,$vImgRoot,$aDir.'/');
                                $this->_imgExt[$aImage] = $aType;
#print 'found<br>';
                                break(2);
                            }
                        }
                    }
                }
            }
        }

        if( sizeof($this->_imgFiles) )
        foreach( $this->_imgFiles as $file=>$path )
        {
            $_file = str_replace('/','\\/',preg_quote($file));  //"
            $regExp = '/<img(.+)src="'.$_file.'"/Ui';
            $input = preg_replace($regExp,'<img$1src="'.$path.$file.$this->_imgExt[$file].'"',$input);
        }

        return $input;
    }

    /**
    *   find all dirs in the given one, writes them into _foundDirs
    *   be sure to copy them from there when using
    *   this method calls itself recursively to get all subdirs too
    *   watch out if there are links which could cause endless loops
    *   i havent checked if that can happen
    *
    *   @version    02/06/27
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  the directory under which to search
    *   @param      array   directories that shall be left out, like CVS
    */
    function _getDirs( $root , $dropDirs=array() )
    {
        $dirs = array();
        if ($handle = @opendir($root))
        {
            while (false !== ($file = readdir($handle)))
            {
                if( $file!='.' &&  $file!='..' && is_dir($root.'/'.$file) && !in_array($file,$dropDirs))
                {
                    $dirs[] = $file;
                }
            }
            closedir($handle);
        }

        sort($dirs);
        foreach( $dirs as $aDir )
        {
            $this->_foundDirs[] = $root.'/'.$aDir;
            $this->_getDirs($root.'/'.$aDir,$dropDirs);
        }
    }


    /**
    *   correct all links, if they are not proper like www.home.de
    *   then they will be corrected to be http://www.home.de
    *   a link checker could be implemented too :-/
    *
    *   @version    02/06/27
    *   @author     Wolfram Kriesing <wolfram@kriesing.de>
    *   @param      string  the original template code
    *   @param      string  the virtual image path
    *   @return     string  the modified template
    */
    function aHref( $input )
    {
    }

}
?>