<?php
include 'config.php';

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "DELETE FROM person WHERE uid=" . $uid;

// 執行 SQL
$result = @mysqli_query($link, $sqlstr);
if($result)
{
   $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
   header('Location: ' . $refer);
}
else
{
   header('Location: error.php');
   echo mysqli_error($link) . '<BR>' . $sqlstr;  // 此列供開發時期偵錯用，應刪除
}

db_close($link);

?>