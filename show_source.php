<?php
$file = $_GET["file"];
$dir = $_GET["dir"];
$p = $dir . "/" . $file;
echo <<< HEREDOC
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Show Source</title>
</head>
<body>
HEREDOC;
show_source($p);
echo <<< HEREDOC
</body>
</html>
HEREDOC;
?>