<?php

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

include '../common/func_generate_password.php';

// 接收傳入變數
$code = isset($_GET['code']) ? $_GET['code'] : '';
$chk = isset($_GET['chk']) ? $_GET['chk'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

$msg = '';
if($chk==md5(SYSTEM_CODE.$code)) {
    // 進行會員類型的修改
    // 連接資料庫
    $pdo = db_open();

    // 產生預先的密碼
    $password = generate_password(16);
    $password_encrypt = md5(DEF_PASSWORD_PREFIX . $password);  // 加密
    $membtype = DEF_LOGIN_MEMBER;
    $apply = DEF_LOGIN_APPLY;  //　必須目前是 DEF_LOGIN_APPLY 的會員才能驗証

    // SQL 語法
    // 寫入資料庫的密碼必須加密
    $sqlstr = "UPDATE memb SET membtype='$membtype', membpass='$password_encrypt' ";
    $sqlstr .= "WHERE membcode = '$code' ";
    $sqlstr .= "AND membtype= '$apply' ";

    // 執行 SQL
    try { 
        $sth = $pdo->query($sqlstr);
        $count = $sth->rowCount();

        if($count==1) {
            $msg = <<< HEREDOC
            <p>帳號已驗証通過，成為正式會員。</p>
            <p>以下是您的帳號及密碼，請務必在 <a href="login.php">登入</a> 後立即更換密碼！！</p>
            <ul>
                <li>帳號：{$code}</li>
                <li>密碼：{$password}</li>
            </ul>
HEREDOC;
        }
        else {
            // 未通過
            $msg = <<< HEREDOC
            <p>帳號驗証未通過，可能是下列原因：</p>
            <ul>
                <li>不是正確的連結</li>
                <li>目前不是等候驗証的會員身份</li>
            </ul>
HEREDOC;
        }
        
    }
    catch(PDOException $e) {
        // db_error(ERROR_QUERY, $e->getMessage());
        $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    }
    
    db_close();
}
else {
    // 未通過
    $msg = <<< HEREDOC
    <p>帳號驗証未通過，可能是下列原因：</p>
    <ul>
        <li>不是正確的連結</li>
    </ul>
HEREDOC;
}

$ihc_content = $msg;

$html = <<< HEREDOC
<h2>帳號驗証</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>