<html>
    <head>
        <title>Example - SimpleTemplate</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>

<body>

<a href="http://sourceforge.net/projects/simpletpl/">DOWNLOAD</a><br>
<a href="{$viewClassCodeUrl}">class SimpleTemplate</a> source code<br>
<a href="{$viewFilterCodeUrl}">class SimpleTemplate_Filter_Basic</a> source code</a><br>
<a href="{$viewTagLibCodeUrl}">class SimpleTemplate_Filter_TagLib</a> source code</a><br>
<br>

here additionally used Features:<br>
<li>translate (i.e. into <a href="index.php?lang=de">german</a>, <a href="index.php?lang=en">english</a>)</li>
<li>translate does by the way also convert everything to proper HTML if you want to, but you can maintain it without that in the DB</li>
<li>all filters, that optimize the HTML page and cut down the page size, look at the HTML-code and you will see,
    this really has an effect on bigger sites</li>
<li>used filters are: removeHtmlComments, removeCStyleComments, addIfBeforeForeach, trimLines, optimizeHtmlCode</li>
<li>used TagLib-tags: includeFile, block, trim, repeat</li>

<br><br>
<a href="{$viewSourceCodeUrl}">look at the code</a><br>
<a href="{$viewTemplateCodeUrl}">and the template</a><br>
<a href="{$viewCompiledTemplate}">and the compiled template</a><br>
<a href="{$viewCompiledTemplateDe}">and the german compiled template</a><br>
<a href="{$viewTemplateLog}">template log file</a><br>
<a href="{$viewDbFile}">the DB file, for the translation</a><br>

<br><br>


<h3>pre-defined variables, and their content</h3>
<code>
$repeatValue = {$repeatValue}<br>
$trimValue = '{$trimValue}'<br>
$loop = {print_r($loop)}<br>

{foreach($tpl->options as $key=>$aOption)}
    $tpl-&gt;options[{$key}] =&gt;&nbsp;{$aOption}
    <br>

</code>
<br>
<h3>Examples</h3>
<table>
    <tr>
        <td>example for</td>
        <td>code</td>
        <td>code in use</td>
        <td>comment</td>
    </tr>



    <!--
     |
     |  standard examples
     |
     +-->
    <tr>
        <td rowspan="7">standard template language</td>
        <td><code>\{$trimValue\}</code></td>
        <td>
            {$trimValue}
        </td>
        <td>
            - simply <font>display</font> of a variable's content
        </td>
    </tr>
    <tr>
        <td><code>\{$tpl-&gt;options['locale']\}</code></td>
        <td>
            {$tpl->options['locale']}
        </td>
        <td>
            - simply <font>display any kind</font> of variables<br>
            - <font>just as you do in PHP</font>
        </td>
    </tr>
    <tr>
        <td><code>
            &lt;b&gt;<br>
            \{foreach($loop as $aLoop)\}<br>
            &nbsp; &nbsp;\{$key\} --- \{$aLoop\}&lt;br&gt;<br>
            &lt;/b&gt; &lt;!-- end of foreach block,<br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; because of missing indention --&gt;<br>
            and here goes standard html again
        </code></td>
        <td>
            <b>
            {foreach($loop as $key=>$aLoop)}
                {$key} =&gt; {$aLoop}<br>
            </b>
        </td>
        <td>
            - this what most template engines call <font>blocks</font>, <br> simply use the foreach as you are used to<br>
            - the <font>indention</font> makes it easy to leave out the<br>block delimiters, ' \{ ' and ' \} '
        </td>
    </tr>

    <tr>
        <td nowrap><code>
            \{foreach($tpl-&gt;options['delimiter'] as $key=&gt;$value)\}<br>
            &nbsp; &nbsp;\{$key\} =&gt; \{$value\}&lt;br&gt;<br>
        </code></td>
        <td>
            {foreach($tpl->options['delimiter'] as $key=>$value)}
                {$key} =&gt; {$value}<br>
        </td>
        <td>
            - simple loop, as you would do in PHP
        </td>
    </tr>


    <tr>
        <td nowrap><code>
            \{foreach($tpl-&gt;options as $key=&gt;$aOption)\}<br>
            &nbsp; \{$key\} =&gt;&nbsp;&lt;b&gt;\{%trim $aOption 10 "..."%\}<br>
            &nbsp; &lt;/b&gt;&lt;br&gt;

        </code></td>
        <td>
            {foreach($tpl->options as $key=>$aOption)}
                {$key} =&gt;&nbsp;<b>{%trim $aOption 10 "..."%}
                </b><br>
        </td>
        <td>
            - or loop through a variables content<br>
            <font>as you are used to in PHP</font><br>
            - for explaination of \{%trim ...%\} please look further down
        </td>
    </tr>
    <tr>
        <td>
            <code>
            \{foreach($emptyLoopVariable as $key=&gt;$aLoop)\}<br>
            &nbsp; &nbsp; \{$key\} --- \{$aLoop\}&lt;br&gt;<br>
            \{else\}<br>
            &nbsp; &nbsp; nothing&lt;br&gt;<br>
            &nbsp; &nbsp; in:&lt;br&gt;<br>
            &nbsp; &nbsp; $emptyLoopVariable<br>
            </code>
        </td>
        <td>
            {foreach($emptyLoopVariable as $key=>$aLoop)}
                {$key} --- {$aLoop}<br>
            {else}
                nothing<br>
                in:<br>
                $emptyLoopVariable
        </td>
        <td>
            - if you use the <font>filter 'addIfBeforeForeach'</font><br> an 'foreach' also has an 'else'<br>
            - the <font>block can be as big as you like</font> it to be
        </td>
    </tr>
    <tr>
        <td><code>
            \{if( sizeof($loop)>3 )\}<br>
            &nbsp; &nbsp; \{foreach($loop as $key=&gt;$aLoop)\}<br>
            &nbsp; &nbsp; &nbsp; &nbsp;\{$key\} --- \{$aLoop\}&lt;br&gt;<br>
            \{else\}<br>
            &nbsp; &nbsp; $loop doesnt have more than 3 values
        </code></td>
        <td>
            {if( sizeof($loop)>3 )}
                {foreach($loop as $key=>$aLoop)}
                    {$key} --- {$aLoop}<br>
            {else}
                $loop doesnt have more than 3 values
        </td>
        <td>
            - or any other combination of <font>nesting</font>,<br> just as endless as PHP allows it
        </td>
    </tr>


    <!--
     |
     |  examples for "repeat"
     |
     +-->
    <tr>
        <td rowspan="5">TagLib, repeat</td>
        <td><code>\{%repeat $repeatValue times%\}<br>&nbsp; &nbsp;  -<br></code></td>
        <td>
            {%repeat $repeatValue times%}
                -
        </td>
        <td>
            - a very <font>readable</font> way to use this, good for designer, who create those pages<br>
            - watch out to use proper indention for the block that shall be repeated
        </td>
    </tr>
    <tr>
        <td><code>\{%repeat $repeatValue%\}<br>&nbsp; &nbsp;  -<br></code></td>
        <td>
            {%repeat $repeatValue%}
                -
        </td>
        <td>
            - or simply that<br>
        </td>
    </tr>
    <tr>
        <td><code>\{%repeat $repeatValue times with $y%\}<br>
            &nbsp; &nbsp;  - \{$y\}<br></code></td>
        <td>
            {%repeat $repeatValue times with $y%}
                - {$y}
        </td>
        <td>
            - a <font>counter variable</font> can be used too<br>
            - the value is shown on every loop run, here it is named $y<br>
            - NOTE: the string 'times with' can be anything you like, it serves readability
        </td>
    </tr>
    <tr>
        <td><code>\{%repeat $repeatValue $counterVariable%\}<br>
            &nbsp; &nbsp;  - \{$counterVariable*2\}<br></code></td>
        <td>
            {%repeat $repeatValue $counterVariable%}
                - {$counterVariable*2}
        </td>
        <td>
            - or as simple as that<br>
            - and give the counter variable a name you like to
        </td>
    </tr>
    <tr>
        <td nowrap><code>\{%repeat $repeatValue many times, using $y%\}<br>
            &nbsp; &nbsp;  - \{$y*3\}<br></code></td>
        <td>
            {%repeat $repeatValue many times, using $y%}
                - {$y*3}
        </td>
        <td>
            - or as hard core extrem as you like<br>
            - write anything there, so others understand what is meant
        </td>
    </tr>



    <!--
     |
     |  examples for "trim"
     |
     +-->
    <tr>
        <td rowspan="4">TagLib, trim</td>
        <td><code>\{%trim $trimValue after 8 characters and add "..."%\}</code></td>
        <td>
            {%trim $trimValue after 8 characters and add "..."%}
        </td>
        <td>
            - readable version
        </td>
    </tr>
    <tr>
        <td><code>\{%trim $trimValue 12 "..."%\}</code></td>
        <td>
            {%trim $trimValue 12 "..."%}
        </td>
        <td>
            - or as simply as this
        </td>
    </tr>
    <tr>
        <td><code>\{%trim $trimValue 11%\}</code></td>
        <td>
            {%trim $trimValue 11%}
        </td>
        <td>
            - or even simpler, without adding anything
        </td>
    </tr>
    <tr>
        <td><code>\{%trim $trimValue 2 "...$trimValue..."%\}</code></td>
        <td>
            {%trim $trimValue 2 "...$trimValue..."%}
        </td>
        <td>
            - or kinda recursive<br>
        </td>
    </tr>


    <!--
     |
     |  examples for "include"
     |
     +-->
    <tr>
        <td rowspan="1">TagLib, include</td>
        <td><code>\{%include blocks/common.blocks%\}</code></td>
        <td>
        </td>
        <td>
            - includes the file 'blocks/common.blocks'<br>
            - this file can contain any kind of blocks,<br> which you can display using the \{%copy block ...%\} tag
        </td>
    </tr>

    <!--
     |
     |  examples for "block"
     |
     +-->
    <tr>
        <td rowspan="2">TagLib, block</td>
        <td><code>
            \{ %block showThis%\}<br>
            &nbsp; &nbsp; block content \{$trimValue\}<br>
            \{%/block%\}<br>
        </code>
        </td>
            {%block showThis%}
                block content<br>
                {$trimValue}
            {%/block%}
        <td>
        </td>
        <td>
            - define a block and its content here<br>
            - this block will simply be copied<br> where you write \{%copy block showThis%\}
        </td>
    </tr>

    <tr>
        <td><code>
            \{%copy block showThis here%\}<br>
        </code>
        </td>
        <td>
            {%copy block showThis %}
        </td>
        <td>
            - copy the block here and replace the variables normally<br>
        </td>
    </tr>

</table>


<br><br>

</body>
</html>