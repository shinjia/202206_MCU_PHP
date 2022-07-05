<?php
$min = 1;
$max = 49;
$total = 6;

$a_box = array();
$check = '';
for($i=0; $i<$total; $i++)
{
    do {
        // 產生球
        $num = mt_rand($min, $max);
        $check .= ($num . ', ');
    } while(in_array($num, $a_box));

    // 放入盒子
    $a_box[] = $num;
}

// 畫面輸出
$str = '';
foreach($a_box as $one)
{
    $str .= '<img src="images/' . $one . '.jpg"> ';
}

sort($a_box);  // 由小排到大

$str_sort = '';
foreach($a_box as $one)
{
    $str_sort .= '<img src="images/' . $one . '.jpg"> ';
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
<p>檢查每次出現的數字：{$check}</p>
<p>原來的順序</p>
<p>{$str}</p>
<p>排序後的結果</p>
<p>{$str_sort}</p>

<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>
