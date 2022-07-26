<?php

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

include '../common/func_generate_password.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';
$chk = isset($_GET['chk']) ? $_GET['chk'] : '';

$msg = '';
if($chk==md5(SYSTEM_CODE.$code)) {
    // 進行會員類型的修改
    // 連接資料庫
    $pdo = db_open();

    $password = generate_password(16);
    
    // SQL 語法
    $sqlstr = "UPDATE memb SET membtype='MEMBER', membpass='$password' ";
    $sqlstr .= "WHERE membcode = '$code'";

    // 執行 SQL
    try { 
        $sth = $pdo->query($sqlstr);        
        $msg = <<< HEREDOC
        <h2>帳號已驗証，成為正式會員！</h2>
        <p>帳號：{$code}</p>
        <p>密碼：{$password}</p>
        <p>務必在登入後立即更換密碼！</p>
HEREDOC;
    }
    catch(PDOException $e) {
        db_error(ERROR_QUERY, $e->getMessage());
        // $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    }
    
    db_close();
}
else {
    // 未通過
    $msg = '<h2>帳號驗証未通過，請使用正確的連結！</h2>';
}


$html = <<< HEREDOC
{$msg}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
