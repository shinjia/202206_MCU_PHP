<?php

function pagemake($content, $head='')
{
$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SESSION_LOGIN 2</title>
    <style>
        h1 { background: #FFCC00; color:#FF0000; border-bottom: 6px solid #DD7700; }
    </style>
</head>
<body>
<h1>登入登出權限控制範例 (2)</h1>
<button onclick="location.href='index.php';">回首頁</button>
<hr />
{$content}
</body>
</html>
HEREDOC;

echo $html;
}

?>