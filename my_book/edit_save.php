<?php
include 'config.php';

$uid      = isset($_POST['uid'])      ? $_POST['uid']      : '';
$bookcode = isset($_POST['bookcode']) ? $_POST['bookcode'] : '';
$bookname = isset($_POST['bookname']) ? $_POST['bookname'] : '';
$descr    = isset($_POST['descr'])    ? $_POST['descr']    : '';
$author   = isset($_POST['author'])   ? $_POST['author']   : '';
$publish  = isset($_POST['publish'])  ? $_POST['publish']  : '';
$pub_date = isset($_POST['pub_date']) ? $_POST['pub_date'] : '';
$price    = isset($_POST['price'])    ? $_POST['price']    : 0;
$picture  = isset($_POST['picture'])  ? $_POST['picture']  : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';


// 連接資料庫
$link = db_open();

$sqlstr  = "UPDATE book SET ";
$sqlstr .= "bookcode='" . $bookcode . "', ";
$sqlstr .= "bookname='" . $bookname . "', ";
$sqlstr .= "descr='"    . $descr    . "', ";
$sqlstr .= "author='"   . $author   . "', ";
$sqlstr .= "publish='"  . $publish  . "', ";
$sqlstr .= "pub_date='" . $pub_date . "', ";
$sqlstr .= "price='"    . $price    . "', ";
$sqlstr .= "picture='"  . $picture  . "', ";
$sqlstr .= "remark='"   . $remark   . "' ";  // 注意最後欄位沒有逗號
$sqlstr .= "WHERE uid=" . $uid;


if(mysqli_query($link, $sqlstr))
{
   $msg = '資料已修改完畢!!!!!!!!';
   $msg .= '<br /><a href="display.php?uid=' . $uid . '">詳細</a>';
}
else
{
   $msg = '資料無法修改!!!!!!!';
   $msg .= '<hr />' . $sqlstr . '<hr />' . mysqli_error();
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
{$msg}
</body>
</html>
HEREDOC;

echo $html;
?>