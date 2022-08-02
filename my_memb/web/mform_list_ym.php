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
$yyyymm = isset($_GET['yyyymm']) ? $_GET['yyyymm'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM mform_vw ";
$sqlstr .= "WHERE membcode='$ss_usercode' ";
$sqlstr .= " AND SUBSTR(formcode,1,6)=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $yyyymm, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data_memb = '';
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);

        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);
    
        $cnt++;

        // 會一直重覆蓋過，無所謂
        $data_memb = <<< HEREDOC
        <p>會員代號：{$membcode}</p>
        <p>會員姓名：{$membname}</p>
        <hr>
HEREDOC;

        $data .= <<< HEREDOC
        <tr>
            <th>{$cnt}</th>
            <td>{$formcode}</td>
            <td>{$formname}</td>
            <td>{$formdate}</td>
            <td>{$formfld1}</td>
            <td>{$formfld2}</td>
            <td>{$forminfo}</td>
            <th><a href="mform_display.php?formcode={$formcode}">詳細</a></th>
            <th><a href="mform_display_pdf.php?formcode={$formcode}">PDF</a></th>
            <th><a href="mform_display_qr.php?formcode={$formcode}">QR</a></th>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    {$data_memb}
    <h3>共有 {$total_rec} 筆記錄</h3>
    <table border="1" class="table">
        <tr>
            <th>順序</th>
            <th>代碼</th>
            <th>主旨</th>
            <th>日期</th>
            <th>欄一</th>
            <th>欄二</th>
            <th>更多</th>
            <th colspan="3">操作</th>
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
<h2>會員的申請表單一覽表</h2>
<p>時間：『{$yyyymm}』</p>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>