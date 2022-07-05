<?php

$num = mt_rand(1, 42);
$pic = 'images/' . $num . '.jpg';

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>
<body>
<h1>你的幸運數字</h1>
<p><img src="{$pic}"></p>
<p><a href="?">再執行一次</a></p>
</body>
</html>
HEREDOC;

echo $html;
?>