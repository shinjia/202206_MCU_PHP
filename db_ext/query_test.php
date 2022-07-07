<?php
include 'config.php';

// 接收傳入變數
$sql = isset($_POST['sql']) ? $_POST['sql'] : ' ';
$sql = stripslashes($sql);  // 去除表單傳遞時產生的脫逸符號

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = $sql;

// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr);
// if(is_resource($result))
// if (is_string($result))
if ($result instanceof mysqli_result) 
{
   // SELECT 語法結果
   $total_rec = mysqli_num_rows($result);
   
   // 以各欄位名稱當表格標題
   $data = '<h2>共有 ' . $total_rec . ' 筆記錄</h2>';
   $data .= '<table border="1" cellpadding="2" cellspaceing="0">';
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
      $data .= '<BR>錯誤代號：' . mysqli_errno($link);
      $data .= '<BR>錯誤訊息：' . mysqli_error($link);
   }
}

if(empty($sql))  // 初次執行
{
   $data = '歡迎使用 SQL 測試程式';
}

db_close($link);


$html = <<< HEREDOC
<h1>SQL指令測試程式</h1>
<form name="form1" method="post" action="">
請輸入SQL指令<BR>
<textarea name="sql" rows="4" cols="80">{$sqlstr}</textarea><br />
<input type="SUBMIT" value="送出查詢">
</form>
<hr>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>