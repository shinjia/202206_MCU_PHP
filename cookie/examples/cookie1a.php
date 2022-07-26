<?php
$p = isset($_COOKIE["visited"]) ? $_COOKIE["visited"] : (0);
$p = $p + 1;
setcookie("visited", $p);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cookie應用：到訪網站的次數</title>
</head>
<body>
<p>你是第 {$p} 次光臨本網站</p>
</body>
</html>
HEREDOC;

echo $html;
?>