<?php
$style = isset($_POST["style"]) ? $_POST["style"] : "";

setcookie("style", $style, time()+86400*30);
$str = '已設定好Cookie變數，CSS=' . $style;

$file_css = "css/" . $style . ".css";


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="{$file_css}" type="text/css">
</head>
<body>
<p>{$str}</p>
<BR>
<a href="cookie3.php">回前一頁</a>
</body>
</html>
HEREDOC;

echo $html;
?>