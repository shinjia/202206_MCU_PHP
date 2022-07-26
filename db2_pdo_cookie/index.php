<?php
/* db2_pdo_cookie v1.0  @Shinjia  #2022/07/22 */

// 寫入 COOKIE
setcookie('page', 1, time()+86400*7);
// numpp 不重設
setcookie('key', '', time()+86400*7);
setcookie('uid', 0, time()+86400*7);


$html = <<< HEREDOC
<h2>資料管理系統 db2_pdo_cookie v1.0</h2>

<h3>系統入口</h3>
<div style="border: 2px solid orange; background-color:#FFFFAA; padding:10px; margin: 20px;">
<form action="list_find.php" method="post">
    <p>
        查詢名字 (內含文字)：<input type="text" name="key">
        <input type="submit" value="查詢">
    </p>
</form>
</div>
</hr>

<h3>原有的測試</h3>
<ul>
    <li><a href="list_page.php">列表 (分頁) list_page</a></li>
    <li><a href="list_all.php">列表 (全部) list_all</a></li>
    <li>------------------------------</li>
    <li><a href="find.php">查詢姓名 (全部顯示版本)</a></li>
    <li><a href="findp.php">查詢姓名 (分頁顯示版本) ***最主要入口***</a></li>
</ul>

<h3>安裝程式</h3>
<ul>
    <li><a href="install.php">安裝資料庫或資料表</a></li>
</ul>
HEREDOC;


include 'pagemake.php';
pagemake($html);
?>