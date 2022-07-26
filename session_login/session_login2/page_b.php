<?php
session_start();

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';

if($ss_usertype!='MEMBER')
{
    header('Location: login_error.php');
    exit;
}


$html = <<< HEREDOC
<h2>會員獨享</h2>
<p>這一支程式只有『會員』才能執行</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>