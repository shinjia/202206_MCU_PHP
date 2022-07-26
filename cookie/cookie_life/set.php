<?php


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
<form method="post" action="set_save.php">
<p>
設定值：<input type="text" name="value" size="10"><br>
有效時間：<input type="text" name="delay" size="10" value="10">(秒)
<br>
<input type="submit" value="送出"></p>
</form>

</body>
</html>
HEREDOC;

echo $html;
?>