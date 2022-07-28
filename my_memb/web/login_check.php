<?php
/* my_form v0.1  @Shinjia  #2022/07/26 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

$msg_login = '';
$msg_status = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb WHERE membcode=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $usercode, PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();
    
    $valid = false;

    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $membcode = $row['membcode'];
        $membname = html_encode($row['membname']);
        $membpass = $row['membpass'];
        $membtype = $row['membtype'];
        $status = $row['status'];

        $password_encrypt = md5(DEF_PASSWORD_PREFIX . $password);  // 加密
        if($membpass==$password_encrypt) {
            $a_membtype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);
            if(in_array($membtype,  $a_membtype)) {
                $valid = true;
                $msg_login = 'Hi, <span style="color:red;">' . $membname . '</span>';                
                $msg_login = '已成功登入';
            }
            else {
                $msg_login = '會員資格不符合';
            }
        }
        else {
            $msg_login = '密碼錯誤';
        }

    }
    else {
        $msg_login = '無此會員帳號';
    }
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

// 權限是否通過
if($valid){
    $_SESSION[DEF_SESSION_USERTYPE] = $membtype;
    $_SESSION[DEF_SESSION_USERCODE] = $membcode;

    // 新增加功能：記錄會員登入次數及上次登入時間

    // Step1: 讀出資料
    // 最好能夠加上 status 格式的正確檢查
    if(empty($status)) {
        // 之前無記錄，則設定為初始值
        $status = '{"login_count":"0", "login_last":"無記錄"}';
    }

    // Step2: 轉為變數，進行處理
    $ary = json_decode($status, true);

    $login_count = $ary['login_count'] + 1;
    $login_last  = $ary['login_last'];

    $msg_status .= '第 ' . $login_count . ' 次登入系統';
    if($login_count>1) {
        $msg_status .= '；上次登入時間是 ' . date('Y/m/d H:i:s', $login_last);
    }

    // Step3: 寫入資料庫
    $ary['login_count'] = $login_count;
    $ary['login_last'] = time();
    $str_status = json_encode($ary);

    // SQL 語法
    $sqlstr = "UPDATE memb SET status=:status ";
    $sqlstr .=" WHERE membcode=:membcode ";

    $sth = $pdo->prepare($sqlstr);
    $sth->bindParam(':status', $str_status, PDO::PARAM_STR);
    $sth->bindParam(':membcode', $membcode, PDO::PARAM_STR);

    // 執行 SQL
    try { 
        $sth->execute();
        $count = $sth->rowCount();
    }
    catch(PDOException $e) { 
        // db_error(ERROR_QUERY, $e->getMessage());
        $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    }
}
else {
    $_SESSION[DEF_SESSION_USERTYPE] = '';
    $_SESSION[DEF_SESSION_USERCODE] = '';
}

db_close();

$ihc_content = '<p>' . $msg_login . '</p>';
$ihc_content .= '<p>' . $msg_status . '</p>';

// 因為後來加上了寫入資料庫的功能，所以這一頁應該要改成重導到別的頁面

// 網頁內容
$html = <<< HEREDOC
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>