<?php
/* my_form v0.1  @Shinjia  #2022/07/27 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

if($ss_usertype!=DEF_LOGIN_ADMIN) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================


// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);
        $membpass = html_encode($row['membpass']);
        $membmail = html_encode($row['membmail']);
        $membtype = html_encode($row['membtype']);

        // 確認信件中的超連結
        $title = '網站會員申請驗証';
        $code = $membcode;
        $chk = md5(SYSTEM_CODE.$code);
        $link = '../web/signup_verify.php?code=' . $code . '&chk=' . $chk;

        $data = <<< HEREDOC
        <table border="1" class="table">
            <tr><th>帳號</th><td>{$membcode}</td></tr>
            <tr><th>姓名</th><td>{$membname}</td></tr>
            <tr><th>密碼</th><td>{$membpass}</td></tr>
            <tr><th>信箱</th><td>{$membmail}</td></tr>
            <tr><th>類別</th><td>{$membtype}</td></tr>
            <tr><th>link</th><td><a href="{$link}">{$link}</a></td></tr>
        </table>
HEREDOC;

        // 網頁內容
        $ihc_content = <<< HEREDOC
        {$data}
HEREDOC;
    }
    else {
        $ihc_content = '<p class="center">查不到相關記錄！</p>';
    }
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


//網頁顯示
$html = <<< HEREDOC
<h2>詳細資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>