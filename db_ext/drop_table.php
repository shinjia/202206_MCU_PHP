<?php
include 'config.php';

// 連接資料庫
$link = db_open();


// 新增資料表之SQL語法 (採用陣列方式，可以設定多個)
$a_table["person"] = "
DROP TABLE person
";


// 執行SQL及處理結果
$msg = '';
foreach($a_table as $key=>$sqlstr)
{
   $result = mysqli_query($link, $sqlstr);
   
   $msg .= '資料表『' . $key . '』.........';
   $msg .= ($result) ? '刪除完成！' : '無法刪除！';
   $msg .= '<BR>';
}


$html = <<< HEREDOC
<h2>資料表刪除結果</h2>
{$msg}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>