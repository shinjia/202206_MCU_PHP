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

// Part1: 上傳檔案儲存 (注意檔名有規定)

$a_file = $_FILES['file'];  // 上傳的檔案內容

// 系統設定的錯誤訊息
$upload_errors = array(
    UPLOAD_ERR_INI_SIZE   => '上傳檔案大小超過系統限制。',
    UPLOAD_ERR_FORM_SIZE  => '上傳檔案大小超過HTML表單限制。',
    UPLOAD_ERR_PARTIAL    => '檔案上傳不完整。',
    UPLOAD_ERR_NO_FILE    => '沒有選擇檔案上傳。',
    UPLOAD_ERR_NO_TMP_DIR => '沒有暫存資料夾，請通知管理員。',
    UPLOAD_ERR_CANT_WRITE => '檔案無法寫入磁碟，請通知管理員。',
    UPLOAD_ERR_EXTENSION  => '因副檔名限制無法上傳，請通知管理員。',
);

// 管理者自訂的上傳規則
$allow_ext = array('jpg', 'png', 'gif');  // 設定可接受上傳的檔案類型
$allow_size = 500 * 1024;  // 限制接受的檔案大小 (此處設定為 500K)
$allow_overwrite = true;   // 限制不能覆蓋相同檔名 (若接受，則相同檔名時會覆蓋舊檔)

// 指定照片的資料夾
$path = DEF_PHOTO_PATH;

// 判斷能否存入，若無則建立新的資料夾
if(!is_dir($path)) {
    mkdir($path);
}

// 實際上傳的檔案資料
$file_name  = $a_file['name'];
$tmp=explode(".", $a_file['name']);
$file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
$file_size  = $a_file['size'];    // 檔案大小
$file_type  = $a_file['type'];
$file_tmp   = $a_file['tmp_name'];
$file_error = $a_file['error'];

// 指定儲存的檔名
$photo_filename = $ss_usercode . '.' . $file_ext;  // 規定的檔名
$save_filename = $path . $photo_filename;

// 上傳檔案處理
$msg = '';
$check_ok = true;
if($file_error==UPLOAD_ERR_OK && $file_size>0) {  // 先確認有檔案傳上來後再做處理
    // 檢查副檔案是否可以接受
    if(!in_array(strtolower($file_ext), $allow_ext)) {
        $check_ok = false;
        $msg .= '不允許為此類型的檔案。<br>';
    }
    
    // 檢查是否已有相同檔案存在
    if (!$allow_overwrite) {
        if(file_exists($save_filename)) {
            $check_ok = false;
            $msg .= $file_name . ' 檔案已存在，無法儲存。<br>';
        }
    }
        
    // 檢查檔案大小是否在限制之內 
    if($file_size > $allow_size) {
        $check_ok = false;
            $msg .= '檔案大小超過限制。<br>';
    }
        
    // 檢查檔案是真地透過HTTP POST上傳
    if(!is_uploaded_file($file_tmp)) {
        $check_ok = false;
        $msg .= '非此次上傳之檔案，無法處理。<br>';
    }
        
    // 檢查完畢，上傳的最後處理
    if($check_ok) {
        if(@move_uploaded_file($file_tmp, $save_filename)) {
            $msg .= '檔案上傳成功：' . $file_name;
        }
        else {
            $msg .= '不明的原因，檔案上傳失敗。<br>';
        }
    }
}
else {
    $msg .= '錯誤……' . $file_error . "=>" . $upload_errors[$file_error];
}


// Part2: 修改資料欄位

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "UPDATE memb SET ";
$sqlstr .= "membpict=:membpict ";
$sqlstr .=" WHERE membcode=:membcode ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':membpict', $photo_filename, PDO::PARAM_STR);
$sth->bindParam(':membcode', $ss_usercode   , PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    $lnk_display = "display_data.php";
    header('Location: ' . $lnk_display);
}
catch(PDOException $e) { 
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    
    $html = <<< HEREDOC
    {$ihc_error}
HEREDOC;
    include 'pagemake.php';
    pagemake($html);
}

db_close();
?>