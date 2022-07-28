<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */
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
$sqlstr = "SELECT * FROM memb WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $uid = $row['uid'];
        
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);
        $membpass = html_encode($row['membpass']);
        $membtele = html_encode($row['membtele']);
        $membmail = html_encode($row['membmail']);
        $membinfo = html_encode($row['membinfo']);
        $memblike = html_encode($row['memblike']);
        $membpict = html_encode($row['membpict']);
        $membpset = html_encode($row['membpset']);
        $membtype = html_encode($row['membtype']);
        $googleid = html_encode($row['googleid']);
        $status   = html_encode($row['status']);
        $remark   = html_encode($row['remark']);
        
        $data = <<< HEREDOC
        <form action="memb_edit_save.php" method="post">
        <table class="table">
            <tr><th>帳號</th><td><input type="text" name="membcode" value="{$membcode}"></td></tr>
            <tr><th>姓名</th><td><input type="text" name="membname" value="{$membname}"></td></tr>
            <tr><th>密碼</th><td><input type="text" name="membpass" value="{$membpass}"></td></tr>
            <tr><th>電話</th><td><input type="text" name="membtele" value="{$membtele}"></td></tr>
            <tr><th>郵件</th><td><input type="text" name="membmail" value="{$membmail}"></td></tr>
            <tr><th>資訊</th><td><input type="text" name="membinfo" value="{$membinfo}"></td></tr>
            <tr><th>興趣</th><td><input type="text" name="memblike" value="{$memblike}"></td></tr>
            <tr><th>圖片</th><td><input type="text" name="membpict" value="{$membpict}"></td></tr>
            <tr><th>圖集</th><td><input type="text" name="membpset" value="{$membpset}"></td></tr>
            <tr><th>類別</th><td><input type="text" name="membtype" value="{$membtype}"></td></tr>
            <tr><th>Google ID</th><td><input type="text" name="googleid" value="{$googleid}"></td></tr>
            <tr><th>狀態</th><td><input type="text" name="status" value="{$status}"></td></tr>
            <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
        </table>
        <p>
            <input type="hidden" name="uid" value="{$uid}">
            <input type="submit" value="送出">
        </p>
        </form>
HEREDOC;
    }
    else {
        $data = '<p class="center">無資料</p>';
    }

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <div>
        {$data}
    </div>
HEREDOC;
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


//網頁顯示
$html = <<< HEREDOC
<h2>修改資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>