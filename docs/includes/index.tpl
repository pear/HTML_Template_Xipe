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
    //  $Id: index.tpl,v 1.1 2003-02-10 22:19:08 cain Exp $

//-->

{%include include.mcr%}

<html>
    <head>
        <title>Example - HTML_Template_Xipe - includes</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>
<body>

    This examples uses the <b>new include features, introduced in version 1.7.2</b>
    and shows how it all works with autoBraces-OFF.        <br><br>
    The enhanced includes work the following way:<br>
    The tag <b>\{%include include.tpl%\}</b> includes the given file, which is searched
    for in the templateDir first and in the include path second. The included file
    includes another file again, you can nest them as deep as you want!<br>
    NOTE: Recursive nesting will cause a warning!<br>
    <br>

    The autoBraces-OFF are used here and we are using macros <b>\{%include include.mcr%\}</b>.
    Since autoBraces is OFF we need a new macro tag to be introduced:
    it is the <b>\{%endmacro%\}</b> this is needed to tell the end of a macro, since
    autoBraces is not on, you need to tell the end of a macro manually.

    <br><br><br>
    ---------------------------
    <br><br>


    {%include include.tpl%}


    {%include_text()%}
                                
    <br>
    ----------------------------
    <br><br>
    just to show the if and foreach constructs, well you know them from PHP
    those are the <b>if():</b> and <b>endif</b> and alikes.
    <br>
    {if(sizeof($nums)>1):}
        {foreach($nums as $aNum):}
            {$aNum}
            <br>
        {endforeach}
    {endif}
             
    
    {foreach($unknown as $xxx):}
        {$xxx}
        <br>
    {endforeach}

</body>
</html>
