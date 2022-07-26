<?php
$last_time = isset($_COOKIE["view_time"]) ? ($_COOKIE["view_time"]) : (time());

$allow_time = 5; // 設定在此時間內不會增加計數值 (單位為秒數)

// 儲存Cookie變數
setcookie("view_time", time(), time()+86400);

if( (time()-$last_time) <= $allow_time)
{
   $msg = '請不要一直按 Reload 灌水！';
}
else
{
   $msg = '歡迎你再次光臨！';
}


$html = <<<HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cookie應用：處理使用者不斷地Reload</title>
</head>
<body>
<p>{$msg}</p>
</body>
</html>
HEREDOC;

echo $html;
?>