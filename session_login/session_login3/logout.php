<?php
session_start();

include 'define.php';

unset($_SESSION[SYSTEM_CODE.'usertype']);
unset($_SESSION[SYSTEM_CODE.'usercode']);


$html = <<< HEREDOC
<p>已登出</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>