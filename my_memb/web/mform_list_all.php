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

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT SUBSTR(formcode, 1, 6) as yyyymm, count(*) as fcnt ";
$sqlstr .= "FROM form ";
$sqlstr .= "WHERE membcode='$ss_usercode' ";
$sqlstr .= "GROUP BY SUBSTR(formcode, 1, 6) ";
$sqlstr .= "ORDER BY yyyymm DESC";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $yyyymm = $row['yyyymm'];
        $fcnt   = $row['fcnt'];
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <td>{$yyyymm}</td>
            <td>{$fcnt}</td>
            <td><a href="mform_list_ym.php?yyyymm={$yyyymm}">查看 {$yyyymm} 清單</a></td>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 {$total_rec} 筆記錄</h3>
    <table border="1" class="table">
        <tr>
            <th>yyyymm</th>
            <th>數量</th>
            <th>操作</th>
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
<h2>會員的申請表單查詢 (月日)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>