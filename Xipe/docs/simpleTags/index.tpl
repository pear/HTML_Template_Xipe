<SimpleTemplate>
    <options>
        <autoBraces value="false"/>
    </options>
    <preFilter>
        <!--
            if 'class' is given it's assumed, that the class name
            represents also the path name, so SimpleTemplate_Filter_SimpleTag
            means the file is in SimpleTemplate/Filter/SimpleTag.php
            which means (mostly) the file has to be in the include path!

            if 'classFile' is given it will be used for including the proper file
            so it could also be     classFile="SimpleTemplate/Filter/SimpleTag.php"
        -->
        <register class="SimpleTemplate_Filter_SimpleTag"/>
    </preFilter>
</SimpleTemplate>


<html>
    <head>
        <title>Example - SimpleTag language</title>
        <link href="../style.css" type="text/css" rel="StyleSheet">
    </head>
<body>

#if( sizeof($tasks) )
#foreach($tasks as $aTask)
    {$aTask}{$aTask}

    <br><br>
    {$aTask} {$aTask}

    <br><br>
    first escaped<br>
    \{$aTask\}{$aTask}

    <br><br>
    second escaped<br>
    {$aTask}\{$aTask\}

    <br><br>
    first escaped<br>
    \{$aTask\} {$aTask}

    <br><br>
    second escaped<br>
    {$aTask} \{$aTask\}
    <br>
#end#end
<br>


leave this alone
(sizeof())
<br><br>

this causes problems sometimes, for some reason the SimpleTag-filter replaces the " with a \"
but if i use stripslashes in there the \{ will be stripped too and that i need for the # if stuff
<br>
{$tasks?"tasks":"no tasks"}
<br>
{$tasks?&quot;tasks&quot;:&apos;no tasks&apos;}

<br>
#foreach(test() as $aTask)#foreach(test() as $aTask){$tasks[&apos;one&apos;]}{$tasks[&apos;two&apos;]}<br>#end#end
<br>
#foreach(test() as $aTask)
    {$aTask}
    <br>
#end
<br>
#foreach(u::test() as $aTask)
    {$aTask}
    <br>
#end
<br>
#foreach(u::test() as $aTask){$aTask}<br>#end
<br>



</body>
</html>