<?php
session_start();

$_SESSION['usertype'] = '';
$_SESSION['usercode'] = '';




$html = <<< HEREDOC
已登出
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>