<?php
session_start();

include 'define.php';

$ss_usertype = isset($_SESSION[SYSTEM_CODE.'usertype']) ? $_SESSION[SYSTEM_CODE.'usertype'] : '';
$ss_usercode = isset($_SESSION[SYSTEM_CODE.'usercode']) ? $_SESSION[SYSTEM_CODE.'usercode'] : '';

if($ss_usertype!=DEF_LOGIN_ADMIN)
{
    header('Location: login_error.php');
    exit;
}


$html = <<< HEREDOC
<h2>系統管理者</h2>
<p>這一支程式只有『系統管理員』才能執行</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>