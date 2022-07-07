<?php
include 'config.php';

// 接收傳入變數
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$address  = isset($_POST['address'])  ? $_POST['address']  : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$height   = isset($_POST['height'])   ? $_POST['height']   : '';
$weight   = isset($_POST['weight'])   ? $_POST['weight']   : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (";
$sqlstr .= "'" . $usercode . "', ";
$sqlstr .= "'" . $username . "', ";
$sqlstr .= "'" . $address  . "', ";
$sqlstr .= "'" . $birthday . "', ";
$sqlstr .= ($height+0) . ", ";
$sqlstr .= ($weight+0) . ", ";
$sqlstr .= "'" . $remark . "') ";  // 注意最後一個欄位的結尾

// 執行 SQL
if(mysqli_query($link, $sqlstr))
{
   $new_uid = mysqli_insert_id($link);    // 傳回剛才新增記錄的 auto_increment 的欄位值
   $url_display = "display.php?uid=" . $new_uid;
   header("Location: " . $url_display);
}
else
{
   echo mysql_error() . '<BR>' . $sqlstr;  exit;   // 此列供開發時期偵錯用，應刪除
   header("Location: error.php?type=add_save");
}

db_close($link);
?>