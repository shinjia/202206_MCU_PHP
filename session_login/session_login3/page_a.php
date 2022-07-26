<?php
session_start();


$html = <<< HEREDOC
<h2>所有的人</h2>
<p>所有用戶均能開啟這支程式</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>