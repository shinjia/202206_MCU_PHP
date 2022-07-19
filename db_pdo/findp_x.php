<?php
/* db_pdo v1.0  @Shinjia  #2022/07/17 */

// 含分頁之資料列表

include 'config.php';
include 'utility.php';

// 可接收 GET 及 POST 傳入
$key = isset($_POST['key']) ? $_POST['key'] : (isset($_GET['key'])?$_GET['key']:'^$!@#');

// 頁碼參數
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$nump = isset($_GET['nump']) ? $_GET['nump'] : 10;   // 每頁的筆數

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;
$total_page = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法：條件
$sql_where = " WHERE username LIKE ? ";  // 依條件修改
$keyword = '%' . $key . '%';  // 注意

// SQL 語法：取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM person ";
$sqlstr .= $sql_where;

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $keyword, PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $total_rec = $row["total_rec"];
    }
    $total_page = ceil($total_rec / $nump);  // 計算總頁數
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message(ERROR_QUERY, $e->getMessage());
}

// SQL 語法：分頁資訊
$sqlstr = "SELECT * FROM person ";
$sqlstr .= $sql_where;
$sqlstr .= " LIMIT " . (($page-1)*$nump) . "," . $nump;

$sth = $pdo->prepare($sqlstr);

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $keyword, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    $cnt = (($page-1)*$nump);  // 注意分頁的起始順序
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $usercode = html_encode($row['usercode']);
        $username = html_encode($row['username']);
        $address  = html_encode($row['address']);
        $birthday = html_encode($row['birthday']);
        $height   = html_encode($row['height']);
        $weight   = html_encode($row['weight']);
        $remark   = html_encode($row['remark']);
    
        $cnt++;

        // 超連結
        $lnk_display = 'display.php?uid=' . $uid;
        $lnk_edit = 'edit.php?uid=' . $uid;
        $lnk_delete = 'delete.php?uid=' . $uid;

        $data .= <<< HEREDOC
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$usercode}</td>
            <td>{$username}</td>
            <td>{$address}</td>
            <td>{$birthday}</td>
            <td>{$height}</td>
            <td>{$weight}</td>
            <td>{$remark}</td>
            <td><a href="{$lnk_display}">詳細</a></td>
            <td><a href="{$lnk_edit}">修改</a></td>
            <td><a href="{$lnk_delete}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
        </tr>
HEREDOC;
    }

    // 分頁導覽列
    $a_ext = array(
        "key"=>$key
    );
    $ihc_navigator = pagination_ext($total_page, $page, $nump, $a_ext);
    
    //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 $total_rec 筆記錄</h2>
    {$ihc_navigator}
    <table border="1" class="table">   
        <tr>
            <th>順序</th>
            <th>uid</th>
            <th>代碼</th>
            <th>姓名</th>
            <th>地址</th>
            <th>生日</th>
            <th>身高</th>
            <th>體重</th>
            <th>備註</th>
            <th colspan="3" align="center"><a href="add.php">新增記錄</a></th>
        </tr>
    {$data}
    </table>
HEREDOC;

    // 找不到資料時
    if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


$html = <<< HEREDOC
<h2>資料列表 (查詢分頁)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>