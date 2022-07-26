<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[SYSTEM_CODE.'usertype']) ? $_SESSION[SYSTEM_CODE.'usertype'] : '';
$ss_usercode = isset($_SESSION[SYSTEM_CODE.'usercode']) ? $_SESSION[SYSTEM_CODE.'usercode'] : '';

if($ss_usertype!=DEF_LOGIN_ADMIN)
{
    header('Location: login_error.php');
    exit;
}


// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM form WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);
        $membcode = html_encode($row['membcode']);
        $remark   = html_encode($row['remark']);

        $data = <<< HEREDOC
        <table border="1" class="table">
            <tr><th>代碼</th><td>{$formcode}</td></tr>
            <tr><th>主旨</th><td>{$formname}</td></tr>
            <tr><th>日期</th><td>{$formdate}</td></tr>
            <tr><th>欄一</th><td>{$formfld1}</td></tr>
            <tr><th>欄二</th><td>{$formfld2}</td></tr>
            <tr><th>更多</th><td>{$forminfo}</td></tr>
            <tr><th>會員代號</th><td>{$membcode}</td></tr>
            <tr><th>備註</th><td>{$remark}</td></tr>
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