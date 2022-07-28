<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb WHERE membcode=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $ss_usercode, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $membname = html_encode($row['membname']);
        $membtele = html_encode($row['membtele']);
        $membmail = html_encode($row['membmail']);
        $membinfo = html_encode($row['membinfo']);
        $memblike = html_encode($row['memblike']);
        $remark   = html_encode($row['remark']);
        
        $data = <<< HEREDOC
        <form action="edit_data_save.php" method="post">
        <table class="table">
            <tr><th>姓名</th><td><input type="text" name="membname" value="{$membname}"></td></tr>
            <tr><th>電話</th><td><input type="text" name="membtele" value="{$membtele}"></td></tr>
            <tr><th>郵件</th><td><input type="text" name="membmail" value="{$membmail}"></td></tr>
            <tr><th>資訊</th><td><input type="text" name="membinfo" value="{$membinfo}"></td></tr>
            <tr><th>興趣</th><td><input type="text" name="memblike" value="{$memblike}"></td></tr>
            <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
        </table>
        <p>
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
<h2>修改個人基本資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>