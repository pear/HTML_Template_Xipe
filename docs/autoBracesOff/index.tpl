<!--//
    //
    // +----------------------------------------------------------------------+
    // | PHP Version 4                                                        |
    // +----------------------------------------------------------------------+
    // | Copyright (c) 1997, 1998, 1999, 2000, 2001, 2002, 2003 The PHP Group |
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
    //  $Id: index.tpl,v 1.1 2003-02-10 22:18:46 cain Exp $

//-->
<html>
    <head>
        <title>Example - HTML_Template_Xipe - autoBraces:off</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>
<body>

{if(sizeof($nums)>1):}
{foreach($nums as $aNum):}
{$aNum}
<br>
{endforeach;}{endif;}

               
<!-- 
    the same as above, just nicely formatted :-)
-->
{if(sizeof($nums)>1):}
    {foreach($nums as $aNum):}
        {$aNum}
        <br>
    {endforeach}
{endif}


</body>
</html>
