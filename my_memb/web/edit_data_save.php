<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */
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
$membname = isset($_POST['membname']) ? $_POST['membname'] : '';
$membtele = isset($_POST['membtele']) ? $_POST['membtele'] : '';
$membmail = isset($_POST['membmail']) ? $_POST['membmail'] : '';
$membinfo = isset($_POST['membinfo']) ? $_POST['membinfo'] : '';
$memblike = isset($_POST['memblike']) ? $_POST['memblike'] : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark'] : '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE memb SET ";
$sqlstr .= "membname=:membname, ";
$sqlstr .= "membtele=:membtele, ";
$sqlstr .= "membmail=:membmail, ";
$sqlstr .= "membinfo=:membinfo, ";
$sqlstr .= "memblike=:memblike, ";
$sqlstr .= "remark=:remark ";
$sqlstr .=" WHERE membcode=:membcode ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':membname', $membname, PDO::PARAM_STR);
$sth->bindParam(':membtele', $membtele, PDO::PARAM_STR);
$sth->bindParam(':membmail', $membmail, PDO::PARAM_STR);
$sth->bindParam(':membinfo', $membinfo, PDO::PARAM_STR);
$sth->bindParam(':memblike', $memblike, PDO::PARAM_STR);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':membcode', $ss_usercode, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    $lnk_display = "display_data.php";
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