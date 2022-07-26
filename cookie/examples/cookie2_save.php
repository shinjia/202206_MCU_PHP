<?php
$name = isset($_POST["name"]) ? $_POST["name"] : "";
$mail = isset($_POST["mail"]) ? $_POST["mail"] : "";
$keep = isset($_POST["keep"]) ? $_POST["keep"] : "N";

if($keep=="Y")
{
   setcookie("name", $name, time()+86400*7);
   setcookie("mail", $mail, time()+86400*7);
   setcookie("keep", $keep, time()+86400*7);
   $str = '已設定好Cookie變數。<BR>';
   $str .= 'name=' . $name .'<BR>mail=' . $mail . '<BR>keep=' . $keep;
}
else
{
   setcookie("name");
   setcookie("mail");
   setcookie("keep");
   $str = 'Cookie變數設定已取消。';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cookie應用：記住我的資料</title>
</head>
<body>
<p>{$str}</p>
<BR><BR><a href="cookie2.php">回前一頁</a>
</body>
</html>
HEREDOC;

echo $html;
?>