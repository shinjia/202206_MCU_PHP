<?php
$min = 1;
$max = 12;
$total = 6;

$a_box = array();
$check = '';
for($i=0; $i<$total; $i++)
{
    do {
        // 產生球
        $num = mt_rand($min, $max);
        $check .= ($num . ', ');

        // 檢查此數是否出現在陣列內
        $found = false;  // 盒子裡有這個球
        foreach($a_box as $one)
        {
            if($one==$num)
            {
                $found = true;
            }
        }

    } while($found);

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
<p>檢查每次出現的數字：{$check}</p>
<p>{$str}</p>
<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>
