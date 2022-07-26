<?php

$value = isset($_POST['value']) ? $_POST['value'] : '';
$delay = isset($_POST['delay']) ? $_POST['delay'] : '';

setcookie('testdata', $value, time()+$delay);

$msg = '已設定！';

$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sys_A</title>
</head>
<body>
<h3>Cookie (sys_A)</h3>
<p>{$msg}</p>
</body>
</html>
HEREDOC;

echo $html;
?>