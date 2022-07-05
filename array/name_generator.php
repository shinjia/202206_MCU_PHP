<?php

$a_name1 = array('趙', '錢', '孫', '李', '周', '吳', '鄭', '王', '陳', '林');
$key = array_rand($a_name1, 1);
$cname1 = $a_name1[$key];


$a_name2 = array('欣', '育', '香', '怡', '文', '彥', '瑤');
$key = array_rand($a_name2, 1);
$cname2 = $a_name2[$key];


$a_name3 = array('欣', '育', '香', '怡', '文', '彥', '瑤');
$key = array_rand($a_name3, 1);
$cname3 = $a_name3[$key];


$choice_name = $cname1 . $cname2 . $cname3;


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
    {$choice_name}
    <hr>
    <a href="?">下一個</a>
</body>
</html>
HEREDOC;

echo $html;
?>