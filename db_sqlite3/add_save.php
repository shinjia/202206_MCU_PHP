<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$address  = isset($_POST['address'])  ? $_POST['address']  : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$height   = isset($_POST['height'])   ? $_POST['height']   : '';
$weight   = isset($_POST['weight'])   ? $_POST['weight']   : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES ('$usercode', '$username', '$address', '$birthday', '$height', '$weight', '$remark')";
// 注意：最後一個欄位之後的符號

// 執行SQL及處理結果
$sth = $pdo->exec($sqlstr);
if($sth===FALSE)
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
else
{
   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $url_display = $url_self . 'display.php?uid=' . $new_uid;
   header('Location: ' . $url_display);
}
?>