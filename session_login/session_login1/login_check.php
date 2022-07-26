<?php
session_start();

$usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';
$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 假設用戶資料 (資料應存於文字檔或資料庫，此處直接寫在程式內，示範用)

// session變數『usertype』 記錄使用者身分，其值可能為
//   (1)ADMIN  管理者
//   (2)MEMBER 會員
//   (3)未定義為一般訪客

$valid = false;
$_SESSION['usertype'] = '';
$_SESSION['usercode'] = '';

// 會員檢查
if($usertype=='MEMBER'){
    if($password=='11111') {
        $valid = true;
        $_SESSION['usertype'] = 'MEMBER';
        $_SESSION['usercode'] = $usercode;
    }
}

// 系統管理者檢查
if($usertype=='ADMIN'){
    if($password=='12345'){
        $valid = true;
        $_SESSION['usertype'] = 'ADMIN';
        $_SESSION['usercode'] = $usercode;
    }
}

if($valid){
    $msg = $usercode . ' 你好，歡迎光臨！ ';
}
else{
    $msg = '登入錯誤';
}


$html = <<< HEREDOC
<p>{$msg}</p>
<br><br>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>