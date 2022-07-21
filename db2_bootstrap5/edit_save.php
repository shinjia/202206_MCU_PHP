<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$uid = isset($_POST['uid']) ? $_POST['uid'] : '';

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
$sqlstr = "UPDATE person SET usercode=:usercode, username=:username, address=:address, birthday=:birthday, height=:height, weight=:weight, remark=:remark WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);
$sth->bindParam(':username', $username, PDO::PARAM_STR);
$sth->bindParam(':address' , $address , PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':height'  , $height  , PDO::PARAM_INT);
$sth->bindParam(':weight'  , $weight  , PDO::PARAM_INT);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);

/* 另一種寫法
$sqlstr = "UPDATE person SET usercode=?, username=?, address=?, birthday=?, height=?, weight=?, remark=? WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $usercode, PDO::PARAM_STR);
$sth->bindValue(2, $username, PDO::PARAM_STR);
$sth->bindValue(3, $address , PDO::PARAM_STR);
$sth->bindValue(4, $birthday, PDO::PARAM_STR);
$sth->bindValue(5, $height  , PDO::PARAM_INT);
$sth->bindValue(6, $weight  , PDO::PARAM_INT);
$sth->bindValue(7, $remark  , PDO::PARAM_STR);
$sth->bindValue(8, $uid     , PDO::PARAM_INT);
*/

// 執行SQL及處理結果
if($sth->execute())
{
   $url_display = 'display.php?uid=' . $uid;
   header('Location: ' . $url_display);
}
else
{
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit; // 此列供開發時期偵錯用
   header('Location: error.php');
}
?>