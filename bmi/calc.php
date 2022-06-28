<?php
$height = isset($_POST['height']) ? $_POST['height'] : '100';
$weight = isset($_POST['weight']) ? $_POST['weight'] : '20';

@$height = $height + 0;  // 硬轉成數值
// echo $height; exit;
if($height==0)
{
    echo 'error. 身高不能為零<a href="input.php?h=' . $height . '&w=' . $weight . '">請重新輸入</a>';
    exit;
}


// $h = $height / 100;
// $bmi = $weight / ($h*$h);

// 計算 BMI
$bmi = $weight / (($height/100)*($height/100));
// $bmi = $weight / pow($height/100, 2);

// 取兩位小數
$bmi = number_format($bmi, 2);
// $bmi = round($bmi, 2);
// $bmi = floor($bmi * 100) / 100;


// 關係運算子
// >  >=   ==   <  <=   !=  <>
// 邏輯運算子
// AND(&&)  OR(||)  NOT(!)

// 判斷
if($bmi>=24)
{
    $msg = '月巴月半';
    $pic = 'images/s1.jpg';
    $url = 'page1.html';
}
elseif($bmi<24 && $bmi>=22)
{
    $msg = '過重';
    $pic = 'images/s2.jpg';
    $url = 'page2.html';
}
elseif($bmi<22 && $bmi>=17.5)
{
    $msg = '正常';
    $pic = 'images/s3.jpg';
    $url = 'page3.html';
}
elseif($bmi<17.5)
{
    $msg = '太輕';
    $pic = 'images/s4.jpg';
    $url = 'page4.html';
}
else
{
    $msg = '程式一定出錯了！';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>BMI</h1>
<p>BMI 值是 {$bmi} </p>
<p>{$msg}</p>
<p><img src="{$pic}"></p>
<p><a href="{$url}">建議</a></p>
<iframe src="{$url}" style="width:400px; height:200px;">
</iframe>
<hr>
<p>height= {$height}</p>
<p>weight= {$weight}</p>
</body>
</html>
HEREDOC;

echo $html;
?>