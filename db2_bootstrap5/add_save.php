<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$address  = isset($_POST['address'])  ? $_POST['address']  : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$height   = isset($_POST['height'])   ? $_POST['height']   : 0;
$weight   = isset($_POST['weight'])   ? $_POST['weight']   : 0;
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (:usercode, :username, :address, :birthday, :height, :weight, :remark)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);
$sth->bindParam(':username', $username, PDO::PARAM_STR);
$sth->bindParam(':address' , $address , PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':height'  , $height  , PDO::PARAM_INT);
$sth->bindParam(':weight'  , $weight  , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);

 
/* 另一種寫法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (?, ?, ?, ?, ?, ?, ?)";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $usercode, PDO::PARAM_STR);
$sth->bindValue(2, $username, PDO::PARAM_STR);
$sth->bindValue(3, $address , PDO::PARAM_STR);
$sth->bindValue(4, $birthday, PDO::PARAM_STR);
$sth->bindValue(5, $height  , PDO::PARAM_INT);
$sth->bindValue(6, $weight  , PDO::PARAM_INT);
$sth->bindValue(7, $remark  , PDO::PARAM_STR);
*/

// 執行SQL及處理結果
if($sth->execute())
{
   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $url_display = 'display.php?uid=' . $new_uid;
   header('Location: ' . $url_display);
}
else
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit;  // 此列供開發時期偵錯用
}
?>