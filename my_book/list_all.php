<?php
include 'config.php';

// 連接資料庫
$link = db_open();


$sqlstr = "SELECT * FROM book ";

$result = mysqli_query($link, $sqlstr);

$total_rec = mysqli_num_rows($result);

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
   //$data .= '  <td>' . $author  . '</td>';
   //$data .= '  <td>' . $publish . '</td>';
   //$data .= '  <td>' . date('Y-m-d', strtotime($pub_date)) . '</td>';
   //$data .= '  <td>' . $price   . '</td>';
   //$data .= '  <td>' . $picture   . '</td>';
   $data .= '  <td>' . $remark   . '</td>';
   $data .= '  <td><a href="display.php?uid=' . $uid . '">詳細</a></Ttd>';
   $data .= '  <td><a href="edit.php?uid=' . $uid . '">修改</a></td>';
   $data .= '  <td><a href="delete.php?uid=' . $uid . '" onClick="return confirm(' . "'" . '確定要刪除嗎？' . "'" . ');">刪除</a></td>';
   $data .= '</tr>';
}

db_close($link);



$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍資料系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<H2 align="center">共有 {$total_rec} 筆記錄</h2>
<table border="1" align="center">
   <tr>
      <th>序號</th>
      <th>書碼</th>
      <th>書名</th>
      <th>內容</th>
      <!--  
      <th>作者</th>
      <th>出版社 </th>
      <th>出版日期</th>
      <th>價格</th>
      <th>照片</th>
      -->
      <th>備註</th>
      <td colspan="3" align="center">操作 [<a href="add.php">新增記錄</a>]</td>
   </tr>
{$data}
</table>

</body>
</html>
HEREDOC;

echo $html;
?>