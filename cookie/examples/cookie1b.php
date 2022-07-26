<?php
$p = isset($_COOKIE["visited"]) ? ($_COOKIE["visited"]) : (0);
$d = isset($_COOKIE["visited_time"]) ? ($_COOKIE["visited_time"]) : (time());

$p = $p + 1;

// 儲存Cookie變數
setcookie("visited", $p, time()+86400);   // 保存一天
setcookie("visited_time", time(), mktime(0,0,0,12,31,2018));

$d_str = date("Y-m-d H:i:s", $d);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cookie應用：到訪網站的次數及上次時間</title>
</head>
<body>
<p>你是第{$p}次光臨本網頁，上次是{$d_str}進入</p>
</body>
</html>
HEREDOC;

echo $html;
?>