<?php


$html = <<< HEREDOC
登入 
<form name="form1" method="post" action="login_check.php">
帳號：<input type="text"     name="usercode" size="10" value="allen"><br>
密碼：<input type="password" name="password" size="10" value="1234">
<br><br>
用戶類型
<br><input type="radio" name="usertype" value="">訪客
<br><input type="radio" name="usertype" value="MEMBER" checked>會員
<br><input type="radio" name="usertype" value="ADMIN">系統管理者
<p>
<input type="submit" value="登入">
</form>

HEREDOC;


include 'pagemake.php';
pagemake($html, '');
?>
