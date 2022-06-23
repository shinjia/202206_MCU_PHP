<?php

$a = isset($_GET['a']) ? $_GET['a'] : 1;   
$b = isset($_GET['b']) ? $_GET['b'] : 1;

$ans = $a * $b;

$n1 = $ans % 10;  // 個位數  
$n2 = floor($ans / 10);  // 十位數

$n1_pic = '<img src="images/' . $n1 . '.jpg">';
$n2_pic = '<img src="images/' . $n2 . '.jpg">';

// if($ans<10)
if($n2==0)
{
    $n2_pic = '';
}

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>九九乘法CAI練習</title>
</head>
<body>
<h1>九九乘法CAI練習</h1>
{$a} 乘以 {$b} 等於 {$ans}
<p>{$n2_pic}{$n1_pic}</p>

<p><a href="question.php">下一題</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>