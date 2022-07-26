<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[SYSTEM_CODE.'usertype']) ? $_SESSION[SYSTEM_CODE.'usertype'] : '';
$ss_usercode = isset($_SESSION[SYSTEM_CODE.'usercode']) ? $_SESSION[SYSTEM_CODE.'usercode'] : '';

if($ss_usertype!=DEF_LOGIN_ADMIN)
{
    header('Location: login_error.php');
    exit;
}



$html = <<< HEREDOC
<h2 align="center">新增資料區</h2>
<form action="form_add_save.php" method="post">
    <p>代碼：<input type="text" name="formcode"></p>
    <p>主旨：<input type="text" name="formname"></p>
    <p>日期：<input type="text" name="formdate"></p>
    <p>欄一：<input type="text" name="formfld1"></p>
    <p>欄二：<input type="text" name="formfld2"></p>
    <p>更多：<input type="text" name="forminfo"></p>
    <p>會員代號：<input type="text" name="membcode"></p>
    <p>備註：<input type="text" name="remark"></p>
    <input type="submit" value="新增">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>