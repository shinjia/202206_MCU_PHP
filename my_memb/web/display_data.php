<?php
/* my_form v0.1  @Shinjia  #2022/07/27 */
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

// 指定照片的資料夾
$path = DEF_PHOTO_PATH;

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

        // 處理欄位：照片
        // 注意：圖片顯示在網頁上，由圖檔名網址有可能洩露網站的一些資訊
        $img_photo = $path . $membpict;
        if(!file_exists($img_photo) || $membpict=='') {
            $img_photo = $path . '00_default.png';
        }
        $img_photo .= '?t=' . uniqid();  // 強制每次都會重新讀取

        $str_photo = '';
        $str_photo .= '<a href="' . $img_photo . '" target="_blank">';
        $str_photo .= '<img src="' . $img_photo . '" style="width:200px;">';            
        $str_photo .= '</a>';

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
        {$str_photo}
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