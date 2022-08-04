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

$new_tran_code = uniqid();  // 產生此張訂單代碼
$fee_delivery = 100;   // 運費


$input_notes = isset($_POST['input_notes']) ? $_POST['input_notes'] : '';


// 連接資料庫
$pdo = db_open();

$sql_status = '';

$pdo->beginTransaction();


// 執行SQL：計算總價
$sqlstr  = "SELECT SUM(unit_price*amount) as sum_price FROM cart ";
$sqlstr .= "WHERE account=:session_id ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':session_id', $session_id, PDO::PARAM_STR);

// 執行 
if($sth->execute())
{
   // 成功執行 query 指令
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $sum_price = $row['sum_price'];
   }
}
else
{
    $sql_status .= 'error1|';
}




// 執行SQL：新增一筆訂單
$sqlstr  = "INSERT INTO tran(tran_code, account, tran_date, fee_product, fee_delivery, total_price, notes, tran_status) VALUES (";
$sqlstr .= ":tran_code, :account, :tran_date, :fee_product, :fee_delivery, :total_price, :notes, :tran_status) ";

$tran_date = date("Y-m-d H:i:s", time());
$total_price = $sum_price+$fee_delivery;
$tran_status = 'ORDER';

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':tran_code', $new_tran_code, PDO::PARAM_STR);
$sth->bindParam(':account', $ss_usercode, PDO::PARAM_STR);
$sth->bindParam(':tran_date', $tran_date, PDO::PARAM_STR);
$sth->bindParam(':fee_product', $sum_price, PDO::PARAM_INT);
$sth->bindParam(':fee_delivery', $fee_delivery, PDO::PARAM_INT);
$sth->bindParam(':total_price', $total_price, PDO::PARAM_INT);
$sth->bindParam(':notes', $input_notes, PDO::PARAM_STR);
$sth->bindParam(':tran_status', $tran_status, PDO::PARAM_STR);

$msg = '訂單...';
// 執行SQL及處理結果
if($sth->execute())
{
   // 執行SQL：更新cart內的資料
   $sqlstr  = "UPDATE cart SET ";
   $sqlstr .= "account=:ss_usercode, tran_code=:tran_code ";
   $sqlstr .= "WHERE account=:session_id ";
   
   $sth = $pdo->prepare($sqlstr);
   $sth->bindParam(':ss_usercode', $ss_usercode, PDO::PARAM_STR);
   $sth->bindParam(':tran_code', $new_tran_code, PDO::PARAM_STR);
   $sth->bindParam(':session_id', $session_id, PDO::PARAM_STR);
   
   if($sth->execute())
   {
      $msg = '訂單已送出...<a href="tran_view.php?tran_code=' . $new_tran_code . '">查看此筆訂單內容</a>';
      $msg .= '<br />';
   }
   else
   {
      $sql_status .= 'error22|';
   }
}
else
{
   $sql_status .= 'error21|';
}


if($sql_status=='')      
{
   $pdo->commit();
}
else
{
   $msg = 'Error...' . $sql_status;
   $pdo->rollBack();
}

// 顯示結果
$html = <<< HEREDOC
{$msg}
<br>
<a href="tran_list.php">查看所有訂單</a>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>