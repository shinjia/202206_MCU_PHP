<?php
     
// 隨機產生陣列內容
for($i=1; $i<=10; $i++)
{
   $d = mt_rand(0,4);  // 決定位數
   if($d==0)
   {
      $data = str_repeat("0", mt_rand(1,4)) . mt_rand(1,100);  // 產生前面有數個零的資料
   }
   else
   {
      $data = "";
      for($j=1; $j<=$d; $j++)
      {
         $data .= mt_rand(0,9);  // 產生長度為$d的數個隨機數字
      }
   }
   $a_ary[] = "img_" . $data;
}
       
$table0 = '<h3>原陣列</h3>' . array_table($a_ary);

natsort($a_ary);
$table1 = '<h3>natsort</h3>' . array_table($a_ary);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>自然排序法</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>使用自然排序法排序</h2>
<table border="0">
  <tr>
    <td>{$table0}</td>
    <td>排序後<br>=====></td>
    <td>{$table1}</td>
</table>
<form><input type="submit" value="再一組資料"></form>
<hr>
<p>說明：數字部份若以零開頭，仍視為文字，其餘數字則依據『數值的大小』排序。</p>
</body>
</html>
HEREDOC;

echo $html;

function array_table($ary)
{
   $str  = '<table border="1" cellspacing="0">';
   $str .= '<tr><th>索引</th><th>值</th></tr>';
   foreach($ary as $key=>$value)
   {
      $str .= '<tr>';
      $str .= '<td>' . $key . '</td>';
      $str .= '<td>' . $value . '</td>';
      $str .= '</tr>';
   }
   $str .= '</table>';
   return $str;
}
?>