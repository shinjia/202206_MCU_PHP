<?php
include 'config.php';
include 'utility.php';

// 接受外部表單傳入之變數
$uid = (isset($_POST['uid'])) ? $_POST['uid']+0 : 0;
$tran_code = (isset($_POST['tran_code']))  ? $_POST['tran_code']  : '';
$account = (isset($_POST['account']))  ? $_POST['account']  : '';
$prod_code = (isset($_POST['prod_code']))  ? $_POST['prod_code']  : '';
$unit_price = (isset($_POST['unit_price']))  ? $_POST['unit_price']  : '';
$amount = (isset($_POST['amount']))  ? $_POST['amount']  : '';
$cart_status = (isset($_POST['cart_status']))  ? $_POST['cart_status']  : '';



// 連接資料庫
$pdo = db_open(); 


// 寫出 SQL 語法
$sqlstr = "UPDATE cart SET tran_code=:tran_code, account=:account, prod_code=:prod_code, unit_price=:unit_price, amount=:amount, cart_status=:cart_status WHERE uid=:uid " ;

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':tran_code', $tran_code, PDO::PARAM_STR);
$sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':prod_code', $prod_code, PDO::PARAM_STR);
$sth->bindParam(':unit_price', $unit_price, PDO::PARAM_INT);
$sth->bindParam(':amount', $amount, PDO::PARAM_INT);
$sth->bindParam(':cart_status', $cart_status, PDO::PARAM_STR);

$sth->bindParam(':uid', $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   $url_display = 'cart_display.php?uid=' . $uid;
   header('Location: ' . $url_display);
}
else
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
?>