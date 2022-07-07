<?php
include 'config.php';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "SELECT address, count(*) as cc, avg(height) as hh, avg(weight) as ww FROM person group by address ";

// 執行 SQL
$result = mysqli_query($link, $sqlstr);

$total_rec = mysqli_num_rows($result);

$data = '';
while($row=mysqli_fetch_array($result))
{
   $address = $row['address'];
   $cc    = $row['cc'];
   $hh    = number_format($row['hh'],2);
   $ww    = number_format($row['ww'],2);

   $data .= <<< HEREDOC
      <tr>
         <td>{$address}</td>
         <td align="right">{$cc}</td>
         <td align="right">{$hh}</td>
         <td align="right">{$ww}</td>
      </tr>
HEREDOC;
}

db_close($link);


//網頁顯示

$head = <<< HEREDOC
<script language="javascript">
function show_sql()
{
   alert("{$sqlstr}");
}
</script>
HEREDOC;


$html = <<< HEREDOC
<p align="center"><a href="javascript:show_sql();">查看SQL語法</a></p>
<h2 align="center">共有 {$total_rec} 筆記錄</h2>

<table border="1" align="center">
   <tr>
      <th>地區</th>
      <th>數量</th>
      <th>身高平均</th>
      <th>體重平均</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>