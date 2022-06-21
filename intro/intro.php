<?php

$name = '陳信嘉';
$birth = 1967;
$photo = 'images/head1.jpg';

/*
$name = '阮經天';
$birth = 2000;
$photo = 'images/head2.jpg';
*/

$age = date('Y',time()) - $birth;  // 計算年齡
// 2022-1967



// 練習字串合併
$firstname = 'Shinjia';
$lastname = 'Chen';

// $eng_name = $firstname . ' ' . $lastname;
$eng_name = $firstname;
$eng_name .= ' ';
$eng_name .= $lastname;


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
{$eng_name}
    <h1>自我介紹</h1>
    <p>姓名：{$name}</p>
    <p>年齡：{$age}</p>
    <p><img src="{$photo}"></p>
</body>
</html>
HEREDOC;

echo $html;
?>