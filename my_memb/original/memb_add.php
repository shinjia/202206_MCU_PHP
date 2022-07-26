<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

$html = <<< HEREDOC
<h2 align="center">新增資料區</h2>
<form action="memb_add_save.php" method="post">
    <p>帳號：<input type="text" name="membcode"></p>
    <p>姓名：<input type="text" name="membname"></p>
    <p>密碼：<input type="text" name="membpass"></p>
    <p>電話：<input type="text" name="membtele"></p>
    <p>信箱：<input type="text" name="membmail"></p>
    <p>資訊：<input type="text" name="membinfo"></p>
    <p>興趣：<input type="text" name="memblike"></p>
    <p>圖檔：<input type="text" name="membpict"></p>
    <p>圖集：<input type="text" name="membpset"></p>
    <p>類別：<input type="text" name="membtype"></p>
    <p>GoogleID：<input type="text" name="googleid"></p>
    <p>狀態：<input type="text" name="status"></p>
    <p>備註：<input type="text" name="remark"></p>
    <input type="submit" value="新增">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>