<?php
$min = 1;
$max = 42;
$total = 6;

for($i=0; $i<$total; $i++)
{
    // 產生球
    $num = mt_rand($min, $max);

    // 放入盒子
    $a_box[] = $num;
}

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
