<?php
$conn=mysqli_connect("localhost","root","root","test");
$text = isset($_POST['text'])?$_POST['text']:'';
$pass = isset($_GET['token'])?$_GET['token']:'';
$word = date('Ymd');

if ($text!='') {
    filter_var($text, FILTER_SANITIZE_STRING);
  $sql = "insert into user (name) values ('$text')";
$result = mysqli_query($conn, $sql);
}
if ($pass!=md5($word)) {
    echo "非法访问";exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>聊天</title>
<style type="text/css">
#result{
    width: 100%;height: 80%;background-color: #e1e1e1;display: block;
}
hr{
    height: 1px;margin: 0;
}
#result span{
    line-height: 25px;
}
.input{
    position: absolute;
    bottom: 0;
    width: 100%;
}
.input input{
    height: 25px;
    width: 80%;
}
.input button{
    margin: 10px;
}
</style>
</head>
<body>
<h1>实时聊天记录</h1>
<div id="result">

</div>
<div class="input">
<div><input type="text" name="text" id="text"><button onclick="sendmsg()">发送</button></div>
</div>
<script>
if(typeof(EventSource)!=="undefined")
{
    var source=new EventSource("a.php");
    source.onmessage=function(event)
    {
        var text = event.data;
        var obj = JSON.parse(text);
        var html='<span>';
        for (var i = obj.length - 1; i >= 0; i--) {
            html+=obj[i]['name'] + "</span><hr><span>";
        }
        document.getElementById("result").innerHTML= html;
    };
}
else
{
    document.getElementById("result").innerHTML="抱歉，你的浏览器不支持";
}
function sendmsg()
{
    var xmlhttp;
    var txt=document.getElementById('text').value;
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // IE6, IE5 浏览器执行代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('text').value='';
        }
    }
    xmlhttp.open("POST","index.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('text='+txt);

}
</script>

</body>
</html>