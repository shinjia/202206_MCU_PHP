<?php
/* db2_pdo_cookie v1.0  @Shinjia  #2022/07/22 */

// 網頁連結
// $lnk_list = 'list_page.php';
$lnk_list = 'list_find.php';

$html = <<< HEREDOC
<h2 align="center">新增資料區</h2>
<button onclick="location.href='{$lnk_list}';">返回列表</button>
<form action="add_save.php" method="post">
    <p>代碼：<input type="text" name="usercode"></p>
    <p>姓名：<input type="text" name="username"></p>
    <p>地址：<input type="text" name="address"></p>
    <p>生日：<input type="text" name="birthday"></p>
    <p>身高：<input type="text" name="height"></p>
    <p>體重：<input type="text" name="weight"></p>
    <p>備註：<input type="text" name="remark"></p>
    <input type="submit" value="新增">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>