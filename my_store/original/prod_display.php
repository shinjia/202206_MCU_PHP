<?php
include 'config.php';
include 'utility.php';

$uid = $_GET["uid"] + 0;  // 強制轉成數值



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM product WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':uid', $uid, PDO::PARAM_INT);

// 執行 SQL

if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $prod_code = convert_to_html($row['prod_code']);
      $prod_name = convert_to_html($row['prod_name']);
      $category = convert_to_html($row['category']);
      $description = convert_to_html($row['description']);
      $price_mark = convert_to_html($row['price_mark']);
      $price = convert_to_html($row['price']);
      $picture = convert_to_html($row['picture']);
      $pictset = convert_to_html($row['pictset']);

        // 顯示『description』欄位的文字區域文字
        $str_description = nl2br($description);


   $data = <<< HEREDOC
        <table>
   <tr><th>商品代碼</th><td>{$prod_code}</td></tr>
   <tr><th>商品名稱</th><td>{$prod_name}</td></tr>
   <tr><th>種類代號</th><td>{$category}</td></tr>
   <tr><th>商品描述</th><td>{$str_description}</td></tr>
   <tr><th>標示原價</th><td>{$price_mark}</td></tr>
   <tr><th>實際售價</th><td>{$price}</td></tr>
   <tr><th>商品圖檔</th><td>{$picture}</td></tr>
   <tr><th>圖檔目錄</th><td>{$pictset}</td></tr>

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
<button onclick="location.href='prod_list_page.php';">返回列表</button>
<h2>顯示資料</h2>
{$data}
HEREDOC;
 
 
include 'pagemake.php';
pagemake($html, '');
?>