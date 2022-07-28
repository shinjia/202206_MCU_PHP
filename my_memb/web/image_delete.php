<?php
/* my_form v0.1  @Shinjia  #2022/07/27 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

include '../common/function.get_entry_in_dir.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

// 接收傳入變數
$file = isset($_GET['file']) ? $_GET['file'] : '';

// 指定照片的資料夾
$path = DEF_PHOTO_PATH;
$path_img = $path . $ss_usercode;

// 指定存檔的檔名
$file_img = $path_img . '/' . $file;

if(!empty($file_img) && file_exists($file_img)) {
    unlink($file_img);
}

$url = 'image_display.php';
header('Location: ' . $url);
?>