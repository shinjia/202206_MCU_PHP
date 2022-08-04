<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

// 接受外部表單傳入之變數
$uid = (isset($_POST['uid'])) ? $_POST['uid']+0 : 0;
$a_file = $_FILES['file'];  // 上傳的檔案內容

$path = '../upload/';  // 指定存檔的資料夾

// 判斷能否存入，若無則建立新的資料夾
if(!is_dir($path))
{
   mkdir($path);
}

// 上傳檔案處理
$msg = '';
if($a_file["size"]>0)
{
   $save_filename = $path . $a_file["name"];  // 保留原來檔名
   $save_filename = iconv("utf-8", "big5", $save_filename);   // 處理中文檔名時需轉換

   move_uploaded_file($a_file["tmp_name"], $save_filename);
}
else
{
   $msg .= '檔案上傳不成功！';
}




// 連接資料庫
$pdo = db_open(); 


// 寫出 SQL 語法
$sqlstr = "UPDATE product SET picture=:picture WHERE uid=:uid " ;

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':picture', $a_file['name'], PDO::PARAM_STR);
$sth->bindParam(':uid', $uid, PDO::PARAM_INT);


// 執行SQL及處理結果
if($sth->execute())
{
   $url_display = 'prod_manage.php?op=DISPLAY&uid=' . $uid;
   header('Location: ' . $url_display);
}
else
{
   header('Location: error.php');
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
}
?>