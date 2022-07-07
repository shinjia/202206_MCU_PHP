<?php
// 含分頁之資料列表
include 'config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼


$numpp = 20; // 每頁的筆數


// 連接資料庫
$link = db_open();


// 處理分頁
$sqlstr = "SELECT count(*) as total_rec FROM book ";
$result = mysqli_query($link, $sqlstr);
   

if($row=mysqli_fetch_array($result))
{
   $total_rec = $row["total_rec"];
   // $total_rec = mysqli_num_rows($result);  // 計算總筆數
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數
   

// 擷取該分頁資料
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資料


$sqlstr = "SELECT * FROM book ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

$result = mysqli_query($link, $sqlstr);


$data = '';
while($row=mysqli_fetch_array($result))
{
   $uid      = $row['uid'];
   $bookcode = $row['bookcode'];
   $bookname = $row['bookname'];
   $descr  = $row['descr'];
   $author  = $row['author'];
   $publish  = $row['publish'];
   $pub_date = $row['pub_date'];
   $price   = $row['price'];
   $picture   = $row['picture'];
   $remark   = $row['remark'];
   
   $data .= '<tr>';
   $data .= '  <td>' . $uid      . '</td>';
   $data .= '  <td>' . $bookcode . '</td>';
   $data .= '  <td>' . $bookname . '</td>';
   $data .= '  <td>' . $descr  . '</td>';
   $data .= '  <td>' . $author  . '</td>';
   $data .= '  <td>' . $publish  . '</td>';
   $data .= '  <td>' . date("Y-m-d", strtotime($pub_date)) . '</td>';
   $data .= '  <td>' . $price   . '</td>';
   $data .= '  <td>' . $picture   . '</td>';
   $data .= '  <td>' . $remark   . '</td>';
   $data .= '  <td><a href="display.php?uid=' . $uid . '">詳細</a></td>';
   $data .= '  <td><a href="edit.php?uid=' . $uid . '">修改</a></td>';
   $data .= '  <td><a href="delete.php?uid=' . $uid . '" onClick="return confirm(' . "'" . '確定要刪除嗎？' . "'" . ');">刪除</a></td>';
   $data .= '</TR>';
}

db_close($link);


// 分頁之超連結
$navigator = "";
for($i=1; $i<=$page-1; $i++)
{
   $navigator .= "<a href=\"?page=" . $i . "\">" . $i . "</a>&nbsp;";
}
$navigator .= "[" . $i . "]&nbsp;";
for($i=$page+1; $i<=$total_page; $i++)
{
   $navigator .= "<a href=\"?page=" . $i .  "\">" . $i . "</a>&nbsp;";
}

$lnk_pageprev  = "?page=" . (($page==1)?(1):($page-1));
$lnk_pagenext  = "?page=" . (($page==$total_page)?($total_page):($page+1));
$lnk_pagefirst = "?page=1";
$lnk_pagelast  = "?page=" . $total_page;


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍資料系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<H2 align="center">共有 $total_rec 筆記錄</h2>
<table border="0" align="center">
   <tr> 
      <td colspan="30">{$navigator}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pages: {$page} / {$total_page} &nbsp;&nbsp;&nbsp;
        <a href="{$lnk_pagefirst}">第一頁</a>&nbsp;
        <a href="{$lnk_pageprev}">上一頁</a>&nbsp;
        <a href="{$lnk_pagenext}">下一頁</a>&nbsp;
        <a href="{$lnk_pagelast}">最末頁</a>&nbsp;
      </td>
   </tr>
</table>

<table border="1" align="center">   
   <TR>
      <th>序號</th>
      <th>書碼</th>
      <th>書名</th>
      <th>內容</th>
      <th>作者</th>
      <th>出版社</th>
      <th>出版日期</th>
      <th>價格</th>
      <th>照片</th>
      <th>備註</th>
      <th colspan="3" align="center">操作 [<a href="add.php">新增記錄</a>]</td>
   </TR>
{$data}
</table>
</body>
</html>
HEREDOC;

echo $html;
?>