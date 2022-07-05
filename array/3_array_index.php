<?php
/*
$a_fruit[] = '蘋果';
$a_fruit[] = '香蕉';
$a_fruit[5] = '西瓜';

$a_fruit[] = '鳳梨';

$a_fruit['lemon'] = '檸檬';
$a_fruit[] = '橘子';
$a_fruit[4] = '水蜜桃';
$a_fruit[] = '楊桃';
$a_fruit[1] = '芒果';
*/

$str = '';
$a_fruit[] = '蘋果';
$str .= array_table($a_fruit, 'Phase 1');
$a_fruit[] = '香蕉';
$str .= array_table($a_fruit, 'Phase 2');
$a_fruit[5] = '西瓜';
$str .= array_table($a_fruit, 'Phase 3');

$a_fruit[] = '鳳梨';
$str .= array_table($a_fruit, 'Phase 4');

$a_fruit['lemon'] = '檸檬';
$str .= array_table($a_fruit, 'Phase 5');
$a_fruit[] = '橘子';
$str .= array_table($a_fruit, 'Phase 6');
$a_fruit[4] = '水蜜桃';
$str .= array_table($a_fruit, 'Phase 7');
$a_fruit[] = '楊桃';
$str .= array_table($a_fruit, 'Phase 8');
$a_fruit[1] = '芒果';
$str .= array_table($a_fruit, 'Phase 9');



$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>陣列的索引</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>陣列的索引</h2>
{$str}
</body>
</html>
HEREDOC;

echo $html;


function array_table($ary, $title='')
{
   $str  = '<h2>' . $title . '</h2>';
   $str .= '<table border="1" cellspacing="0">';
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