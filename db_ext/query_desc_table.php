<?php
include 'config.php';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = 'desc person';


// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr);
// if(is_resource($result))
// if (is_string($result))
if ($result instanceof mysqli_result) 
{
   // SELECT 語法結果
   $total_rec = mysqli_num_rows($result);
   
   // 以各欄位名稱當表格標題
   $data  = '<table border="1" cellpadding="2" cellspaceing="0">';
   $data .= '<tr>';
   
   $finfo = mysqli_fetch_fields($result);
   foreach ($finfo as $val)
   {
      //printf ("Name:%s \n", $val->name);
      //printf ("Table:%s \n", $val->table);
      //printf ("max. Len:%d \n", $val->max_length);
      //printf ("Flags:%d \n", $val->flags);
      //printf ("Type:%d \n\n" , $val->type);
      $data .= '<th>' . $val->name . '</th>';
   }

   $data .= '</tr>';
   
   // 列出各筆記錄資料
   while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
   {
      $data .= '<tr>';
      foreach($row as $one)
      {
         $data .= '<td>' . $one . '</td>';
      }
      $data .= '</tr>';
   }
   $data .= '</table>';
}
else
{
   // 非SELECT語法
   if($result)
   {
      $data = '<h2>執行結果成功！</h2>';
   }
   else
   {
      $data = '<h2>無執行結果！</h2>' ;
      $data .= '<BR>錯誤代號：' . mysqli_errno();
      $data .= '<BR>錯誤訊息：' . mysqli_error();
   }
}


db_close($link);


$html = <<< HEREDOC
<h2>資料表定義</h2>
<p>SQL: desc person</p>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>