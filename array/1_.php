<?php

// 第四種指定方式：增加陣列索引
$link = array(
   'Google'   =>'http://www.google.com/', 
   'Microsoft'=>'http://www.microsoft.com/' ,
   'Facebook' =>'http://www.facebook.com/' ,
   'A'        =>'http://www.facebook.com/' ,
   'bb'       =>'http://www.facebook.com/' ,
   'ccc'      =>'http://www.facebook.com/' ,
   'dd'       =>'http://www.facebook.com/' ,
   'Apple'    =>'http://www.apple.com/' );

$str = '<table border="1">';
foreach($link as $key=>$value)
{
   $str .= '<tr>';
   $str .= '<td>';
   $str .= '<a href="' . $value . '">' . $key . '</a>';   
   $str .= '</td>';
   $str .= '<td>';
   $str .=  $value;
   $str .= '</td>';
   $str .= '</tr>' . "\n";
}
$str .= '</table>';
echo $str;
exit;


// 第一種指定方式：逐一指定
$link1[] = 'http://www.google.com/';
$link1[] = 'http://www.microsoft.com/';
$link1[] = 'http://www.apple.com/';
$link1[] = 'http://g9app.com/baby/';


// 第二種指定方式：整個陣列一次指定
$link2 = array( 
   'http://www.google.com/', 
   'http://www.microsoft.com/' ,
   'http://www.apple.com/' );


// 第三種指定方式：增加陣列索引
$link3['Google']    = 'http://www.google.com/';
$link3['Microsoft'] = 'http://www.microsoft.com/';
$link3['Apple']     = 'http://www.apple.com/';
$link4['Facebook'] = 'http://www.facebook.com/';

// 第四種指定方式：增加陣列索引
$link4 = array(
   'Google'   =>'http://www.google.com/', 
   'Microsoft'=>'http://www.microsoft.com/' ,
   'Apple'    =>'http://www.apple.com/' );


/* 臨時檢查某個陣列內容的方法 */
/*
echo '<pre>';
print_r($link1);
echo '</pre>';
exit;
*/

// 以下程式為讀取陣列各元素，將各個項目串成一段網頁HTML碼

// 第一種讀取方式：逐一寫出 (非常不理想)
$str1 = '';
$str1 .= '<a href="' . $link1[0]  . '">' . $link1[0] . '</a><br />';
$str1 .= '<a href="' . $link1[1]  . '">' . $link1[1] . '</a><br />';
$str1 .= '<a href="' . $link1[2]  . '">' . $link1[2] . '</a><br />';


// 第二種讀取方式：使用for迴圈
$str2 = '';
$size = count($link1);
for($i=0; $i<$size; $i++)
{
   $str2 .= '<a href="' . $link1[$i] . '">' . $link1[$i] . '</a><br />';
}


// 第三種讀取方式：利用 foreach 迴圈語法
$str3 = '';
foreach($link3 as $one)
{
   $str3 .= '<a href="' . $one . '">' . $one . '</a><br>';
}


// 第四種讀取方式：利用 foreach 迴圈讀取陣列，包含陣列的索引及值
$str4 = '';
foreach($link4 as $key=>$value)
{
   $str4 .= '<a href="' . $value . '">' . $key . '</a><br />';
}


// 第五種讀取方式：利用 while 迴圈，搭配函式使用
$ary = $link4;
$str5 = '';
while(list($key, $value)=each($ary))
{
   $str5 .= '<a href="' . $value . '">' . $key . '</a><br>' . "\n";
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Weblink</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<h2>推薦網站超連結</h2>
<p>第一種讀取方式的結果</p>
<p>{$str1}</p>
<hr />

<p>第二種讀取方式的結果</p>
<p>{$str2}</p>
<hr />

<p>第三種讀取方式的結果</p>
<p>{$str3}</p>
<hr />

<p>第四種讀取方式的結果</p>
<p>{$str4}</p>
<hr />

<p>第五種讀取方式的結果</p>
<p>{$str5}</p>
<hr />
</body>
</html>
HEREDOC;

echo $html;
?>
