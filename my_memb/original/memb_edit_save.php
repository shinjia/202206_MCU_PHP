<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// 接收傳入變數
$uid  = isset($_POST['uid'])  ? $_POST['uid'] : '';

$membcode = isset($_POST['membcode']) ? $_POST['membcode'] : '';
$membname = isset($_POST['membname']) ? $_POST['membname'] : '';
$membpass = isset($_POST['membpass']) ? $_POST['membpass'] : '';
$membtele = isset($_POST['membtele']) ? $_POST['membtele'] : '';
$membmail = isset($_POST['membmail']) ? $_POST['membmail'] : '';
$membinfo = isset($_POST['membinfo']) ? $_POST['membinfo'] : '';
$memblike = isset($_POST['memblike']) ? $_POST['memblike'] : '';
$membpict = isset($_POST['membpict']) ? $_POST['membpict'] : '';
$membpset = isset($_POST['membpset']) ? $_POST['membpset'] : '';
$membtype = isset($_POST['membtype']) ? $_POST['membtype'] : '';
$googleid = isset($_POST['googleid']) ? $_POST['googleid'] : '';
$status   = isset($_POST['status'])   ? $_POST['status']   : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE memb SET ";
$sqlstr .= "membcode=:membcode, ";
$sqlstr .= "membname=:membname, ";
$sqlstr .= "membpass=:membpass, ";
$sqlstr .= "membtele=:membtele, ";
$sqlstr .= "membmail=:membmail, ";
$sqlstr .= "membinfo=:membinfo, ";
$sqlstr .= "memblike=:memblike, ";
$sqlstr .= "membpict=:membpict, ";
$sqlstr .= "membpset=:membpset, ";
$sqlstr .= "membtype=:membtype, ";
$sqlstr .= "googleid=:googleid, ";
$sqlstr .= "status=:status, ";
$sqlstr .= "remark=:remark ";
$sqlstr .=" WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':membcode', $membcode, PDO::PARAM_STR);
$sth->bindParam(':membname', $membname, PDO::PARAM_STR);
$sth->bindParam(':membpass', $membpass, PDO::PARAM_STR);
$sth->bindParam(':membtele', $membtele, PDO::PARAM_STR);
$sth->bindParam(':membmail', $membmail, PDO::PARAM_STR);
$sth->bindParam(':membinfo', $membinfo, PDO::PARAM_STR);
$sth->bindParam(':memblike', $memblike, PDO::PARAM_STR);
$sth->bindParam(':membpict', $membpict, PDO::PARAM_STR);
$sth->bindParam(':membpset', $membpset, PDO::PARAM_STR);
$sth->bindParam(':membtype', $membtype, PDO::PARAM_STR);
$sth->bindParam(':googleid', $googleid, PDO::PARAM_STR);
$sth->bindParam(':status'  , $status  , PDO::PARAM_STR);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);

// 執行 SQL
try { 
   $sth->execute();

   $lnk_display = "memb_display.php?uid=" . $uid;
   header('Location: ' . $lnk_display);
}
catch(PDOException $e) {  // db_error(ERROR_QUERY, $e->getMessage());
   $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
   
   $html = <<< HEREDOC
   {$ihc_error}
HEREDOC;
   include 'pagemake.php';
   pagemake($html);
}

db_close();
?>