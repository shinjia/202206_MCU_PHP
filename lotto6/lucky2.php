<?php
$min = 1;
$max = 12;

$num1 = mt_rand($min, $max);
$num2 = mt_rand($min, $max);
$num3 = mt_rand($min, $max);
$num4 = mt_rand($min, $max);
$num5 = mt_rand($min, $max);
$num6 = mt_rand($min, $max);

$pic1 = 'images/' . $num1 . '.jpg';
$pic2 = 'images/' . $num2 . '.jpg';
$pic3 = 'images/' . $num3 . '.jpg';
$pic4 = 'images/' . $num4 . '.jpg';
$pic5 = 'images/' . $num5 . '.jpg';
$pic6 = 'images/' . $num6 . '.jpg';

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
<h1>你的幸運數字</h1>
<p><img src="{$pic1}"><img src="{$pic2}"><img src="{$pic3}"><img src="{$pic4}"><img src="{$pic5}"><img src="{$pic6}"></p>
<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>