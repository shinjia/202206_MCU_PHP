<?php
session_start();

unset($_SESSION['usertype']);
unset($_SESSION['usercode']);


$html = <<< HEREDOC
<p>已登出</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>