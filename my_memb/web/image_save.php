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

ini_set('memory_limit', '64M');

// 指定照片的資料夾
$path = DEF_PHOTO_PATH;
$path_img = $path . $ss_usercode;

$a_file = $_FILES['file'];  // 上傳的檔案內容

// 確認資料夾是否存在，若無則要建立
if(!is_dir($path_img)) {
    mkdir($path_img);
    chmod($path_img, 0777);
}


// 系統設定的錯誤訊息
$upload_errors = array(
    0 => '檔案大小為零，無法上傳',
    UPLOAD_ERR_INI_SIZE   => '上傳檔案大小超過系統限制。',
    UPLOAD_ERR_FORM_SIZE  => '上傳檔案大小超過HTML表單限制。',
    UPLOAD_ERR_PARTIAL    => '檔案上傳不完整。',
    UPLOAD_ERR_NO_FILE    => '沒有選擇檔案上傳。',
    UPLOAD_ERR_NO_TMP_DIR => '沒有暫存資料夾，請通知管理員。',
    UPLOAD_ERR_CANT_WRITE => '檔案無法寫入磁碟，請通知管理員。',
    UPLOAD_ERR_EXTENSION  => '因副檔名限制無法上傳，請通知管理員。',
);

// 管理者自訂的上傳規則
$allow_ext = array('jpg', 'png', 'zip');  // 設定可接受上傳的檔案類型
$allow_size = 20000 * 1024;  // 限制接受的檔案大小 (此處設定為 20000K)
$allow_overwrite = true;   // 限制不能覆蓋相同檔名 (若接受，則相同檔名時會覆蓋舊檔)


// 判斷能否存入，若無則建立新的資料夾及新檔案
$path_chk = '.';
$a_path = explode('/', $path_img);
foreach($a_path as $one) {
    $path_chk .= '/' . $one;
}


// 上傳檔案處理
$msg = '';
$check_ok = true;
$total = count($a_file['name']);
$msg .= '一共選擇了 ' . $total . '個檔案<br>'; 
for($i=0; $i<$total; $i++) {    
    // 實際上傳的檔案資料
    $file_name  = $a_file['name'][$i];
    $tmp=explode(".", $a_file['name'][$i]);
    $file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
    $file_size  = $a_file['size'][$i];    // 檔案大小
    $file_type  = $a_file['type'][$i];
    $file_tmp   = $a_file['tmp_name'][$i];
    $file_error = $a_file['error'][$i];

    // 指定儲存的檔名
    $save_filename = $path_img . '/' . $file_name;
    // echo $save_filename . '<hr>';
    // $save_filename = iconv('utf-8', 'big5', $save_filename);   // 處理中文檔名時需轉換
    // $save_filename = mb_convert_encoding($save_filename, 'big5', 'utf-8');   // 改用 mb_convert_encoding() 較佳

    $msg .= '第 ' . ($i+1) . ' 個檔案：' . $file_name;
    $msg .= '<br>--->';

    if($file_error==UPLOAD_ERR_OK && $file_size>0) {  // 先確認有檔案傳上來後再做處理
        // 檢查副檔案是否可以接受
        if(!in_array(strtolower($file_ext), $allow_ext)) {
            $check_ok = false;
            $msg .= '(檔案類型不允許) ';
        }
        
        // 檢查是否已有相同檔案存在
        if (!$allow_overwrite) {
            if(file_exists($save_filename)) {
                $check_ok = false;
                $msg .= $file_name . '(檔案已存在，無法儲存) ';
            }
        }
            
        // 檢查檔案大小是否在限制之內 
        if($file_size > $allow_size) {
            $check_ok = false;
            $msg .= '(檔案大小超過限制) ';
        }
            
        // 檢查檔案是真地透過HTTP POST上傳
        if(!is_uploaded_file($file_tmp)) {
            $check_ok = false;
            $msg .= '(非此次上傳之檔案，無法處理) ';
        }
            
        // 檢查完畢，上傳的最後處理
        if($check_ok) {
            if (@move_uploaded_file($file_tmp, $save_filename)) {
                chmod($save_filename, 0777);
                // if(!file_exists($save_filename)) {
                //     //echo 'fail...' . $save_small ;
                //     //exit;
                // }
                $msg .= '上傳成功：' . $save_filename;
                
                // 如果是zip檔，解壓
                if($file_ext=='zip') {
                    // 檢查是否有安裝zip函式庫
                    if(get_extension_funcs('zip')) {
                        $z = zip_open($save_filename); // 開啟壓縮檔
                    
                        while($c=zip_read($z)) {
                            // 建立要解壓縮的檔案資料夾
                            $img_filename = $path_img . '/' . zip_entry_name($c);
                            $f=fopen($img_filename,"w");
                        
                            // 讀取zip檔案內的資料                            
                            $msg .= '<br>--->解壓 ';
                            if(zip_entry_open($z,$c,"r")) {
                                $msg .= '成功:' . zip_entry_name($c);
                                // 寫入檔案
                                $res = fwrite($f,zip_entry_read($c,zip_entry_filesize($c)));
                                zip_entry_close($c);
                            }
                            else {
                                $msg .= '失敗:' . $c;
                            }
                            fclose($f);
                        }
                        zip_close($z);
                    }
                    else {
                        die('沒有安裝ZIP函式庫...');
                    }
                    unlink($save_filename);  // 刪除 zip
                }
            }
            else {
                $msg .= '檔案上傳失敗：' . $save_filename;
            }
        }
    }
    else {
        $msg .= '錯誤……' . $file_error . '=>' . $upload_errors[$file_error];
    }
    $msg .= '<br><br>';  // 一筆處理結束
}  // end of for

// echo $msg; exit;
$url = 'image_display.php';
header('Location: ' . $url);
?>