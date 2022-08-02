<?php
/* my_form v0.1  @Shinjia  #2022/07/30 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

/*
formcode, formdata, membcode 都是由系統產生，在下一個程式產生
*/

$html = <<< HEREDOC
<h2 align="center">表單申請</h2>
<p>※網頁美工有必要，讓此頁面明顯是表單※</p>
<form action="mform_add_save.php" method="post">
    <p>主旨：<input type="text" name="formname"></p>
    <p>欄一：<input type="text" name="formfld1"></p>
    <p>欄二：<input type="text" name="formfld2"></p>
    <p>更多：<input type="text" name="forminfo"></p>
    <input type="submit" value="新增">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>