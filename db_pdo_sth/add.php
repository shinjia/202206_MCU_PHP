<?php

$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="add_save.php" method="post">
<table>
   <tr><th>代碼</th><td><input type="text" name="usercode" value=''></td></tr>
   <tr><th>姓名</th><td><input type="text" name="username" value=''></td></tr>
   <tr><th>地址</th><td><input type="text" name="address"  value=''></td></tr>
   <tr><th>生日</th><td><input type="text" name="birthday" value=''></td></tr>
   <tr><th>身高</th><td><input type="text" name="height"   value=''></td></tr>
   <tr><th>體重</th><td><input type="text" name="weight"   value=''></td></tr>
   <tr><th>備註</th><td><input type="text" name="remark"   value=''></td></tr>
</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>