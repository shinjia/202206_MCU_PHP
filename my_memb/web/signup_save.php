<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// email 的設定應在系統 php.ini 中設定
ini_set('SMTP', SET_SMTP);
ini_set('smtp_port', SET_SMTP_PORT);
ini_set('sendmail_from', SET_SENDMAIL_FROM);

// 接收傳入變數
$membcode = isset($_POST['membcode']) ? $_POST['membcode'] : '';
$membname = isset($_POST['membname']) ? $_POST['membname'] : '';
$membmail = isset($_POST['membmail']) ? $_POST['membmail'] : '';

// 連接資料庫
$pdo = db_open();

// 變數設定
$status = 0;  
/* status 的幾種狀況
    0: 未進行任何程序
    1: 帳號已存在
    2: 已新增，寄出驗証信
    3: 無法寄出驗証信
    -1: 執行過程有錯
*/
$total_rec = 0;

// Part1: 查詢該帳號是否存在

// SQL 語法
$sqlstr = "SELECT * FROM memb ";
$sqlstr .= "WHERE membcode = ? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $membcode, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();
    $total_rec = $sth->rowCount();
}
catch(PDOException $e) {
    db_error(ERROR_QUERY, $e->getMessage());
    // $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

// Part2：新增記錄
if($total_rec>0) {
    // 帳號已存在，不能新增
    $status = 1;
}
else {
    // 新帳號，可以新增
    // SQL 語法
    $sqlstr = "INSERT INTO memb(membcode, membname, membmail, membtype) VALUES (:membcode, :membname, :membmail, :membtype)";
    
    $membtype = DEF_LOGIN_APPLY;  // 新申請
    
    $sth = $pdo->prepare($sqlstr);
    $sth->bindParam(':membcode', $membcode, PDO::PARAM_STR);
    $sth->bindParam(':membname', $membname, PDO::PARAM_STR);
    $sth->bindParam(':membmail', $membmail, PDO::PARAM_STR);
    $sth->bindParam(':membtype', $membtype, PDO::PARAM_STR);
    
    // 執行 SQL
    try { 
        $sth->execute();

        // Part3: 寄出確認信件
        $title = '網站會員申請驗証';
        $code = $membcode;
        $chk = md5(SYSTEM_CODE.$code);
        $link = URL_ROOT . 'web/signup_verify.php?code=' . $code . '&chk=' . $chk;

        $from = SET_SENDMAIL_FROM;

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        $message = <<< HEREDOC
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>my_memb_verify</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <p>Hi，{$membname}，</p>
            <p>歡迎您申請加入本網站，請點選下列連結進行帳號驗証：</p>
            <p><a href="{$link}">{$link}</a></p>
            <p>謝謝！</p>
        </body>
        </html>
HEREDOC;

        if(@mail($membmail, $title, $message, $headers)) {
            // 寄出信件
            $status = 2;
        }
        else {
            // 信件無法寄出
            $status = 3;
        }
    }
    catch(PDOException $e) {
        db_error(ERROR_QUERY, $e->getMessage());
        // $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    }
}

db_close();

// 依 $status 重導至新頁面
$lnk_after = "signup_after.php?status=" . $status . "&chk=" . md5(SYSTEM_CODE.$status);
header('Location: ' . $lnk_after);

?>