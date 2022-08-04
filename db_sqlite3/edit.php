<?php
include 'config.php';
include 'utility.php';

$uid = $_GET['uid'];

// 連接資料庫
$pdo = db_open();
	
// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=" . $uid;

// 執行SQL及處理結果
$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC))
{
   $uid = $row['uid'];
   $usercode = convert_to_html($row['usercode']);
   $username = convert_to_html($row['username']);
   $address  = convert_to_html($row['address']);
   $birthday = convert_to_html($row['birthday']);
   $height   = convert_to_html($row['height']);
   $weight   = convert_to_html($row['weight']);
   $remark   = convert_to_html($row['remark']);
   
   $data = <<< HEREDOC
<form action="edit_save.php" method="post">
<table>
   <tr><th>代碼</th><td><input type="text" name="usercode" value="{$usercode}"></td></tr>
   <tr><th>姓名</th><td><input type="text" name="username" value="{$username}"></td></tr>
   <tr><th>地址</th><td><input type="text" name="address" value="{$address}"></td></tr>
   <tr><th>生日</th><td><input type="text" name="birthday" value="{$birthday}"></td></tr>
   <tr><th>身高</th><td><input type="text" name="height" value="{$height}"></td></tr>
   <tr><th>體重</th><td><input type="text" name="weight" value="{$weight}"></td></tr>
   <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
</table>
<p>
   <input type="hidden" name="uid" value="{$uid}">
   <input type="submit" value="送出">
</p>
</form>
HEREDOC;
}
else
{
	 $data = '查不到相關記錄';
}


$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>修改資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>