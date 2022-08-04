<?php

$html = <<< HEREDOC
<h1>資料管理系統─SQLite3版本</h1>
<p><a href="list_page.php">db 分頁列表</a></p>
<HR>
<p><a href="install.php">安裝</a></p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>