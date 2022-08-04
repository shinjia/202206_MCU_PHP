<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$account = (isset($_POST['account']))  ? $_POST['account']  : '';
$password = (isset($_POST['password']))  ? $_POST['password']  : '';
$forget_q = (isset($_POST['forget_q']))  ? $_POST['forget_q']  : '';
$forget_a = (isset($_POST['forget_a']))  ? $_POST['forget_a']  : '';
$nickname = (isset($_POST['nickname']))  ? $_POST['nickname']  : '';
$realname = (isset($_POST['realname']))  ? $_POST['realname']  : '';
$gentle = (isset($_POST['gentle']))  ? $_POST['gentle']  : '';
$birthday = (isset($_POST['birthday']))  ? $_POST['birthday']  : '';
$blood = (isset($_POST['blood']))  ? $_POST['blood']  : '';
$job = (isset($_POST['job']))  ? $_POST['job']  : '';
$interest = (isset($_POST['interest']))  ? $_POST['interest']  : '';
$zipcode = (isset($_POST['zipcode']))  ? $_POST['zipcode']  : '';
$address = (isset($_POST['address']))  ? $_POST['address']  : '';
$telephone = (isset($_POST['telephone']))  ? $_POST['telephone']  : '';
$email = (isset($_POST['email']))  ? $_POST['email']  : '';
$epaper = (isset($_POST['epaper']))  ? $_POST['epaper']  : '';
$level = (isset($_POST['level']))  ? $_POST['level']  : '';
$lastlogin = (isset($_POST['lastlogin']))  ? $_POST['lastlogin']  : '';


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO customer(account, password, forget_q, forget_a, nickname, realname, gentle, birthday, blood, job, interest, zipcode, address, telephone, email, epaper, level, lastlogin) VALUES (:account, :password, :forget_q, :forget_a, :nickname, :realname, :gentle, :birthday, :blood, :job, :interest, :zipcode, :address, :telephone, :email, :epaper, :level, :lastlogin)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':password', $password, PDO::PARAM_STR);
$sth->bindParam(':forget_q', $forget_q, PDO::PARAM_STR);
$sth->bindParam(':forget_a', $forget_a, PDO::PARAM_STR);
$sth->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$sth->bindParam(':realname', $realname, PDO::PARAM_STR);
$sth->bindParam(':gentle', $gentle, PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':blood', $blood, PDO::PARAM_STR);
$sth->bindParam(':job', $job, PDO::PARAM_STR);
$sth->bindParam(':interest', $interest, PDO::PARAM_STR);
$sth->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
$sth->bindParam(':address', $address, PDO::PARAM_STR);
$sth->bindParam(':telephone', $telephone, PDO::PARAM_STR);
$sth->bindParam(':email', $email, PDO::PARAM_STR);
$sth->bindParam(':epaper', $epaper, PDO::PARAM_STR);
$sth->bindParam(':level', $level, PDO::PARAM_STR);
$sth->bindParam(':lastlogin', $lastlogin, PDO::PARAM_STR);


// 執行SQL及處理結果
if($sth->execute())
{
   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $url_display = 'cust_display.php?uid=' . $new_uid;
   header('Location: ' . $url_display);
}
else
{
   header('Location: ' . error.php);
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit;  // 此列供開發時期偵錯用
}
?>