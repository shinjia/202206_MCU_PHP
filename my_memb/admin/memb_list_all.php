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


// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb ";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
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
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$membcode}</td>
            <td>{$membname}</td>
            <td>{$membpass}</td>
            <td>{$membtele}</td>
            <td>{$membmail}</td>
            <td>{$membinfo}</td>
            <td>{$memblike}</td>
            <td>{$membpict}</td>
            <td>{$membpset}</td>
            <td>{$membtype}</td>
            <td>{$googleid}</td>
            <td>{$status}</td>
            <td>{$remark}</td>
            <td><a href="memb_display.php?uid={$uid}">詳細</a></td>
            <td><a href="memb_edit.php?uid={$uid}">修改</a></td>
            <td><a href="memb_delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 {$total_rec} 筆記錄</h3>
    <table border="1" class="table">
        <tr>
            <th>順序</th>
            <th>uid</th>
            <th>帳號</th>
            <th>姓名</th>
            <th>密碼</th>
            <th>電話</th>
            <th>信箱</th>
            <th>資訊</th>
            <th>興趣</th>
            <th>圖片</th>
            <th>圖檔</th>
            <th>類別</th>
            <th>Google ID</th>
            <th>狀態</th>
            <th>備註</th>
            <th colspan="3" align="center"><a href="memb_add.php">新增記錄</a></th>
        </tr>
        {$data}
    </table>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


$html = <<< HEREDOC
<h2>資料列表 (全部)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>