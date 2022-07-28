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

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT memblike FROM memb ";
$sqlstr .= "WHERE memblike != '' ";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();

    $a_like = array();
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $memblike = html_encode($row['memblike']);
    
        // 把字串分解成陣列
        $ary = explode(',', $memblike);
        foreach($ary as $value) {
            $one = trim($value);  // 前後的空白移除
            $a_like[$one] = isset($a_like[$one]) ? ($a_like[$one]+1) : 1;
        }
    }

    arsort($a_like);  // 依數量由大排到小

    $cnt = 0;
    $data = '<ul>';
    foreach($a_like as $key=>$value) {
        $cnt++;
        $lnk = 'memb_list_by_like.php?key=' . $key;
        $data .= '<li>';
        $data .= $cnt . '. <a href="' . $lnk . '">' . $key . ' (' . $value . ')</a> ';
        $data .= '</li>';
    }
    $data .= '</ul>';

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 {$cnt} 種不同的興趣</h3>
    {$data}
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
<h2>興趣種類</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>