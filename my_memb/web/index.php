<?php

$html = <<< HEREDOC
<h1>程式測試</h2>

<ul>
    <li><a href="signup.php">signup.php 申請會員</a></li>
    <li></li>
    <li></li>
</ul>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>