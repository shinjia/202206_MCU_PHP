<?php
include 'config.php';

// 接收傳入變數
$uid      = (isset($_POST['uid']))      ? $_POST['uid']      : '';
$usercode = (isset($_POST['usercode'])) ? $_POST['usercode'] : '';
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$address  = (isset($_POST['address']))  ? $_POST['address']  : '';
$birthday = (isset($_POST['birthday'])) ? $_POST['birthday'] : '';
$height   = (isset($_POST['height']))   ? $_POST['height']   : 0;
$weight   = (isset($_POST['weight']))   ? $_POST['weight']   : 0;
$remark   = (isset($_POST['remark']))   ? $_POST['remark']   : '';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr  = "UPDATE person SET ";
$sqlstr .= "usercode='" . $usercode   . "', ";
$sqlstr .= "username='" . $username   . "', ";
$sqlstr .= "address='"  . $address    . "', ";
$sqlstr .= "birthday='" . $birthday   . "', ";
$sqlstr .= "height="    . ($height+0) . ", ";
$sqlstr .= "weight="    . ($weight+0) . ",  ";
$sqlstr .= "remark='"   . $remark     . "' ";  // 注意最後一個欄位後面的符號
$sqlstr .= "WHERE uid=" . $uid;

if(mysqli_query($link, $sqlstr))
{
   $url_display = "display.php?uid=" . $uid;
   header("Location: " . $url_display);
}
else
{
   echo mysql_error($link) . '<BR>' . $sqlstr;  exit;   // 此列供開發時期偵錯用，應刪除
   header("Location: error.php");
}

db_close($link);
?>