<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$uid = $_GET["uid"] + 0;


$html = <<< HEREDOC
<h2>圖檔上傳</h2>
<form method="post" action="prod_upload_save.php" enctype="multipart/form-data">
  檔案：<input type="file" name="file">

  <p>
    <input type="hidden" name="uid" value="{$uid}">
  <input type="submit" value="上傳">
  </p>
</form>
HEREDOC;


include 'pagemake.php';
pagemake($html);
?>