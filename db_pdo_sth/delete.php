<?php
include 'config.php';
include 'utility.php';

$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "DELETE FROM person WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
   header('Location: ' . $refer);
}
else
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
?>