<!--
    $Log: not supported by cvs2svn $
    Revision 1.5  2003/01/14 22:08:19  cain
    - properly convert to Xipe

    Revision 1.4  2002/06/02 22:38:56  mccain
    - convert all config-tags to lower case, this is secure for now
      also if the Tree-package is not updated

    Revision 1.3  2002/05/26 17:12:19  mccain
    - added log

-->

<HTML_Template_Xipe>
    <options override="yes">
        <delimiter begin="[" end="]"/>
        <autoBraces value="true"/>
        <locale value="en"/>
    </options>
</HTML_Template_Xipe>

<html>
    <head>
        <title>Example - HTML_Template_Xipe, XML-configured</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>

<body>

<h2>XML-configured template</h2>

<a href="http://sourceforge.net/projects/simpletpl/">DOWNLOAD</a><br>
This example uses both possible ways to configure this template, it first reads the
<a href="[$viewConfigXmlUrl]">config.xml which is in the same directory as the template</a>
and it reads the xml-data which are inside
<a href="[$viewTemplateCodeUrl]">this template file</a>, surely this doenst make much sense in this
example, but it demonstrates how the config might be applied.<br>
You can put the config.xml file anywhere in the 'templateDir' if it is found on the path to the template
it will be applied.
<br><br>

This is the XML-part which configures this template, either in the
<a href="[$viewConfigXmlUrl]">config.xml</a> or/and in this
<a href="[$viewTemplateCodeUrl]">template-file (index.tpl)</a>.<br>
<code>
&lt;HTML_Template_Xipe&gt;<br>
 &nbsp; &lt;options override="yes"&gt;<br>
 &nbsp;  &nbsp; &lt;delimiter begin="\[" end="\]"/&gt;<br>
 &nbsp;  &nbsp; &lt;autoBraces value="true"/&gt;<br>
 &nbsp;  &nbsp; &lt;locale value="en"/&gt;<br>
 &nbsp; &lt;/options&gt;<br>
&lt;/HTML_Template_Xipe&gt;<br>
</code>

<br><br>

<script type="text/javascript" language="JavaScript">


    /**
    *   the alert text if you click "really"
    *   @var    string  s
    */
    var s ="May be _one_disadvantage_ is that you need to escape \n"+
        "'{'  for getting a  '{'\n"+
        "and\n"+
        "'}'   for getting a  '}'\n"+
        "if those characters are your delimiters\n\n"+
        "i didnt mind it yet...\n";


    /**
    *   show an alert text as given in 's'
    *   @version    01/12/10
    */
    function really()
    {
        alert(s);
    }

</script>

<table border="1">
    <tr>
        <td valign="top">
            If you like :

            [foreach($advantages as $aAdvantage)]
                <li>
                [$aAdvantage]
                </li>
        </td>

        <td valign="top">
            And you &nbsp; D O N ' T &nbsp; like :

            [foreach($dontLike as $aDontLike)]
                <li>
                [$aDontLike]
                </li>
        </td>
    </tr>
</table>
then you should try HTML_Template_Xipe.<br><br>

<br><br>

[foreach($disadvantages as $aDisadvantage)]
    <li>[$aDisadvantage]</li>
[else]
    no disadvantages registered yet (<a href="javascript:really()">really?</a>)
    , but feel free and mail
    <a href="mailto:wolfram@kriesing.de">me</a><br>
    <a href="[$viewSourceCodeUrl]">but look at the code first</a><br>
    <a href="[$viewTemplateCodeUrl]">and the template</a><br>
    <a href="[$viewCompiledTemplate]">and the complied template</a><br>
    <a href="[$viewTemplateLog]">template log file</a><br>
    <br><br>


<h2>all the currently possible and working xml-options - overview</h2>
<code>
&lt;HTML_Template_Xipe&gt;<br>
 &nbsp; &lt;options&gt;<br>
 &nbsp;  &nbsp; &lt;delimiter begin="\[" end="\]"/&gt;<br>
 &nbsp;  &nbsp; &lt;autoBraces value="true"/&gt;<br>
 &nbsp;  &nbsp; &lt;locale value="en"/&gt;<br>
 &nbsp;  &nbsp; &lt;cache&gt;<br>
 &nbsp;  &nbsp;  &nbsp; &lt;time value="x" unit="week|weeks|day|days|hour|hours|minute|minutes|second"/&gt;<br>
 &nbsp;  &nbsp;  &nbsp; &lt;depends value="$someVar $anotherVar $_nextVar"/&gt;<br>
 &nbsp;  &nbsp; &lt;/cache&gt;<br>
 &nbsp; &lt;/options&gt;<br>
&lt;/HTML_Template_Xipe&gt;<br>
</code>


</body>
</html>
