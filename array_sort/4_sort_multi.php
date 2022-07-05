<?php

$ary = array("Candy", "Bruce", "Eric", "Alan", "David");
$ary_s1 = array(60, 70, 80, 50, 90);
$ary_s2 = array(55, 75, 85, 95, 65);
  
$table0a = '<h3>名字</h3>' . array_table($ary);
$table0b = '<h3>s1</h3>' . array_table($ary_s1);
$table0c = '<h3>s2</h3>' . array_table($ary_s2);

array_multisort($ary, $ary_s1, $ary_s2);
$table1a = '<h3>名字</h3>' . array_table($ary);
$table1b = '<h3>s1</h3>' . array_table($ary_s1);
$table1c = '<h3>s2</h3>' . array_table($ary_s2);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Multisort</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>使用multisort()函式排序</h2>
<table border="0">
  <tr>
    <td>{$table0a}</td>
    <td>{$table0b}</td>
    <td>{$table0c}</td>
    <td>排序後<br>=====></td>
    <td>{$table1a}</td>
    <td>{$table1b}</td>
    <td>{$table1c}</td>
</table>
<hr>
<p>說明：根據一個陣列排序，但其餘相關的陣列內也隨著重排。</p>
</body>
</html>
HEREDOC;

echo $html;

function array_table($ary)
{
   $str  = '<table border="1" cellspacing="0">';
   $str .= '<tr><th>值</th></tr>';
   foreach($ary as $key=>$value)
   {
      $str .= '<tr>';
      $str .= '<td>' . $value . '</td>';
      $str .= '</tr>';
   }
   $str .= '</table>';
   return $str;
}
?>
