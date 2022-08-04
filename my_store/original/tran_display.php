<?php
include 'config.php';
include 'utility.php';

$uid = $_GET["uid"] + 0;  // 強制轉成數值

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

// 執行 SQL

if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $tran_code = convert_to_html($row['tran_code']);
      $account = convert_to_html($row['account']);
      $tran_date = convert_to_html($row['tran_date']);
      $fee_product = convert_to_html($row['fee_product']);
      $fee_delivery = convert_to_html($row['fee_delivery']);
      $total_price = convert_to_html($row['total_price']);
      $notes = convert_to_html($row['notes']);
      $tran_status = convert_to_html($row['tran_status']);

        // 顯示『notes』欄位的文字區域文字
        $str_notes = nl2br($notes);

        // 顯示『tran_status』欄位的選項值及文字
        $str_tran_status = "(" . $tran_status. ") " . $a_tran_status[$tran_status];
        

   $data = <<< HEREDOC
        <table>
   <tr><th>訂單代碼</th><td>{$tran_code}</td></tr>
   <tr><th>客戶代碼</th><td>{$account}</td></tr>
   <tr><th>訂單日期</th><td>{$tran_date}</td></tr>
   <tr><th>商品總價</th><td>{$fee_product}</td></tr>
   <tr><th>運費</th><td>{$fee_delivery}</td></tr>
   <tr><th>總價</th><td>{$total_price}</td></tr>
   <tr><th>備註事項</th><td>{$str_notes}</td></tr>
   <tr><th>訂單狀態</th><td>{$str_tran_status}</td></tr>

        </table>
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
   $data = error_message('display');
}


$html = <<< HEREDOC
<button onclick="location.href='tran_list_page.php';">返回列表</button>
<h2>顯示資料</h2>
{$data}
HEREDOC;
 
 
include 'pagemake.php';
pagemake($html, '');
?>