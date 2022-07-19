<?php
/* db2_pdo v1.0  @Shinjia  #2022/07/19 */

$html = <<< HEREDOC
<h2>資料管理系統 db_pdo2 v1.0</h2>

<p><a href="list_page.php">列表 (分頁) list_page</a></p>
<p><a href="list_all.php">列表 (全部) list_all</a></p>
<hr/>
<p><a href="find.php">查詢姓名 (全部顯示版本)</a></p>
<p><a href="findp.php">查詢姓名 (分頁顯示版本)</a></p>
<hr>
<p><a href="install.php">安裝資料庫或資料表</a></p>
HEREDOC;


include 'pagemake.php';
pagemake($html);
?>