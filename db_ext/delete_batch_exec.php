<?php
include 'config.php';

$a_uid = isset($_POST['a_uid']) ? $_POST['a_uid'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;  // 原本的頁碼

if(!empty($a_uid))
{
   $str_list = join($a_uid, ",");
}
else
{
   $str_list = 'null';
}


// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "DELETE FROM person WHERE uid IN(" . $str_list . ") ";

// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr);
if($result)
{
   $msg = '勾選之資料已刪除!!!!!!!!';
}
else
{
   echo mysqli_error($link) . '<br />' . $sqlstr;  exit; // 此列供開發時期偵錯用，應刪除
   $msg = '有問題，資料無法刪除。';
}


$html = <<< HEREDOC
<h1>資料整批刪除作業</h1>
<p>{$msg}</p>
<p><a href="delete_batch_list.php?page={$page}">再回到資料列表畫面</a></p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>