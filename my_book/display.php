<?php
include 'config.php';

$uid = $_GET['uid'];


// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM book WHERE uid=" . $uid;

// 執行 SQL
$result = mysqli_query($link, $sqlstr) or die(ERROR_QUERY);

if($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   $uid      = $row['uid'];
   $bookcode = $row['bookcode'];
   $bookname = $row['bookname'];
   $descr    = $row['descr'];
   $author   = $row['author'];
   $publish  = $row['publish'];
   $pub_date = $row['pub_date'];
   $price    = $row['price'];
   $picture  = $row['picture'];
   $remark   = $row['remark'];
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

<h2 align="center">詳細資料</h2>

<p><a href="index.php">回首頁 (index.php)</a></p>

<table border="1">
  <tr>
    <th>書碼</th>
    <td>{$bookcode}</td>
  </tr>
  <tr>
    <th>書名</th>
    <td>{$bookname}</td>
  </tr>
  <tr>
    <th>內容</th>
    <td>{$descr}</td>
  </tr>
  <tr>
    <th>作者</th>
    <td>{$author}</td>
  </tr>
  <tr>
    <th>出版社</th>
    <td>{$publish}</td>
  </tr>
  <tr>
    <th>出版日期</th>
    <td>{$pub_date}</td>
  </tr>
  <tr>
    <th>價格</th>
    <td>{$price}</td>
  </tr>
  <tr>
    <th>照片</th>
    <td>{$picture}</td>
  </tr>
  <tr>
    <th>備註</th>
    <td>{$remark}</td>
  </tr>
</table>

</body>
</html>
HEREDOC;

echo $html;
?>