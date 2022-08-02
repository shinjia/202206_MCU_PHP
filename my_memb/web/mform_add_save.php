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
$formname = isset($_POST['formname']) ? $_POST['formname'] : '';
$formfld1 = isset($_POST['formfld1']) ? $_POST['formfld1'] : '';
$formfld2 = isset($_POST['formfld2']) ? $_POST['formfld2'] : '';
$forminfo = isset($_POST['forminfo']) ? $_POST['forminfo'] : '';

// 連接資料庫
$pdo = db_open();


// Part1: 表單代碼必須先查詢舊資料，才能給出新代碼
// formcode, formdata, membcode 都是由系統產生

// SQL 語法'
$yyyymm = date('Ym', time());
$sqlstr = "SELECT MAX(formcode) AS fcode FROM form ";
$sqlstr .= "WHERE SUBSTR(formcode,1,6)='$yyyymm' ";

// 執行 SQL
try {
    $sth = $pdo->query($sqlstr);
    $total_rec = $sth->rowCount();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $fcode = html_encode($row['fcode']);
        $num = intval($fcode) + 1;
        $num = substr('0000'.$num, -4, 4);
    }
    else {
        $num = '0001';
    }
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

$new_fcode = $yyyymm . $num;  // 取得新的表單代碼

$formcode = $new_fcode;
$formdate = date('Y-m-d', time());
$membcode = $ss_usercode;
$remark   = '';

// Part2: 新增
// SQL 語法
$sqlstr = "INSERT INTO form(formcode, formname, formdate, formfld1, formfld2, forminfo, membcode, remark) VALUES (:formcode, :formname, :formdate, :formfld1, :formfld2, :forminfo, :membcode, :remark)";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':formcode', $formcode, PDO::PARAM_STR);
$sth->bindParam(':formname', $formname, PDO::PARAM_STR);
$sth->bindParam(':formdate', $formdate, PDO::PARAM_STR);
$sth->bindParam(':formfld1', $formfld1, PDO::PARAM_STR);
$sth->bindParam(':formfld2', $formfld2, PDO::PARAM_STR);
$sth->bindParam(':forminfo', $forminfo, PDO::PARAM_STR);
$sth->bindParam(':membcode', $membcode, PDO::PARAM_STR);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();

    $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
    $lnk_display = "mform_display.php?formcode=" . $formcode;
    header('Location: ' . $lnk_display);
}
catch(PDOException $e) {
   // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    
    $html = <<< HEREDOC
    {$ihc_error}
HEREDOC;
    include 'pagemake.php';
    pagemake($html);
}

db_close();

?>