<?php
include 'config.php';
include 'utility.php';

$uid = $_GET["uid"] + 0;

// 設定欄位『tran_status』的值域選項
$a_tran_status = array(
      "ORDER"=>"訂購",
      "PROC"=>"處理中",
      "CLOSE"=>"結案" );



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM tran WHERE uid=:uid ";

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
      $tran_date = convert_to_html($row['tran_date']);
      $fee_product = convert_to_html($row['fee_product']);
      $fee_delivery = convert_to_html($row['fee_delivery']);
      $total_price = convert_to_html($row['total_price']);
      $notes = convert_to_html($row['notes']);
      $tran_status = convert_to_html($row['tran_status']);


        // 處理『tran_status』欄位的 RADIO 選項
        $radio_tran_status = '';
        foreach($a_tran_status as $key=>$value)
        {
        	$str_checked = ($tran_status==$key) ? ("checked") : ("");
           $radio_tran_status .= '<input type="radio" name="tran_status" value="' . $key . '" ' . $str_checked . '>' . $value;
        }


      
      $data = <<< HEREDOC
      <form action="tran_edit_save.php" method="post">
      <table>
        <tr><th>訂單代碼</th><td><input type="text" name="tran_code" value="{$tran_code}" /></td></tr>
        <tr><th>客戶代碼</th><td><input type="text" name="account" value="{$account}" /></td></tr>
        <tr><th>訂單日期</th><td><input type="text" name="tran_date" value="{$tran_date}" />**輸入日期格式Y-m-d**</td></tr>
        <tr><th>商品總價</th><td><input type="text" name="fee_product" value="{$fee_product}" /></td></tr>
        <tr><th>運費</th><td><input type="text" name="fee_delivery" value="{$fee_delivery}" /></td></tr>
        <tr><th>總價</th><td><input type="text" name="total_price" value="{$total_price}" /></td></tr>
        <tr><th>備註事項</th><td><textarea name="notes">{$notes}</textarea></td></tr>
        <tr><th>訂單狀態</th><td>{$radio_tran_status}</td></tr>

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