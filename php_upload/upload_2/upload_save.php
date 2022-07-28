<?php
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
$allow_ext = array('jpg', 'gif', 'png');  // 設定可接受上傳的檔案類型
$allow_size = 500 * 1024;  // 限制接受的檔案大小 (此處設定為 500K)
$allow_overwrite = true;   // 限制不能覆蓋相同檔名 (若接受，則相同檔名時會覆蓋舊檔)

$path = '../file/';  // 指定存檔的資料夾

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
$save_filename = $path . $file_name;
//$save_filename = iconv('utf-8', 'big5', $save_filename);   // 處理中文檔名時需轉換
//$save_filename = mb_convert_encoding($save_filename,'big5', 'utf-8');   // 改用 mb_convert_encoding() 較佳

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


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
</head>
<body>
<p><a href="upload_input.php">回前頁</a></p>
<h2>檔案上傳結果</h2>
<p>{$msg}</p>
</body>
</html>
HEREDOC;

echo $html;
?>