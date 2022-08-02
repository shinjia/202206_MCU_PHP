<?php
/* my_form v0.1  @Shinjia  #2022/07/31 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// 接收傳入變數
$formcode = isset($_GET['formcode']) ? $_GET['formcode'] : '';
$ts = isset($_GET['ts']) ? $_GET['ts'] : '';
$chk = isset($_GET['chk']) ? $_GET['chk'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

$data = '';

// 檢查是否合法連結
$chk_input = md5(SYSTEM_CODE.$formcode.$ts);
$sec_available = 60;  // 此處假設僅60秒有效

if(time()-$ts > $sec_available) {
    $data = '時效已過時';
}
elseif($chk_input!=$chk) {
    $data = '不合法的連結';
}
else {

    // 連接資料庫
    $pdo = db_open();

    // SQL 語法
    $sqlstr = "SELECT * FROM mform_vw ";
    $sqlstr .= "WHERE formcode=? ";

    $sth = $pdo->prepare($sqlstr);
    $sth->bindValue(1, $formcode, PDO::PARAM_STR);

    // 執行 SQL
    try {
        $sth->execute();
        
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $membcode = html_encode($row['membcode']);
            $membname = html_encode($row['membname']);
            $formcode = html_encode($row['formcode']);
            $formname = html_encode($row['formname']);
            $formdate = html_encode($row['formdate']);
            $formfld1 = html_encode($row['formfld1']);
            $formfld2 = html_encode($row['formfld2']);
            $forminfo = html_encode($row['forminfo']);

            // 
            $str_ts1 = date('Y-m-d H:i:s', $ts);
            $str_ts2 = date('Y-m-d H:i:s', $ts+$sec_available);

            $data = <<< HEREDOC
            <h3>已合法申請，通過驗証</h3>
            <p>
                申請時間：{$str_ts1}<br>
                有效時間：{$str_ts2}
            </p>
            <p>
                會員代號：{$membcode}<br>
                會員姓名：{$membname}
            </p>
            <hr>
            <table border="1" class="table">
                <tr><th>代碼</th><td>{$formcode}</td></tr>
                <tr><th>主旨</th><td>{$formname}</td></tr>
                <tr><th>日期</th><td>{$formdate}</td></tr>
                <tr><th>欄一</th><td>{$formfld1}</td></tr>
                <tr><th>欄二</th><td>{$formfld2}</td></tr>
                <tr><th>更多</th><td>{$forminfo}</td></tr>
            </table>
HEREDOC;
        }
        else {
            $data = '<p class="center">查不到相關記錄！</p>';
        }
    }
    catch(PDOException $e) {
        // db_error(ERROR_QUERY, $e->getMessage());
        $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
    }

    db_close();
}


// 網頁內容
$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>會員表單申請</h2>
{$data}
{$ihc_error}    
</body>
</html>
HEREDOC;

echo $html;
?>