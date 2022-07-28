<?php
/* my_form v0.1  @Shinjia  #2022/07/28 */
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

//網頁顯示
$html = <<< HEREDOC
<h2>檔案上傳</h2>
<form name="form1" method="post" action="edit_photo_save.php" enctype="multipart/form-data"> 
    <input type="hidden" name="MAX_FILE_SIZE" value="500000"> 
    檔案：<input type="file" name="file"><br>
    <input type="submit" value="上傳">
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>