<?php
session_start();

include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
echo $usercode;

// $chk_password = md5($password);  // 一方面是轉為md5()，另一方面也要避免和資料表裡的password欄位相衝，故改存到另一變數
$chk_password = $password;  // 暫時用明碼來檢查

// 會員檢查
$valid = false;


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM customer WHERE account=:usercode ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);

// 執行 SQL
if($sth->execute())
{
   // 成功執行 query 指令
    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $account  = $row['account'];
        $nickname = $row['nickname'];
        $password = $row['password'];
        
        if($row['level']=='MEMBER')
        {
            $level = DEF_LOGIN_MEMBER;
        }
        elseif($row['level']=='ADMIN')
        {
            $level = DEF_LOGIN_ADMIN;
        }
        
	 
        if($chk_password==$password)
        {
            $valid = true;
            $_SESSION['usertype'] = $level;
            $_SESSION['usercode'] = $account;
        }
    }
}


if($valid)
{
   $msg = $nickname . ' 你好，歡迎光臨！ ';
}
else
{
   $msg = '登入錯誤';
}


$html = <<< HEREDOC
{$msg}
<br>
<br>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>