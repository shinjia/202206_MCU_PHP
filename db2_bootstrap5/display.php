<?php
include 'config.php';
include 'utility.php';

$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
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
       <table class="table">
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
 	   $data = '查不到相關記錄！';
   }
}
else
{
   // 無法執行 query 指令時
   $data = error_message('display');
}


$html = <<< HEREDOC
<button onclick="location.href='list_page.php';" class="btn btn-primary">返回列表</button>
<h2>顯示資料</h2>
{$data}
HEREDOC;
 
include 'pagemake.php';
pagemake($html, '');
?>