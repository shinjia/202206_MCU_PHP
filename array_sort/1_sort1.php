<?php
$act = isset($_POST["act"]) ? $_POST["act"] : "START";

$a_original = array(
       "102"=>"Ford",
       "203"=>"Alan",
       "201"=>"Candy",
       "101"=>"David",
       "301"=>"Bruce",
       "103"=>"Eric",
       "302"=>"Green",
       "202"=>"Helen"
       );

$table0 = '<h3>原陣列</h3>' . array_table($a_original);

switch($act)
{
   case "sort" :
        $a1 = $a_original;
        sort($a1);
        $table1 = '<h3>sort</h3>' . array_table($a1);
        $a2 = $a_original;
        rsort($a2);
        $table2 = '<h3>rsort</h3>' . array_table($a2);
        break;
        
   case "asort" :
        $a1 = $a_original;
        asort($a1);
        $table1 = '<h3>asort</h3>' . array_table($a1);
        $a2 = $a_original;
        arsort($a2);
        $table2 = '<h3>arsort</h3>' . array_table($a2);
        break;
        
   case "ksort" :
        $a1 = $a_original;
        ksort($a1);
        $table1 =  '<h3>ksort</h3>' . array_table($a1);
        $a2 = $a_original;
        krsort($a2);
        $table2 =  '<h3>krsort</h3>' . array_table($a2);
        break;
        
   case "START" :
   default:
       $table1 = "";
       $table2 = "";
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>數種陣列排序函式的比較</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>數種陣列排序函式的比較</h2>
<table border="0">
  <tr>
    <td>{$table0}</td>
    <td align="center">
      <form method="post" action="">
         請選擇排序指令<br>
         =====><br>
        <input type="submit" name="act" value="sort"><br>
        <input type="submit" name="act" value="asort"><br>
        <input type="submit" name="act" value="ksort">
      </form>
    </td>
    <td>{$table1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>{$table2}</td>
  </tr>
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