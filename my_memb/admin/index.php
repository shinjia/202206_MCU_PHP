<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

$html = <<< HEREDOC
<h2>資料管理系統 my_form v0.1</h2>
<h3>程式執行</h3>
<ul>
    <li><a href="memb_list_page.php">列表 (分頁) memb_list_page</a></li>
    <li><a href="form_list_page.php">列表 (分頁) form_list_page</a></li>
    <li></li>
    <li><a href="memb_list_by_like.php?key=運動">查詢某項興趣 (GET) memb_list_by_like.php?key=</a></li>
    <li><a href="memb_list_all_like.php">查詢所有興趣 memb_list_all_like.php</a></li>
</ul>

HEREDOC;


include 'pagemake.php';
pagemake($html);
?>