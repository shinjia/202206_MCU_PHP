<?php
include 'config.php';

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=" . $uid;

// 執行 SQL
$result = mysqli_query($link, $sqlstr);

if($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   $uid      = $row['uid'];
   $usercode = $row['usercode'];
   $username = $row['username'];
   $address  = $row['address'];
   $birthday = $row['birthday'];
   $height   = $row['height'];
   $weight   = $row['weight'];
   $remark   = $row['remark'];
}

db_close($link);


//網頁顯示
$html = <<< HEREDOC
<h2 align="center">詳細資料</h2>

<table border="1">
  <tr><th>代碼</th><td>{$usercode}</td></tr>
  <tr><th>姓名</th><td>{$username}</td></tr>
  <tr><th>地址</th><td>{$address}</td></tr>
  <tr><th>生日</th><td>{$birthday}</td></tr>
  <tr><th>身高</th><td>{$height}</td></tr>
  <tr><th>體重</th><td>{$weight}</td></tr>
  <tr><th>備註</th><td>{$remark}</td></tr>
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>