<?php

$html = <<< HEREDOC
你尚未登入系統，請<a href="login.php">按這裡</a>重新登入！
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>