<html>
<?php
#########################程序简介##########################
# Spam Message Classifiers
# time 2017.12.16
# author: liu13

$nomessage = "<font size=4 color=red>请输入短信内容!</font>";           //输入错误时的信息

?>
<head>
    <title>垃圾短信识别</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
    #title {color:#146fdf;font-size:25px; text-align:center; font-family:"YouYuan"; font-weight:bold;margin-top:40px;margin-bottom:30px;}
    body {background:#eee;}
    #container {margin:0 auto; width: 80%;}
    a {color:#146fdf; text-decoration: none}
    a:hover {color: black; text-decoration: underline}
    .button {border:0px;width:100%; height:100%; color:white; background:#146fdf; border-radius:4px; font-size:16px;}
    #closewindos {margin-top:60px; width:30%; height:30px; color:#146fdf}
    #notice {text-align:center; margin-top:60px; color:#246183; line-height:14px; font-size:14px; padding:15px 10px}
    table {border:1px solid #eaeaed;}
    td {font-size:20px;border-bottom:1px solid #eaeaed; color:#246183}
    </style>
</head>
<body>
    <div id="container">
        <center>
        <div id="title">垃圾短信识别</div>
        <?php
        error_reporting(0);  //禁用错误报告
        #var_dump($_POST);
        if($_POST[pmessage]=="") echo $nomessage; 
        else{
            $output = shell_exec('python /Users/liu/Sites/Model/demoAPI.py'.' '.$_POST[pmessage]);
            echo"<font color=#246183>各分类器检测结果如下</font> </br></br></br>";
            #返回结果形如：LR:[u'1'],RF:[u'1']
            $array = explode(',', $output);
            echo"<table>";
            for ($i=0;$i<count($array)-1;$i++) {
                $result = explode(':', $array[$i]);
                echo"<tr><td><font color=red>$result[0]</font></td>
                         <td>----------</td>
                         <td>$result[1]</td></tr>";
            }
            echo"</table>";
        }
        
        ?>

        <div id="closewindos"><input type="button" value="关闭此页" class="button" onClick="javascript:window.close()"></div>
        </center>
        <div id="notice">
            支持多种分类器：KNN, LR, RF, DT, GBDT, SVM, MultinomialNB, BernoulliNB<BR>
        <p align=center>
            Powered by <a href=http://JackieLiu.win>Jackie Liu</a>
        </div>
    </div>
</body>
</html>