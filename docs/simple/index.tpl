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
    //  $Id: index.tpl,v 1.1 2003-02-10 22:20:00 cain Exp $

//-->
<html>
    <head>
        <title>Example - HTML_Template_Xipe</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>

<body>

<script type="text/javascript" language="JavaScript">


    /**
    *   the alert text if you click "really"
    *   @var    string  s
    */
    var s ="May be _one_disadvantage_ is that you need to escape \n"+
        "'\\\{'  for getting a  '\{'\n"+
        "and\n"+
        "'\\\}'   for getting a  '\}'\n"+
        "if those characters are your delimiters\n\n"+
        "i didnt mind it yet...\n";


    /**
    *   show an alert text as given in 's'
    *   @version    01/12/10
    */
    function really()
    \{
        alert(s);
    \}

</script>

<table border="1">
    <tr>
        <td valign="top">
            If you like :

            {foreach($advantages as $aAdvantage)}
                <li>{$aAdvantage}</li>
        </td>

        <td valign="top">
            And you &nbsp; D O N ' T &nbsp; like :

            {foreach($dontLike as $aDontLike)}
                <li>{$aDontLike}</li>
        </td>
    </tr>
</table>
then you should try HTML_Template_Xipe.<br><br>

<br><br>

{foreach($disadvantages as $aDisadvantage)}
    <li>{$aDisadvantage}</li>
{else}
    no disadvantages registered yet (<a href="javascript:really()">really?</a>)
    , but feel free and mail
    <a href="mailto:wolfram@kriesing.de">me</a><br>
    <a href="{$viewSourceCodeUrl}">but look at the code first</a><br>
    <a href="{$viewTemplateCodeUrl}">and the template</a><br>
    <a href="{$viewCompiledTemplate}">and the complied template</a><br>
    <a href="{$viewTemplateLog}">template log file</a><br>
    <br><br>

</body>
</html>
