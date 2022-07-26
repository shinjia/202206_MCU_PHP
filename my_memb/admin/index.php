<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

$html = <<< HEREDOC
<h2>資料管理系統 my_form v0.1</h2>
<h3>程式執行</h3>
<p><a href="memb_list_page.php">列表 (分頁) memb_list_page</a></p>
<p><a href="form_list_page.php">列表 (分頁) form_list_page</a></p>

HEREDOC;


include 'pagemake.php';
pagemake($html);
?>