<html>
    <head>
        <title>Example - SimpleTemplate</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>

<body>

<a href="{$viewClassCodeUrl}">class SimpleTemplate - source code</a><br><br>

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
then you should try SimpleTemplate.<br><br>

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