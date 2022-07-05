<?php

$a_student = array( 
   array("reg"=>"B82", "name"=>"Alan" , "s1"=>50, "s2"=>23, "s3"=>83 ),
   array("reg"=>"B42", "name"=>"Bruce", "s1"=>32, "s2"=>67, "s3"=>92 ),
   array("reg"=>"C23", "name"=>"Candy", "s1"=>64, "s2"=>25, "s3"=>63 ),
   array("reg"=>"C52", "name"=>"David", "s1"=>67, "s2"=>73, "s3"=>67 ),
   array("reg"=>"A52", "name"=>"Eric" , "s1"=>84, "s2"=>48, "s3"=>58 ),
   array("reg"=>"A12", "name"=>"Ford" , "s1"=>35, "s2"=>23, "s3"=>56 ) );                    

$count = count($a_student);

$sum_s1 = 0;  // 第一科的全班總分
$sum_s2 = 0;  // 第二科的全班總分
$sum_s3 = 0;  // 第三科的全班總分

$str = '';
foreach($a_student as $row)
{
   // 計算個人的成績
   $sum = $row["s1"] + $row["s2"] + $row["s3"];
   $avg = round($sum / 3);
   $remark = ($avg>=60) ? ("及格") : ("<font color=#FF0000>不及格</font>");
   
   $str .= '<tr>';
   $str .= '<td bgcolor="#FFEEDD">' . $row["reg"] . '</td>';
   $str .= '<td bgcolor="#FFEEDD">' . $row["name"] . '</td>';
   $str .= '<td bgcolor="#FFEEDD">' . $row["s1"] . '</td>';
   $str .= '<td bgcolor="#FFEEDD">' . $row["s2"] . '</td>';
   $str .= '<td bgcolor="#FFEEDD">' . $row["s3"] . '</td>';
   $str .= '<td bgcolor="#FFCCDD">' . $sum . '</td>';
   $str .= '<td bgcolor="#FFCCDD">' . $avg . '</td>';
   $str .= '<td bgcolor="#FFCCDD">' . $remark . '</td>';
   $str .= '</tr>';
   
   // 計算全班的總分
   $sum_s1 += $row["s1"];
   $sum_s2 += $row["s2"];
   $sum_s3 += $row["s3"];
}

$avg_s1 = round($sum_s1 / $count, 1);
$avg_s2 = round($sum_s2 / $count, 1);
$avg_s3 = round($sum_s3 / $count, 2);

// 顯示最後一排 (全班的統計)
$str .= '<tr>';
$str .= '<th colspan="2">◇全班平均◇</th>';
$str .= '<td bgcolor="#FFCCDD">' . $avg_s1 . '</td>';
$str .= '<td bgcolor="#FFCCDD">' . $avg_s2 . '</td>';
$str .= '<td bgcolor="#FFCCDD">' . $avg_s3 . '</td>';
$str .= '<td colspan="3">&nbsp;</td>';
$str .= '</tr>';


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>成績統計計算</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>成績一覽表</h1>
<table border="1" cellspacing="0" cellpadding="3" bgcolor="#CCEEFF">
   <tr bgcolor="#CCEEFF">
      <th>學號</th>
      <th>姓名</th>
      <th>國語</th>
      <th>英文</th>
      <th>數學</th>
      <th>總分</th>
      <th>平均</th>
      <th>備註</th>
   </tr>
   {$str}
</table>
</body>
</html>
HEREDOC;

echo $html;
?>