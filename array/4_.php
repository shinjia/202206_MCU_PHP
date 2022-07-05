<?php

$a_score = array(80, 90, 70, 60, 50);   // 定義分數

$size = count($a_score);

$sum = 0;
foreach($a_score as $one)
{
   $sum += $one;
}
$avg = $sum / $size;


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Test</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
人數：{$size}<br />
總分：{$sum}<br />
平均：{$avg}

</body>
</html>
HEREDOC;

echo $html;
?>