<html>
<?php
#########################程序简介##########################
# Spam Message Classifiers
# time 2017.12.16
# author: liu13
?>
<head>
    <title>垃圾短信识别</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
        body {background:#eee;}
        ul {padding:0; margin:0;}
        li {list-style:none;}
        #container {margin: 0 auto; width: 80%;}
        #title {color:#146fdf;font-size:25px; text-align:center; font-family:"YouYuan"; font-weight:bold;margin-top:40px;}
        a {color:#146fdf; text-decoration: none}
        a:hover {color: black; text-decoration: underline}
        #g_list {margin-top:60px; background:#fff;border-radius:4px}
        #g_u,#g_p {position:relative}
        #g_u {border-bottom:1px solid #eaeaea}
        .inputstyle {text-align:center;-webkit-tap-highlight-color:rgba(255,255,255,0); width:100%; height:144px;color:#000;border:0; background:0; font-size:16px;-webkit-appearance:none;line-height:normal; /* for non-ie */}
        #cjsubmit {margin-top:40px; width:100%; height:44px; color:#146fdf}
        .button {border:0px; width:100%; height:100%;color:white; background:#146fdf; border-radius:4px; font-size:16px;}
        #notice {text-align:center; margin-top:60px; color:#246183; line-height:14px; font-size:14px; padding:15px 10px}
    </style>
</head>
<body>
    <div id="container">
        <div id="title">垃圾短信识别</div>  
            <form method=post name="cf" target="_blank" onSubmit=javascript:chkfs()>
                <ul  id="g_list">
                    <li  id="g_u">
                        <div  id="del_touch"  class="del_touch">
                            <span  id="del_u"  class="del_u"  style="display: none;"></span>
                        </div>
                        <textarea  id="u"  class="inputstyle"  name="pmessage"  autocomplete="off" ></textarea>
                    </li>
                </ul>
            <div id="cjsubmit"><input type=submit value=识别 class="button"></div>
            <script language=javascript>  
                function chkfs(){ 
                var frm = document.forms['cf'];  
                frm.action="result.php";
                return true;  
                }
            </script>
        </form>
        <div id="notice">
            支持多种分类器：KNN, LR, RF, DT, GBDT, SVM, MultinomialNB, BernoulliNB<BR>
        <p align=center>
            Powered by <a href=http://JackieLiu.win>Jackie Liu</a>
        </div>
    </div>
</body>
</html>