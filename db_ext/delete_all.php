<?php
include 'config.php';

// 連接資料庫
$link = db_open();


// 寫出 SQL 語法 
$sqlstr = "DELETE FROM person ";

// 執行SQL
$result = mysqli_query($link, $sqlstr);
if($result)
{
   $msg = '所有記錄已全部刪除。';
}
else
{
   echo mysqli_error($link) . '<br>' . $sqlstr; exit;  // 此列供開發時期偵錯用，應刪除
   $msg = '資料無法刪除...<br>';
}


$html = <<< HEREDOC
<h1>全部刪除</h2>
{$msg}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>