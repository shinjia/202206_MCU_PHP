<?php
include 'config.php';
include 'utility.php';

$uid = $_GET["uid"] + 0;

// 設定欄位『cart_status』的值域選項
$a_cart_status = array(
      "CART"=>"置於購物車",
      "ORDER"=>"已訂購" );



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM cart WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':uid', $uid, PDO::PARAM_INT);


// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $tran_code = convert_to_html($row['tran_code']);
      $account = convert_to_html($row['account']);
      $prod_code = convert_to_html($row['prod_code']);
      $unit_price = convert_to_html($row['unit_price']);
      $amount = convert_to_html($row['amount']);
      $cart_status = convert_to_html($row['cart_status']);


        // 處理『cart_status』欄位的 RADIO 選項
        $radio_cart_status = '';
        foreach($a_cart_status as $key=>$value)
        {
        	$str_checked = ($cart_status==$key) ? ("checked") : ("");
           $radio_cart_status .= '<input type="radio" name="cart_status" value="' . $key . '" ' . $str_checked . '>' . $value;
        }


      
      $data = <<< HEREDOC
      <form action="cart_edit_save.php" method="post">
      <table>
        <tr><th>訂單代碼</th><td><input type="text" name="tran_code" value="{$tran_code}" /></td></tr>
        <tr><th>客戶代碼</th><td><input type="text" name="account" value="{$account}" /></td></tr>
        <tr><th>產品代碼</th><td><input type="text" name="prod_code" value="{$prod_code}" /></td></tr>
        <tr><th>單價</th><td><input type="text" name="unit_price" value="{$unit_price}" /></td></tr>
        <tr><th>數量</th><td><input type="text" name="amount" value="{$amount}" /></td></tr>
        <tr><th>項目狀態</th><td>{$radio_cart_status}</td></tr>

      </table>
      <p>
        <input type="hidden" name="uid" value="{$uid}">
        <input type="submit" value="送出">
      </p>
      </form>
HEREDOC;
   }
   else
   {
 	   $data = '查不到相關記錄！';
   }
}
else
{
   // 無法執行 query 指令時
   $data = error_message('edit');
}



$html = <<< HEREDOC
<h2>修改資料</h2>
<button onclick="history.back();">返回</button>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>