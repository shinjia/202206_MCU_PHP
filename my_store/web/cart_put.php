<?php
session_start();

include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';

if(($ss_usertype!=DEF_LOGIN_MEMBER))
{
   header('Location: login_error.php');
   exit;
}

//------ End of Login Check ------------------------

$session_id = session_id();

$prod_code  = isset($_POST['prod_code']) ? $_POST['prod_code'] : '';
$unit_price = isset($_POST['unit_price']) ? $_POST['unit_price'] : 0;
$amount     = isset($_POST['amount']) ? $_POST['amount'] : 1;
$cart_status = 'CART';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO cart(tran_code, account, prod_code, unit_price, amount, cart_status) VALUES (:tran_code, :account, :prod_code, :unit_price, :amount, :cart_status)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':tran_code', $session_id, PDO::PARAM_STR);
$sth->bindParam(':account', $session_id, PDO::PARAM_STR);
$sth->bindParam(':prod_code', $prod_code, PDO::PARAM_STR);
$sth->bindParam(':unit_price', $unit_price, PDO::PARAM_STR);
$sth->bindParam(':amount', $amount, PDO::PARAM_STR);
$sth->bindParam(':cart_status', $cart_status, PDO::PARAM_STR);

// 執行SQL及處理結果
if($sth->execute())
{
   header('Location: cart_list.php');
}
else
{
   header('Location: ?op=ERROR&type=cart_put');
}
?>