<?php
include "config.php";

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=" . $uid;
$result = mysqli_query($link, $sqlstr);

if($row=mysqli_fetch_array($result))
{
   $uid      = $row["uid"];
   $usercode = $row["usercode"];
   $username = $row["username"];
   $address  = $row["address"];
   $birthday = $row["birthday"];
   $height   = $row["height"];
   $weight   = $row["weight"];
   $remark   = $row["remark"];
}

db_close($link);


//網頁顯示
$html = <<< HEREDOC
<h2 align="center">修改資料區</h2>

<form action="edit_save.php" method="post">
  <p>代碼：<input type="text" name="usercode" value="{$usercode}"></p>
  <p>姓名：<input type="text" name="username" value="{$username}"></p>
  <p>地址：<input type="text" name="address"  value="{$address}"></p>
  <p>生日：<input type="text" name="birthday" value="{$birthday}"></p>
  <p>身高：<input type="text" name="height"   value="{$height}"></p>
  <p>體重：<input type="text" name="weight"   value="{$weight}"></p>
  <p>備註：<input type="text" name="remark"   value="{$remark}"></p>
  <input type="hidden" name="uid" value="{$uid}">
  <input type="submit" value="送出">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>