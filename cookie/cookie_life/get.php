<?php

$cc_testdata = isset($_COOKIE['testdata']) ? $_COOKIE['testdata'] : 'None';

$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h3>Cookie (Root)</h3>
<p>取得 cookie 值為 <span style="color:#FF0000;">{$cc_testdata}</span></p>
</body>
</html>
HEREDOC;

echo $html;
?>