<?php
include 'config.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM person ";
$sqlstr .= "WHERE address=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $code, PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '<select id="username" onchange="show_detail();">';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $usercode = $row['usercode'];
        $username = $row['username'];
        $address  = $row['address'];
        $birthday = $row['birthday'];
        $height   = $row['height'];
        $weight   = $row['weight'];
        $remark   = $row['remark'];
    
        $cnt++;

        $data .= '<option value="' . $uid . '">(' . $uid . ') ' . $username . '</option>';
    }
    $data .= '</select>';

    // 找不到資料時
    if($total_rec==0) { $data = '<select></select>'; }

    //網頁顯示
    $ihc_content = $data;
}
catch(PDOException $e) {
    db_error(ERROR_QUERY, $e->getMessage());
}

db_close();

echo $ihc_content;
?>