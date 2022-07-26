<?php

$html = <<< HEREDOC
<h2>登入</h2>
<form method="post" action="login_check.php">
帳號：<input type="text"     name="usercode" size="10"><br>
密碼：<input type="password" name="password" size="10"><br>
<br>
<input type="submit" value="登入">
</form>
<hr>
<p>注意：此範例之帳號及密碼定義在『user_password.txt』內，請自行更改及測試</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>