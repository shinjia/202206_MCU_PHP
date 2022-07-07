<?php
include 'config.php';

$uid = $_GET['uid'];


// 連接資料庫
$link = db_open();


$sqlstr = "SELECT * FROM book WHERE uid=" . $uid;
$result = mysqli_query($link, $sqlstr);

if($row=mysqli_fetch_array($result))
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

<h2 align="center">修改資料區</h2>

<form action="edit_save.php" method="post">
  <p>書碼：<input type="text" name="bookcode" value="{$bookcode}"></p>
  <p>書名：<input type="text" name="bookname" value="{$bookname}"></p>
  <p>內容：<input type="text" name="descr"  value="{$descr}"></p>
  <p>作者：<input type="text" name="author"  value="{$author}"></p>
  <p>出版社：<input type="text" name="publish"  value="{$publish}"></p>
  <p>出版日期：<input type="text" name="pub_date" value="{$pub_date}"></p>
  <p>價格：<input type="text" name="price"   value="{$price}"></p>
  <p>照片：<input type="text" name="picture"   value="{$picture}"></p>
  <p>備註：<input type="text" name="remark"   value="{$remark}"></p>
  <input type="hidden" name="uid" value="{$uid}">
  <input type="submit" value="送出">
</form>

</body>
</html>
HEREDOC;

echo $html;
?>