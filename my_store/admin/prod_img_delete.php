<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';
include '../common/function.get_entry_in_dir.php';


$file = isset($_GET['file']) ? $_GET['file'] : '';
$uid = isset($_GET['uid']) ? $_GET['uid'] : '';



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


//=======================================================



// 依類型定義相對應的路徑目錄
$path_img = '../upload/' . $pictset ;


// 指定存檔的資料夾
$file_img = $path_img . '/' . $file;

//echo '<br>' . $file_img;
if(!empty($file_img) && file_exists($file_img))
{
   unlink($file_img);
   $msg .= '圖檔已刪除';
   //echo $msg; exit;
   //echo '<br>kill';
}


//echo '<br>ok';

$url = 'prod_img_display.php?uid=' . $uid . '&r=' . uniqid();
header('Location: ' . $url);
exit;
?>