<?php
include 'config.php';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "SELECT distinct address FROM person ";

// 執行 SQL
$result = mysqli_query($link, $sqlstr);

$total_rec = mysqli_num_rows($result);

$data = '';
while($row=mysqli_fetch_array($result))
{
   $address = $row['address'];

   $data .= <<< HEREDOC
      <tr>
         <td>{$address}</td>
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
      <th>地區清單</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>