<?php
// 參數定義 (變數)
$min = 1;
$max = 9;

$a = mt_rand($min, $max);
$b = mt_rand($min, $max);

// 參數定義 (常數)
define('MIN', 1);
define('MAX', 9);

$a = mt_rand(MIN,MAX);
$b = mt_rand(MIN,MAX);

// $a = mt_rand(2,9);
// $b = mt_rand(2,9);

$pic_a = 'images/' . $a . '.jpg';
$pic_b = 'images/' . $b . '.jpg';

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>九九乘法CAI練習</title>
</head>
<body>
<h1>九九乘法CAI練習</h1>
<p><img src="{$pic_a}"><img src="images/mul.jpg"><img src="{$pic_b}"></p>

<p>
| <a href="question.php">換一題</a>
| <a href="answer.php?a={$a}&b={$b}">看答案</a>
|</p>
</body>
</html>
HEREDOC;

echo $html;
?>
