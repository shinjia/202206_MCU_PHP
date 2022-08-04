<?php
include 'config.php';
include 'utility.php';

$uid = $_GET['uid'];

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "DELETE FROM person WHERE uid=" . $uid;

// 執行SQL及處理結果
$sth = $pdo->exec($sqlstr);
if($sth===FALSE)
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
else
{
   $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
   header('Location: ' . $refer);
}
?>