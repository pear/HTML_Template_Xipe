<!--
    $Log: not supported by cvs2svn $
    Revision 1.1  2002/06/02 22:34:28  mccain
    - initial commit

-->

<simpletemplate>
    <options>
        <cache>
            <time value="10" />
        </cache>
    </options>
</simpletemplate>


<html>
    <head>
        <title>Example - SimpleTemplate - Cache</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>
<body>
<h1>Using the caching feature of SimpleTemplate</h1>
Turning the feature on.<br>
As usual include the template engine and set the options.
In the options you simply add 'enable-Cache' and set it to true and that's it.<br>
<code>
require_once('SimpleTemplate/Engine.php');<br>
$options = array(<br>
&nbsp;&nbsp;&nbsp;&nbsp;'templateDir'   => dirname(__FILE__),<br>
&nbsp;&nbsp;&nbsp;&nbsp;'compileDir'    => 'tmp',<br>
&nbsp;&nbsp;&nbsp;&nbsp;'enable-Cache'  => true &nbsp;&nbsp; // turn caching on<br>
&nbsp;&nbsp;&nbsp;&nbsp;);<br>
$tpl = new SimpleTemplate_Engine($options);<br>
</code>
<br>
Now you can cache any file you want, simply by adding a short xml tag either in
the template file itself or you put it in a config-file which by default is named config.xml,
this file must be found along the path to the template. The engine starts looking for the
file in the template-dir and searched all the way to the current template. All the config-files
found on the way are applied in the same order. The last config that gets applied is the
one in the template itself if given.<br>
The configuration of a template is as easy as you can see in the following:
<pre><code>
&lt;simpletemplate&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="100" /&gt;
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/simpletemplate&gt;
</code></pre>
this would simply cache the template's output (the final html file) for 100 seconds.<br>

<h2>Dependencies</h2>
Mostly it is necessary to cache the output depending on some variables, such as some input parameters
or depending on the values set by the previous/next logic of some kind of list view, etc.<br>
Therefore you can use the additional tag 'depends' inside the 'cache' tag, which takes any
kind of varible that is deinfed in the global namespace.<br>
For example:<br>
<pre><code>
&lt;simpletemplate&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="1" unit="week" /&gt;
&nbsp;          &lt;depends value="$_SESSION $myVar $anyVar" /&gt;
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/simpletemplate&gt;
</code></pre>
<br>
BE WARNED: letting a cache-file depend on i.e. $_REQUEST makes it possible to
run a DOS-attack, since a new cache file has to be created everytime any
request parameter changes, i.e. 'http://your.site.com/index.php?whatever'
this might flood your webservers diskspace.



<h2>Syntax</h2>
The syntax of the caching tag is:<br>
<pre><code>
&lt;simpletemplate&gt;
&nbsp;  &lt;options&gt;
&nbsp;      &lt;cache&gt;
&nbsp;          &lt;time value="x" [unit="week|weeks|day|days|hour|hours|minute|minutes|second"]/&gt;
&nbsp;          [&lt;depends value="$_SESSION $myVar $anyVar" /&gt;]
&nbsp;      &lt;/cache&gt;
&nbsp;  &lt;/options&gt;
&lt;/simpletemplate&gt;
</code></pre>

</body></html>