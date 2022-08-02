<?php
/* my_form v0.1  @Shinjia  #2022/07/30 */
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

// 接收傳入變數
$formcode = isset($_GET['formcode']) ? $_GET['formcode'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM mform_vw ";
$sqlstr .= "WHERE formcode=? && membcode=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $formcode   , PDO::PARAM_STR);
$sth->bindValue(2, $ss_usercode, PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);
        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);

        $data = <<< HEREDOC
        <h3>會員</h3>
        <p>會員代號：{$membcode}</p>
        <p>會員姓名：{$membname}</p>
        <hr>
        <h3>表單</h3>
        <table border="1" class="table">
            <tr><th>代碼</th><td>{$formcode}</td></tr>
            <tr><th>主旨</th><td>{$formname}</td></tr>
            <tr><th>日期</th><td>{$formdate}</td></tr>
            <tr><th>欄一</th><td>{$formfld1}</td></tr>
            <tr><th>欄二</th><td>{$formfld2}</td></tr>
            <tr><th>更多</th><td>{$forminfo}</td></tr>
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

// 條碼內容
$now = time();
$chk = md5(SYSTEM_CODE.$formcode.$now);  // 自訂編碼規則
$code = URL_ROOT . 'api/mform_display.php?formcode=' . $formcode . '&ts=' . $now . '&chk=' . $chk;

// 在網頁上秀出 QR Code
$url_qr = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . $code . '&choe=UTF-8';

$str_qr = '<img src="' . $url_qr . '">';
$str_qr .= '<br>上方條碼 (直接測試網址)：<a href="'. $code . '" target="_blank">' . $code . '</a>';

//網頁顯示
$html = <<< HEREDOC
<h2>會員的申請表單</h2>
{$ihc_content}
{$str_qr}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>