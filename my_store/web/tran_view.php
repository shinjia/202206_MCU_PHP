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

$tran_code = isset($_GET['tran_code']) ? $_GET['tran_code'] : '';


// 設定欄位『tran_status』的值域選項
$a_tran_status = array(
      'ORDER'=>'下訂單',
      'PROC'=>'處理中',
      'CLOSE'=>'結案' );



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr  = "SELECT * FROM cart ";
$sqlstr .= "   JOIN tran ON cart.tran_code=tran.tran_code ";
$sqlstr .= "   JOIN product ON cart.prod_code=product.prod_code ";
$sqlstr .= "WHERE tran.account=:ss_usercode ";
$sqlstr .= "  AND tran.tran_code=:tran_code ";
$sqlstr .= "  AND cart.account=:ss_usercode ";
$sqlstr .= "ORDER BY cart.prod_code ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':ss_usercode', $ss_usercode, PDO::PARAM_STR);
$sth->bindParam(':tran_code', $tran_code, PDO::PARAM_STR);


// 執行SQL及處理結果
if($sth->execute())
{
   $data = '';
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $tran_code = $row['tran_code'];
      $account = $row['account'];
      $tran_date = $row['tran_date'];
      $fee_product = $row['fee_product'];
      $fee_delivery = $row['fee_delivery'];
      $total_price = $row['total_price'];
      $notes = $row['notes'];
      $tran_status = $row['tran_status'];
      
      $prod_code  = $row['prod_code'];
      $unit_price = $row['unit_price'];
      $amount     = $row['amount'];
      
      $prod_name  = $row['prod_name'];
   
   
      // 顯示『notes』欄位的文字區域文字
      $str_notes = nl2br($notes);
   
      // 顯示『tran_status』欄位的選項值及文字
      $str_tran_status = '(' . $tran_status. ') ' . $a_tran_status[$tran_status];
           
   
      $data .= <<< HEREDOC
<tr>
  <td>{$prod_code}</td>
  <td>{$prod_name}</td>
  <td align="right">{$unit_price}</td>
  <td align="right">{$amount}&nbsp;</td>
</tr>
HEREDOC;
   }
}


$html = <<< HEREDOC
<h2 align="center">訂單內容明細</h2>
<table border="1" align="center">
   <tr><th>訂單代碼</th><td>{$tran_code}</td></tr>
   <tr><th>訂單日期</th><td>{$tran_date}</td></tr>
   <tr><th align="right">商品總價</th><td>{$fee_product}</td></tr>
   <tr><th align="right">運費</th><td>{$fee_delivery}</td></tr>
   <tr><th align="right">合計總金額</th><td>{$total_price}</td></tr>
   <tr><th>訂單狀態</th><td>{$str_tran_status}</td></tr>
   <tr><th>備註</th><td>{$str_notes}</td></tr>
</table>
<br />
<table border="1" align="center">
   <tr>
      <th>商品代碼</th>
      <th>商品名稱</th>
      <th align="right">單價</th>
      <th align="right">數量</th>
   </tr>
{$data}
</table>

HEREDOC;



include 'pagemake.php';
pagemake($html, '');
?>
