<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

$html = <<< HEREDOC
<h2>會員申請</h2>
<form action="signup_save.php" method="post">
    <p>帳號：<input type="text" name="membcode"></p>
    <p>姓名：<input type="text" name="membname"></p>
    <p>信箱：<input type="text" name="membmail"></p>
    <input type="submit" value="申請">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>