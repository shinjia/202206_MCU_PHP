<?php
include 'config.php';
include 'utility.php';

$uid = $_GET["uid"] + 0;



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM product WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':uid', $uid, PDO::PARAM_INT);


// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $prod_code = convert_to_html($row['prod_code']);
      $prod_name = convert_to_html($row['prod_name']);
      $category = convert_to_html($row['category']);
      $description = convert_to_html($row['description']);
      $price_mark = convert_to_html($row['price_mark']);
      $price = convert_to_html($row['price']);
      $picture = convert_to_html($row['picture']);
      $pictset = convert_to_html($row['pictset']);



      
      $data = <<< HEREDOC
      <form action="prod_edit_save.php" method="post">
      <table>
        <tr><th>商品代碼</th><td><input type="text" name="prod_code" value="{$prod_code}" /></td></tr>
        <tr><th>商品名稱</th><td><input type="text" name="prod_name" value="{$prod_name}" /></td></tr>
        <tr><th>種類代號</th><td><input type="text" name="category" value="{$category}" /></td></tr>
        <tr><th>商品描述</th><td><textarea name="description">{$description}</textarea></td></tr>
        <tr><th>標示原價</th><td><input type="text" name="price_mark" value="{$price_mark}" /></td></tr>
        <tr><th>實際售價</th><td><input type="text" name="price" value="{$price}" /></td></tr>
        <tr><th>商品圖檔</th><td><input type="text" name="picture" value="{$picture}" /></td></tr>
        <tr><th>圖檔目錄</th><td><input type="text" name="pictset" value="{$pictset}" /></td></tr>

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