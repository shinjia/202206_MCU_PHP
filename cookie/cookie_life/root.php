<?php


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Root</title>
    <style>
        body { background-color: #AA99FF; }
    </style>
</head>
<body>
<h2>Cookie (Root)</h2>
<p>
    <a href="get.php" target="myWin">get 取出查看</a> |
    <a href="set.php" target="myWin">set 設定</a>
</p>
<iframe name="myWin" src="" width="300" height="160"></iframe>

</body>
</html>
HEREDOC;

echo $html;
?>