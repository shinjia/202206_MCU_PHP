<?php
include 'config.php';

$key = isset($_POST['key']) ? $_POST['key'] : '';


// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
//$key = mysqli_real_escape_string($link, $key);
$sqlstr = "SELECT * FROM person WHERE usercode='" . $key . "' ";

// 執行 SQL
$result = mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
if($row=mysqli_fetch_array($result))
{
   $uid      = $row['uid'];
   $usercode = $row['usercode'];
   $username = $row['username'];
   $address  = $row['address'];
   $birthday = $row['birthday'];
   $height   = $row['height'];
   $weight   = $row['weight'];
   $remark   = $row['remark'];
   
   $data = <<< HEREDOC
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
}
else
{
	 $data = '查無相關記錄！';
}


$html = <<< HEREDOC
<h2>顯示資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>