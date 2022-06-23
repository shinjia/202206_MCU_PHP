<?php
// 隨機產生1~9的背景圖檔
$n1 = mt_rand(1,9);
$img_background = 'images/bg' . $n1 . '.jpg';


// 一週的每天顯示不同的主畫面圖片
$n3 = date("w", time());  // 傳回0~6的星期數值
$img_picture = 'images/w' . $n3 . '.jpg';


// 每分鐘使用不同的橫幅圖
$n2 = date("i", time()) % 5;  // 但只有五張輪替，故取餘數，會得到0到4的值
$img_banner = 'images/poem' . $n2 . '.jpg';
$lnk_poem = 'poem' . $n2 . '.html';

/*
for($i=0; $i<60; $i++)
{
   echo $i . "--->" . ($i%5);
   echo '<br>';
}
exit;
*/

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>隨機顯示圖片</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body background="{$img_background}">
<p align="center">
   <a href="{$lnk_poem}"><img src="{$img_banner}" border="0" width="468" height="60"></a>
</p>
<table border="3" align="center" cellpadding="10" bordercolor="#CC9900" bgcolor="#990066">
  <tr>
    <td><div align="center"><font color="#FFFF00">每週畫作欣賞</font></div></td>
  </tr>
  <tr>
    <td><img src="{$img_picture}" width="400" height="300"></td>
  </tr>
</table>
</body>
</html>
HEREDOC;

echo $html;
?>