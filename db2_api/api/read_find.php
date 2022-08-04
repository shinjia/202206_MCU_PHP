<?php
include 'config.php';

$key = isset($_GET['key']) ? $_GET['key'] : '';
if(empty($key)) $key = 'asdfkjasdfsd(&*^(*&^&';

// 定義 API 傳回的 JSON 結構
$ary = array();
$ary['result'] = '';
$ary['total_rec'] = 0;
$ary['records'] = array();

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person ";
$sqlstr .= " WHERE username LIKE ? ";  // 依條件修改

$sth = $pdo->prepare($sqlstr);

$keyword = '%' . $key . '%';  // 注意 無法搜尋內含 _ 及 % 的資料 (如有需要，使用 ESCAPE 字句)

$sth->bindValue(1, $keyword, PDO::PARAM_STR);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $ary['total_rec'] = $total_rec;

    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $one_item = array(
            'uid'      => $row['uid'],
            'usercode' => $row['usercode'],
            'username' => $row['username'],
            'address'  => $row['address'],
            'birthday' => $row['birthday'],
            'height'   => $row['height'],
            'weight'   => $row['weight'],
            'remark'   => $row['remark']
        );
        
        array_push($ary['records'], $one_item);
    }
    $ary['result'] = 'ok';
}
else
{
    // 無法執行 query 指令時
    $ary['result'] = 'error';
}

// set response code - 200 OK
http_response_code(200);

// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

echo json_encode($ary);
?>