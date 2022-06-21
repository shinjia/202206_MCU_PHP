<?php

ini_set( 'date.timezone', 'Asia/Taipei');
$now = date('Y-m-d H:i:s', time());


$num = mt_rand(1,6);
$pic = 'images/' . $num . '.jpg';


// 丟兩個骰子
// $dice1 = mt_rand(1,6);
// $dice2 = mt_rand(1,6);

// $dice = mt_rand(2,12);


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>現在是：{$now}</p>
    <h1>幸運數字</h1>    
    <p><img src="{$pic}"></p>
    <p><a href="">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>