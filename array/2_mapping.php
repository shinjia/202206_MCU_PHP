<?php
// 今天星期幾
$a = array('日', '一', '二', '三', '四', '五', '六' );
$w = date("w", time());   // 傳回星期 0,1,2,3,4,5,6
$now = date("Y-m-d", time()) . ' 星期 ' . $a[$w];


// 隨機背景色
$a_bg = array('#FFAAAA', '#FFFFAA', '#AAAAFF', '#FFAAFF', '#AAFFAA', '#AAFFFF');
$choice = mt_rand(0, count($a_bg)-1);  // 0,1,2,3,4,5
$bgcolor = $a_bg[$choice];


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>陣列對應的值</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
<!--
#showarea {
   position:absolute;
   width:250px;
   height:100px;
   left: 80px;
   top: 80px;
   text-align: center;
   background-color: {$bgcolor};
}
-->
</style>
</head>
<body>
<div id="showarea">
   <p>今天是 {$now}</p></div>
</body>
</html>
HEREDOC;

echo $html;
?>