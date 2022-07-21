<?php

$html = <<< HEREDOC

<div class="row">
  <div class="jumbotron">
	<h2>資料管理系統─PDO-STH版本</h2>
  </div>
</div>

<div class="row">
  <ul>
	<li><a href="list_page.php">分頁列表</a></li>
	<li><a href="manage.php?op=LIST_PAGE">分頁列表 (manage.php 全集中一支程式之寫法)</a></li>
	<hr />
	<li><a href="find.php">查詢姓名 (全部顯示版本)</a></li>
	<li><a href="findp.php">查詢姓名 (分頁顯示版本)</a></li>
	<li>------------------------------</li>
	<li><a href="install.php">安裝資料庫或資料表</a></li>
  </ul>
</div>
HEREDOC;


include 'pagemake.php';
pagemake($html, '');
?>