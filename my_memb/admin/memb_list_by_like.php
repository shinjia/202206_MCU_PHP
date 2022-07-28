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
$key = isset($_GET['key']) ? $_GET['key'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb ";
$sqlstr .= "WHERE memblike LIKE ? ";

$keyword = '%' . $key . '%';

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $keyword, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    $total_rec = $sth->rowCount();

    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);
        $memblike = html_encode($row['memblike']);
    
        // 讓每一個興趣都有超連結
        $str_like = '';
        $ary = explode(',', $memblike);
        foreach($ary as $value) {
            $one = trim($value);
            $lnk = 'memb_list_by_like.php?key=' . $one;
            
            $str_like .= '<a href="' . $lnk . '">' . $one .'</a> ';
        }

        $data .= <<< HEREDOC
        <tr>
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$membcode}</td>
            <td>{$membname}</td>
            <td>{$memblike}</td>
            <td>{$str_like}</td>
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
            <th>興趣</th>
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
<h2>興趣含『{$key}』</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>