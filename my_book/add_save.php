<?php
include 'config.php';

$bookcode = isset($_POST['bookcode']) ? $_POST['bookcode'] : '';
$bookname = isset($_POST['bookname']) ? $_POST['bookname'] : '';
$descr    = isset($_POST['descr'])    ? $_POST['descr']    : '';
$author   = isset($_POST['author'])   ? $_POST['author']   : '';
$publish  = isset($_POST['publish'])  ? $_POST['publish']  : '';
$pub_date = isset($_POST['pub_date']) ? $_POST['pub_date'] : '';
$price    = isset($_POST['price'])    ? $_POST['price']    : '';
$picture  = isset($_POST['picture'])  ? $_POST['picture']  : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';


// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
$sqlstr = "INSERT INTO book(bookcode, bookname, descr, author, publish, pub_date, price, picture, remark) VALUES ('$bookcode', '$bookname', '$descr', '$author', '$publish', '$pub_date', '$price', '$picture', '$remark') ";


// 執行 SQL
if(mysqli_query($link, $sqlstr))
{
   $new_uid = mysqli_insert_id($link);    // 傳回剛才新增記錄的 auto_increment 的欄位值
   
   $msg = '資料已新增完畢!!!!!!!!';
   $msg .= '<BR><a href="display.php?uid=' . $new_uid . '">詳細</a>';
}
else
{
   $msg = '資料無法新增!!!!!!!!';
   $msg .= '<HR>' . $sqlstr . '<HR>' . mysqli_error();
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
<bodyY>
{$msg}
</body>
</html>
HEREDOC;

echo $html;
?>