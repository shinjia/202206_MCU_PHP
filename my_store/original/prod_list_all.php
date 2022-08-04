<?php
include 'config.php';
include 'utility.php';



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM product ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   $data = '';
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
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

    
      $data .= <<< HEREDOC
     <tr>
        <td>{$uid}</td>
        <td>{$prod_code}</td>
        <td>{$prod_name}</td>
        <td>{$category}</td>
        <td>{$str_description}</td>
        <td>{$price_mark}</td>
        <td>{$price}</td>
        <td>{$picture}</td>
        <td>{$pictset}</td>

       <td><a href="prod_display.php?uid={$uid}">詳細</a></td>
       <td><a href="prod_edit.php?uid={$uid}">修改</a></td>
       <td><a href="prod_delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
     </tr>
HEREDOC;
   }
   
   $html = <<< HEREDOC
   <h2 align="center">共有 {$total_rec} 筆記錄</h2>
   <table border="1" align="center">
      <tr>
        <th>序號</th>
        <th>商品代碼</th>
        <th>商品名稱</th>
        <th>種類代號</th>
        <th>商品描述</th>
        <th>標示原價</th>
        <th>實際售價</th>
        <th>商品圖檔</th>
        <th>圖檔目錄</th>

      <th colspan="3" align="center"><a href="prod_add.php">新增記錄</a></th>
      </tr>
      {$data}
   </table>
HEREDOC;
}
else
{
   // 無法執行 query 指令時
   $html = error_message('list_all');
}


include 'pagemake.php';
pagemake($html);
?>