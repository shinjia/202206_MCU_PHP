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


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
// 只列出cart資料表內的資料
// $sqlstr = "SELECT * FROM cart WHERE account='" . $session_id . "' ";
$sqlstr  = "SELECT cart.*, product.prod_name FROM cart ";
$sqlstr .= "LEFT JOIN product ON cart.prod_code=product.prod_code ";
$sqlstr .= "WHERE account=:session_id ";
$sqlstr .= "ORDER BY prod_code ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':session_id', $session_id, PDO::PARAM_STR);

$sum_price = 0;

// 執行 
$data = '';
if($sth->execute())
{
   $total_rec = $sth->rowCount();
   // 成功執行 query 指令
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid        = $row["uid"];
      $tran_code  = $row["tran_code"];
      $account    = $row["account"];
      $prod_code  = $row["prod_code"];
      $unit_price = $row["unit_price"];
      $amount     = $row["amount"];
   
      $prod_name  = $row["prod_name"];
    
      // 計算總價
      $sum_price += ($unit_price * $amount);  
   
      $data .= <<< HEREDOC
     <tr>
       <td>{$prod_code}</td>
       <td>{$prod_name}</td>
       <td align="right">{$unit_price}</td>
       <td>
         <form method="post" action="cart_modify.php" style="margin:0px;">
           <input type="text" name="amount" size="2" value="{$amount}">
           <input type="hidden" name="uid" value="{$uid}">
           <input type="submit" value="變更數量">
         </form>
       </td>
       <td>
         <form method="post" action="cart_remove.php" style="margin:0px;" onsubmit="return confirm('確定要移除此項商品嗎？');">
           <input type="hidden" name="uid" value="{$uid}">
           <input type="submit" value="移除商品">
         </form>
       </td>
    </tr>
HEREDOC;
   }
}
else
{
      // 無法執行 query 指令時
      $html = error_message('list_all');
}


$html = <<< HEREDOC
<h2 align="center">購物車內共有 {$total_rec} 筆記錄</h2>
<table border="1" align="center">
   <tr>
      <th align="center">商品代碼</th>
      <th align="center">商品名稱</th>
      <th align="center">單價</th>
      <th align="center">數量</th>

      <th colspan="2" align="center">&nbsp;</th>
   </tr>
{$data}
</table>
<p align="center">目前購物車內商品總價：{$sum_price}</p>

<p align="center">
<a href="prod_list.php">繼續購物</a>  <a href="tran_input.php">進行結帳</a>
</p>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>