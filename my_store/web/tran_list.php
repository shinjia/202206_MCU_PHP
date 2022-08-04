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


// 設定欄位『tran_status』的值域選項
$a_tran_status = array(
      'ORDER'=>'訂購',
      'PROC'=>'處理中',
      'CLOSE'=>'結案' );



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr  = "SELECT * FROM tran ";
$sqlstr .= "WHERE account=:ss_usercode ";
$sqlstr .= "ORDER BY tran_date DESC ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':ss_usercode', $ss_usercode, PDO::PARAM_STR);


// 執行SQL及處理結果
$data = '';
// 執行 
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row["uid"];
      $tran_code = $row["tran_code"];
      $account = $row["account"];
      $tran_date = $row["tran_date"];
      $fee_product = $row["fee_product"];
      $fee_delivery = $row["fee_delivery"];
      $total_price = $row["total_price"];
      $notes = $row["notes"];
      $tran_status = $row["tran_status"];
   
   
      // 顯示『notes』欄位的文字區域文字
      $str_notes = nl2br($notes);
   
      // 顯示『tran_status』欄位的選項值及文字
      $str_tran_status = "(" . $tran_status. ") " . $a_tran_status[$tran_status];
           
   
      $data .= <<< HEREDOC
<tr>
   <td><a href="tran_view.php?tran_code={$tran_code}">{$tran_code}</a></td>
   <td>{$tran_date}</td>
   <td align="right">{$fee_product}</td>
   <td align="right">{$fee_delivery}</td>
   <td align="right">{$total_price}</td>
   <td>{$str_tran_status}</td>
</tr>
HEREDOC;
   }
}



$html = <<< HEREDOC
<H2 align="center">共有 {$total_rec} 筆記錄</h2>
<TABLE border="1" align="center">
   <TR>
      <TH>訂單代碼</TH>
      <TH>訂單日期</TH>
      <TH align="right">商品總價</TH>
      <TH align="right">運費</TH>
      <TH align="right">總金額</TH>
      <TH>備註事項</TH>
   </TR>
{$data}
</TABLE>

HEREDOC;

include "pagemake.php";
pagemake($html);
?>