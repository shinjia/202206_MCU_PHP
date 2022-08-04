<?php
include 'config.php';

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $usercode = $row['usercode'];
        $username = $row['username'];
        $address  = $row['address'];
        $birthday = $row['birthday'];
        $height   = $row['height'];
        $weight   = $row['weight'];
        $remark   = $row['remark'];

        $data = <<< HEREDOC
        <table border="0" class="table">
            <tr><th>代碼</th><td>{$usercode}</td></tr>
            <tr><th>姓名</th><td>{$username}</td></tr>
            <tr><th>地址</th><td>{$address}</td></tr>
            <tr><th>生日</th><td>{$birthday}</td></tr>
            <tr><th>身高</th><td>{$height}</td></tr>
            <tr><th>體重</th><td>{$weight}</td></tr>
            <tr><th>備註</th><td>{$remark}</td></tr>
        </table>
HEREDOC;
    }
    else {
        $data = '<p class="center">查不到相關記錄！</p>';
    }

    // 網頁內容
    $ihc_content = $data;
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


//網頁顯示
$html = <<< HEREDOC
{$ihc_content}
{$ihc_error}
HEREDOC;

echo $html;
?>