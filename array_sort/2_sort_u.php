<?php

function cmp($a, $b)
{
   $a_length = strlen($a);
   $b_length = strlen($b);
   
   if($a_length < $b_length)
   {
      $ret = -1;
   }
   elseif($a_length > $b_length)
   {
      $ret = 1;
   }
   else
   {
      $ret = 0;
   }
   return $ret;
}


$a_ary = array(
       "Leonardo",
       "Michelangelo",
       "Raphael",
       "Rembrandt",
       "David",
       "Millet",
       "Monet",
       "Cezanne",
       "Vincent",
       "Matisse",
       "Picaso",
       "Dali"
       );
       
$table0 = '<h3>原陣列</h3>' . array_table($a_ary);

usort($a_ary, "cmp");
$table1 = '<h3>usort</h3>' . array_table($a_ary);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>自訂陣列的排序規則</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>依照英文名字的字母長度排序</h2>
<table border="0">
  <tr>
    <td>{$table0}</td>
    <td>排序後<br>=====></td>
    <td>{$table1}</td>
</table>
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