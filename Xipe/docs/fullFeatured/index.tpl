<html>
    <head>
        <title>Example - SimpleTemplate</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>

    <style>
        td.comment
        \{
            background-color:#DDDDFF;
        \}
    </style>
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

<table>
    <tr>
        <td colspan="4" class="comment">
            <h1>Standard</h1>

            Actually I wanted a template engine which doesnt do much more than releiving me from the annoying
            &lt;?php - tags in the HTML code and i didnt want any overhead such as assign-methods, to declare a
            variable which can be used in the template. I simply wanted to have all the variables available in the
            template that are also available in the php code.
            Because with other template engines, I had come across the problem very often,
            that i only wanted to print out a variable like $HTTP_HOST but had to assign it first to another variable
            which would then be available in the template, this seems to compilcated to me.<br>
            And since i didnt find any template engine which did all this for me i had to write this one :-)<br>
            Furthermore i didnt want to learn any new language which simply is less flexible than php, i wanted to be able
            to use php-features inside the code too, but without some of it's limitations and with the
            possiblity to add more features (see the TagLib).
            Therefore i implemented some
            things that make it much easier to use php inside a template. Still designers dont have to learn much more than
            'if' and 'foreach' to create standard pages.<br>
            The simplifications are:<br>
            - no php-tags anymore, only a customizable character/string, such as '\{' and '\}'<br>
            - auto block building using the given indention, which also makes the code much better readable<br>
            - auto print out, by detecting '\{$' (where '\{' is the beginDelimiter ) and converting it into '&lt;?='<br>

            <br>
            <h2>Basic Rules</h2>

            <h3>By default</h3> &lt;beginDelimiter&gt; is '\{', and<br>
            the &lt;endDelimiter&gt; is '\}', but since it is customizable i am using the 'long-form'.<br><br>

            Syntax: <code>&lt;beginDelimiter&gt;content&lt;endDelimiter&gt;</code><br>
            The above term is normally simple translated into: &lt;?php content ?&gt;<br>
            An Exception is the following case<br>

            <h3>To print out directly simply use</h3>
            Syntax: <code>&lt;beginDelimiter&gt;$varName&lt;endDelimiter&gt;</code><br>
            as soon as a '$' sign is found behind the 'beginDelimiter' it is converted to &lt;?=$varName ?><br>
            where $varName can also be:<br>
            - $object->property<br>
            - $object->method($someotherVar)<br>
            - $object->method($objectY->methodX())<br>

            <h3>To assign a varibale you can do the following:</h3>
            Syntax: <code>&lt;beginDelimiter&gt; $varName=0&lt;endDelimiter&gt;</code><br>
            Note the space before the '$', this simple makes $varName not being printed, it converts it to &lt;php $varName=0 ?&gt;<br>

            <h3>To build a block, which in php would be done using '\{' and '\}'</h3>
            Syntax:<br>
            <code>
                &lt;beginDelimiter&gt;if or foreach&lt;endDelimiter&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;some text, or html<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;beginDelimiter&gt;or processed code&lt;endDelimiter&gt;<br>
                &lt;beginDelimiter&gt;else&lt;endDelimiter&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;some other text, or other html<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;beginDelimiter&gt;or other processed code&lt;endDelimiter&gt;<br>
            </code><br>
            Simply indent the code, that shall be in the block, the braces are automatically set around it.<br>
            The code above will become:<br>
            <code>
                &lt;?php if or foreach \{?&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;some text, or html<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;?php or processed code ?&gt;<br>
                &lt;?php \} else \{ ?&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;some other text, or other html<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;?php or other processed code ?&gt;<br>
                &lt;?php \} ?&gt;<br>
            </code><br>

            <br>

            <h2>To get it running</h2>

            1.
            Download the SimpleTemplate classes from
            <a href="http://sourceforge.net/project/showfiles.php?group_id=46064">sourceforge.net/projects/simpletpl</a>.<br>
            2.
            Be sure to have the PEAR installed (which is default in a php-installation)!<br>
            3.
            Put the SimpleTemplate-directory in your include path (just as the PEAR should be). You can do this either
            by modifiying your php.ini and add the path to 'include_path'. Or add this piece of code
            <code>ini_set('include_path','/complete/path/to/where/SimpleTemplate-dir/is');</code>
            <br>
            4.
            And then simply include this code.

            <br><br>
            <code>
                require_once('SimpleTemplate/Engine.php');<br>
                <br>
                $options = array(<br>
                &nbsp;&nbsp;'templateDir'   => $DOCUMENT_ROOT.'/path/to/where/the/tempaltes/are',<br>
                &nbsp;&nbsp;'compileDir'    => $DOCUMENT_ROOT.'/path/to/a/tmp/dir');    // all compiled tpl's go here<br>
                &nbsp;&nbsp;or even shorter<br>
                &nbsp;&nbsp;'compileDir'    => 'tmp');    // now the compileDir is '&lt;templateDir&gt;/tmp'<br>
                <br>
                $tpl = new SimpleTemplate_Engine($options);<br>
            </code>

            <h2>Basic Filters</h2>

            If you are instanciating the template class it has since version 1.5 by default
            the 'filterLevel' set to 10 (in the options), which means
            that all filters that are normally needed are turned on. You can set it to 0 to turn off all filters.
            <br>
            The default filters are:<br>
            Basic-filters<br>
            - removeHtmlComments, removeCStyleComments, addIfBeforeForeach, removeEmptyLines, trimLines, optimizeHtmlCode<br>
            TagLib-filters<br>
            - includeFile, block, trimByWords, trim, repeat, applyHtmlEntites<br>


            <br>
            To manually add an additional or any custom filter simply make an instance of the filter class and register the filter
            as shown in the following.
            <br>
            <code>
                require_once('SimpleTemplate/Filter/Basic.php');<br>
                <br>
                // NOTE: since version 1.5 you should use '$tpl->getOptions()' to get the options<br>
                $tplFilter = new SimpleTemplate_Filter_Basic($tpl->getOptions());<br>
            </code>
            <h3>Pre-Filters</h3>
            Remove HTML comments and to optimize the HTML that will be delivered to the client.<br>
            <code>
                $tpl->registerPrefilter(array(&$tplFilter,'removeHtmlComments'));<br>
            </code>
            <br>
            Remove C-comments and to optimize JavaScript that will be delivered to the client.<br>
            <code>
                $tpl->registerPrefilter(array(&$tplFilter,'removeCStyleComments'));<br>
            </code>
            <br>
            Add an 'if' before every 'foreach' to prevent warnings when the variable shall be looped.<br>
            This has a positive side effect, you can use an 'else' on an 'foreach' since an 'if' preceeds it,
            see examples.<br>
            <code>
                // this filter makes the foreach-blocks conditional, so they are only shown if they contain data, see api-doc<br>
                $tpl->registerPrefilter(array(&$tplFilter,'addIfBeforeForeach'));   <br>
            </code>

            <h3>Post-Filters</h3>
            Remove spaces at the beginning and at the end of each line, to cut down the size of the file
            that needs to be delivered to the client.<br>
            <code>
                $tpl->registerPostfilter(array(&$tplFilter,'trimLines'));<br>
            </code>
            <br>
            Optimize the HTML code, remove unnecesary spaces etc. also to shrink the code size.<br>
            <code>
                $tpl->registerPostfilter(array(&$tplFilter,'optimizeHtmlCode'));<br>
            </code>
            <br>
            Applies the function 'html_entities' to every variable that is printed from the template.<br>
            This converts everything to proper HTML.<br>
            NOTE: It might not be the wish to convert everything to HTML, stuff like $HTTP_HOST, $DOCUMENT_ROOT
            are sometimes needed to be printed out as they are. Then look at the TagLib function 'applyHtmlEntites'.<br>
            <code>
                $tpl->registerPostfilter(array(&$tplFilter,'applyHtmlEntites'));<br>
            </code>


        </td>
    </tr>
</table>

<h3>pre-defined variables, and their content</h3>
<code>
$repeatValue = {$repeatValue}<br>
$trimValue = '{$trimValue}'<br>
$loop = {print_r($loop)}<br>

<br>
<b>The Template-instance options</b><br>
{foreach($tpl->getOptions() as $key=>$aOption)}
    $tpl-&gt;getOption('{$key}') =&gt;&nbsp;
    {if(is_array($aOption))}
        {print_r($aOption)}
    {else}
        {$aOption}
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
        <td><code>\{$tpl-&gt;getOption('locale')\}</code></td>
        <td>
            {$tpl->getOption('locale')}
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
            \{foreach($tpl-&gt;getOption('delimiter') as $key=&gt;$value)\}<br>
            &nbsp; &nbsp;\{$key\} =&gt; \{$value\}&lt;br&gt;<br>
        </code></td>
        <td>
            {foreach($tpl->getOption('delimiter') as $key=>$value)}
                {$key} =&gt; {$value}<br>
        </td>
        <td>
            - simple loop, as you would do in PHP
        </td>
    </tr>


    <tr>
        <td nowrap><code>
            \{foreach($tpl-&gt;getOptions() as $key=&gt;$aOption)\}<br>
            &nbsp; \{$key\} =&gt;&nbsp;&lt;b&gt;\{%trim $aOption 10 "..."%\}<br>
            &nbsp; &lt;/b&gt;&lt;br&gt;

        </code></td>
        <td>
            {foreach($tpl->getOptions() as $key=>$aOption)}
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
     |  examples for " { % % } "
     |
     +-->
    <tr>
        <td colspan="4" class="comment">
            <h1>TagLib</h1>
            All extra-functionality that extends the template-engine is collected in the &quot;TagLib&quot;.<br>
            All TagLib tags are surrounded by the delimiters and additionally a '%'-sign inside at the beginning
            and at the end.<br><br>
            Syntax: &lt;beginDelimiter&gt;%content%&lt;endDelimiter&gt;<br><br>
            <b>to activate the TagLib functionality insert the following code in your php file</b><br><br>
            <code>
                require_once('SimpleTemplate/Filter/TagLib.php');<br><br>
                // $tpl is the instance of SimpleTemplate_Engine,<br>
                // passing this parameter passes all the options to the created instance<br>
                $tagLib = new SimpleTemplate_Filter_TagLib($tpl->getOptions());<br><br>
            </code>
        </td>
    </tr>
    <tr>
        <td rowspan="2">TagLib, applyHtmlEntites</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'applyHtmlEntites'));<br>
            </code>
        </td>
    </tr>
    <tr>
        <td><code>\{%$trimValue%\}</code></td>
        <td>
            {%$trimValue%}
        </td>
        <td>
            - simply converts all not-HTML characters to proper HTML<br>
        </td>
    </tr>

    <!--
     |
     |  examples for "repeat"
     |
     +-->
    <tr>
        <td rowspan="6">TagLib, repeat</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'repeat'));<br>
            </code>
        </td>
    </tr>
    <tr>
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
        <td rowspan="5">TagLib, trim</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'trim'));<br>
            </code>
        </td>
    </tr>
    <tr>
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
     |  examples for "trimByWords"
     |
     +-->
    <tr>
        <td rowspan="2">TagLib, trimByWords</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'trimByWords'));<br>
            </code>
        </td>
    </tr>
    <tr>
        <td><code>\{%trim $trimValue by words after 5 characters and add "..."%\}</code></td>
        <td>
            {%trim $trimValue by words after 5 characters and add "..."%}
        </td>
        <td>
            - trims a string but only at spaces, if there is no space
              at the given offset, it goes back in the string, so that the max-length
              is not longer than the given one
        </td>
    </tr>

    <!--
     |
     |  examples for "include"
     |
     +-->
    <tr>
        <td rowspan="2">TagLib, include</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'includeFile'));<br>
            </code>
        </td>
    </tr>
    <tr>
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
        <td rowspan="3">TagLib, block</td>
        <td colspan="3" class="comment">
            <b>to activate this functionality</b><br><br>
            <code>
                $tpl->registerPrefilter(array(&$tagLib,'block'));<br>
            </code>
        </td>
    </tr>
    <tr>
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