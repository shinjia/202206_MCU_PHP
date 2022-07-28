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
$formcode = isset($_POST['formcode']) ? $_POST['formcode'] : '';
$formname = isset($_POST['formname']) ? $_POST['formname'] : '';
$formdate = isset($_POST['formdate']) ? $_POST['formdate'] : '';
$formfld1 = isset($_POST['formfld1']) ? $_POST['formfld1'] : '';
$formfld2 = isset($_POST['formfld2']) ? $_POST['formfld2'] : '';
$forminfo = isset($_POST['forminfo']) ? $_POST['forminfo'] : '';
$membcode = isset($_POST['membcode']) ? $_POST['membcode'] : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$pdo = db_open();

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
    $lnk_display = "form_display.php?uid=" . $new_uid;
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