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
    $data = '';
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

        $data .= <<< HEREDOC
        <tr onclick="show_detail('{$uid}');" style="cursor:pointer;" class="omout" onmouseover="this.className='omover'" onmouseout="this.className='omout'">
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$username}</td>
        </tr>
HEREDOC;
    }

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>地區在『{$address}』</h3>
    <table border="1" class="table">
        <tr>
            <th>序號</th>
            <th>uid</th>
            <th>姓名</th>
        </tr>
        {$data}
    </table>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
}
catch(PDOException $e) {
    db_error(ERROR_QUERY, $e->getMessage());
}

db_close();

echo $ihc_content;
?>