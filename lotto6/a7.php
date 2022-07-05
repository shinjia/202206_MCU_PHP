<?php
$min = 1;
$max = 42;
$total = 6;

// 全部的球放進盒子裡
$a_full = range($min, $max);

// 打散
shuffle($a_full);

// 挑出前面六個
$a_box = array_slice($a_full, 0, $total);


// 畫面輸出
$str = '';
foreach($a_box as $one)
{
    $str .= '<img src="images/' . $one . '.jpg"> ';
}

//echo '<pre>';
//print_r($a_box);
//echo '</pre>';
//exit;

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
<h1>你的幸運數字</h1>
<p>{$str}</p>
<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>
