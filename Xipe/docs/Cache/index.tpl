<!--
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
//  $Id: index.tpl,v 1.5 2003-01-29 11:58:03 cain Exp $
-->




<!--

    the caching options
    this could also be in a file 'config.xml' (as the name is by default)
    which needs to be located under the templateDir

-->
<HTML_Template_Xipe>
    <options>
        <cache>
            <time value="10" unit="seconds"/>
        </cache>
    </options>
</HTML_Template_Xipe>











<html>
    <head>
        <title>Example - HTML_Template_Xipe - Cache</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>
<body>
<h1>Using the caching feature of HTML_Template_Xipe</h1>
Turning the feature on.<br>
As usual include the template engine and set the options.
In the options you simply add 'enable-Cache' and set it to true and that's it.<br>

<pre class="code">
require_once('HTML/Template/Xipe.php');
$options = array(
&nbsp;&nbsp;&nbsp;&nbsp;'templateDir'   => dirname(__FILE__),
&nbsp;&nbsp;&nbsp;&nbsp;'compileDir'    => 'tmp',
&nbsp;&nbsp;&nbsp;&nbsp;'enable-Cache'  => true &nbsp;&nbsp; // turn caching on
&nbsp;&nbsp;&nbsp;&nbsp;);
$tpl = new HTML_Template_Xipe($options);
</pre>

<br>
Now you can cache any file you want, simply by adding a short xml tag either in
the template file itself or you put it in a config-file which by default is named config.xml,
this file must be found along the path to the template. The engine starts looking for the
file in the template-dir and searched all the way to the current template. All the config-files
found on the way are applied in the same order. The last config that gets applied is the
one in the template itself if given.<br>
The configuration of a template is as easy as you can see in the following:
<pre class="code">
&lt;Template-Xipe&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="100" /&gt;
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/Template-Xipe&gt;
</pre>
this would simply cache the template's output (the final html file) for 100 seconds.<br>

<h2>Dependencies</h2>
Mostly it is necessary to cache the output depending on some variables, such as some input parameters
or depending on the values set by the previous/next logic of some kind of list view, etc.<br>
Therefore you can use the additional tag 'depends' inside the 'cache' tag, which takes any
kind of varible that is deinfed in the global namespace.<br>
For example:<br>

<pre class="code">
&lt;Template-Xipe&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="1" unit="week" /&gt;
&nbsp;          &lt;depends value="$_SESSION $myVar $anyVar" /&gt;
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/Template-Xipe&gt;
</pre>

<br>
BE WARNED: letting a cache-file depend on i.e. $_REQUEST makes it possible to
run a DOS-attack, since a new cache file has to be created everytime any
request parameter changes, i.e. 'http://your.site.com/index.php?whatever'
this might flood your webservers diskspace.



<h2>Syntax</h2>
The syntax of the caching tag is:<br>

<pre class="code">
&lt;Template-Xipe&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="x" [unit="week|weeks|day|days|hour|hours|minute|minutes|second"]/&gt;
&nbsp;          [&lt;depends value="$_SESSION $myVar $anyVar" /&gt;]
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/Template-Xipe&gt;
</pre>

</body></html>
