<?php

function uid_encode($uid, $key='abc')
{
	return md5($uid.$key);
}

$chk1 = uid_encode(1);
$chk3 = uid_encode(3);
$chk5 = uid_encode(5);


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>無標題文件</title>
</head>

<body>
<p><a href="display.php?uid=1&chk={$chk1}">1</a></p>
<p><a href="display.php?uid=3&chk={$chk3}">3</a></p>
<p><a href="display.php?uid=5&chk={$chk5}">5</a></p>
<p>2 (沒有超連結，就是不想讓你看到)</p>
<p>4 (沒有超連結，就是不想讓你看到)</p>
</body>
</html>
HEREDOC;

echo $html;
?>