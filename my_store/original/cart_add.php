<?php

// 設定欄位『cart_status』的值域選項
$a_cart_status = array(
      "CART"=>"置於購物車",
      "ORDER"=>"已訂購" );



        // 處理『cart_status』欄位的 RADIO 選項
        $radio_cart_status = '';
        foreach($a_cart_status as $key=>$value)
        {
           $radio_cart_status .= '<input type="radio" name="cart_status" value="' . $key . '">' . $value;
        }



$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="cart_add_save.php" method="post">
<table>
    <tr><th>訂單代碼</th><td><input type="text" name="tran_code" value="" /></td></tr>
    <tr><th>客戶代碼</th><td><input type="text" name="account" value="" /></td></tr>
    <tr><th>產品代碼</th><td><input type="text" name="prod_code" value="" /></td></tr>
    <tr><th>單價</th><td><input type="text" name="unit_price" value="" /></td></tr>
    <tr><th>數量</th><td><input type="text" name="amount" value="" /></td></tr>
    <tr><th>項目狀態</th><td>{$radio_cart_status}</td></tr>

</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>