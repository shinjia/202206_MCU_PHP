<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

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
        <table border="1" class="table">
            <tr><th>帳號</th><td>{$membcode}</td></tr>
            <tr><th>姓名</th><td>{$membname}</td></tr>
            <tr><th>密碼</th><td>{$membpass}</td></tr>
            <tr><th>電話</th><td>{$membtele}</td></tr>
            <tr><th>信箱</th><td>{$membmail}</td></tr>
            <tr><th>資料</th><td>{$membinfo}</td></tr>
            <tr><th>興趣</th><td>{$memblike}</td></tr>
            <tr><th>圖片</th><td>{$membpict}</td></tr>
            <tr><th>圖集</th><td>{$membpset}</td></tr>
            <tr><th>類別</th><td>{$membtype}</td></tr>
            <tr><th>Google ID</th><td>{$googleid}</td></tr>
            <tr><th>狀態</th><td>{$status}</td></tr>
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