<?php
$cc_name = isset($_COOKIE["name"]) ? $_COOKIE["name"] : "";
$cc_mail = isset($_COOKIE["mail"]) ? $_COOKIE["mail"] : "";
$cc_keep = isset($_COOKIE["keep"]) ? $_COOKIE["keep"] : "";

$check_str = ($cc_keep=="Y") ? "checked " : "";


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cookie應用：記住我的資料</title>
</head>
<body>
<form method="post" action="cookie2_save.php">
姓名：<input type="text" name="name" value="{$cc_name}"><BR>
信箱：<input type="text" name="mail" value="{$cc_mail}"><BR>
記住我的資料 <input type="checkbox" name="keep" value="Y" {$check_str}><BR>
<input type="submit">
</form>
</body>
</html>
HEREDOC;

echo $html;
?>