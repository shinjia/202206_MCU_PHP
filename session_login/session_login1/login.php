<?php
session_start();

$html = <<< HEREDOC
<h2>登入</h2>
<form name="form1" method="post" action="login_check.php">
帳號：<input type="text"     name="usercode" size="10"><br>
密碼：<input type="password" name="password" size="10">
<br><br>
用戶類型
<br><input type="radio" name="usertype" value="MEMBER">會員
<br><input type="radio" name="usertype" value="ADMIN">系統管理者
<p>
<input type="submit" value="登入">
</form>
<hr />
<p>注意：此範例之帳號可隨意填入，密碼則依用戶類型，請配合下列密碼測試</p>
『會員』請輸入密碼 11111<br />
『管理者』請輸入密碼 12345
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>