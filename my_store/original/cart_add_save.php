<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$tran_code = (isset($_POST['tran_code']))  ? $_POST['tran_code']  : '';
$account = (isset($_POST['account']))  ? $_POST['account']  : '';
$prod_code = (isset($_POST['prod_code']))  ? $_POST['prod_code']  : '';
$unit_price = (isset($_POST['unit_price']))  ? $_POST['unit_price']  : '';
$amount = (isset($_POST['amount']))  ? $_POST['amount']  : '';
$cart_status = (isset($_POST['cart_status']))  ? $_POST['cart_status']  : '';


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO cart(tran_code, account, prod_code, unit_price, amount, cart_status) VALUES (:tran_code, :account, :prod_code, :unit_price, :amount, :cart_status)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':tran_code', $tran_code, PDO::PARAM_STR);
$sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':prod_code', $prod_code, PDO::PARAM_STR);
$sth->bindParam(':unit_price', $unit_price, PDO::PARAM_INT);
$sth->bindParam(':amount', $amount, PDO::PARAM_INT);
$sth->bindParam(':cart_status', $cart_status, PDO::PARAM_STR);


// 執行SQL及處理結果
if($sth->execute())
{
   $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $url_display = 'cart_display.php?uid=' . $new_uid;
   header('Location: ' . $url_display);
}
else
{
   header('Location: ' . error.php);
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit;  // 此列供開發時期偵錯用
}
?>