<?php

$fd01 = isset($_POST['fd01']) ? $_POST['fd01'] : '';
$fd02 = isset($_POST['fd02']) ? $_POST['fd02'] : '';
$fd03 = isset($_POST['fd03']) ? $_POST['fd03'] : '';
$fd04 = isset($_POST['fd04']) ? $_POST['fd04'] : '';
$fd05 = isset($_POST['fd05']) ? $_POST['fd05'] : '';
$fd06 = isset($_POST['fd06']) ? $_POST['fd06'] : '';
$fd07 = isset($_POST['fd07']) ? $_POST['fd07'] : '';
$fd08 = isset($_POST['fd08']) ? $_POST['fd08'] : '';
$fd09 = isset($_POST['fd09']) ? $_POST['fd09'] : '';
$fd10 = isset($_POST['fd10']) ? $_POST['fd10'] : '';

$a_fd = array(
   'fd01' => '大腸麵線',
   'fd02' => '魷魚羹'  , 
   'fd03' => '肉圓'    , 
   'fd04' => '蚵仔煎'  , 
   'fd05' => '臭豆腐'  , 
   'fd06' => '擔仔麵'  , 
   'fd07' => '米粉湯'  , 
   'fd08' => '生煎包'  , 
   'fd09' => '刈包'    , 
   'fd10' => '珍珠奶茶' );


$str = '';
$str .= ($fd01=='Y') ? '<br>已確認...'.$a_fd['fd01'] : '';
$str .= ($fd02=='Y') ? '<br>已確認...'.$a_fd['fd02'] : '';
$str .= ($fd03=='Y') ? '<br>已確認...'.$a_fd['fd03'] : '';
$str .= ($fd04=='Y') ? '<br>已確認...'.$a_fd['fd04'] : '';
$str .= ($fd05=='Y') ? '<br>已確認...'.$a_fd['fd05'] : '';
$str .= ($fd06=='Y') ? '<br>已確認...'.$a_fd['fd06'] : '';
$str .= ($fd07=='Y') ? '<br>已確認...'.$a_fd['fd07'] : '';
$str .= ($fd08=='Y') ? '<br>已確認...'.$a_fd['fd08'] : '';
$str .= ($fd09=='Y') ? '<br>已確認...'.$a_fd['fd09'] : '';
$str .= ($fd10=='Y') ? '<br>已確認...'.$a_fd['fd10'] : '';



$html = <<< HEREDOC
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>測試</title>

</head>
<body>
<p><a href="javascript:history.go(-1)">回前頁</a></p>
<h2>已確認下列餐點</h2>
{$str}
</body>
</html>
HEREDOC;

echo $html;
?>