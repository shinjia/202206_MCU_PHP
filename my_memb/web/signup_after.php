<?php
/* my_form v0.1  @Shinjia  #2022/07/26 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// 接收傳入變數
$status = isset($_GET['status']) ? $_GET['status'] : '';
$chk = isset($_GET['chk']) ? $_GET['chk'] : '';


if($chk!=md5(SYSTEM_CODE.$status)) {
    $msg = '不合法的連結';
}
else {
    switch($status) {
        case 0: $msg = '未通過任何程序'; break;
        case 1: $msg = '此帳號已存在，請用新帳號重新申請'; break;
        case 2: $msg = '處理申請中，已寄出驗証信'; break;
        case 3: $msg = '處理申請中，發生錯誤，驗証信無法寄出'; break;
        default: $msg = '未知的錯誤發生';
    }
}


$html = <<<HERDOC
<h2>會員申請</h2>
<p>{$msg}</p>
HERDOC;

include 'pagemake.php';
pagemake($html);
?>