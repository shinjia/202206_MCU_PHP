<?php
/* db2_pdo_cookie v1.0  @Shinjia  #2022/07/22 */

// 查詢及分頁之資料列表

$is_debug = false;  // 檢查 Cookie 的值

include 'config.php';
include 'utility.php';

// 預先讀取 Cookie (沒有則設為初始值)
$cc_page = isset($_COOKIE['page']) ? $_COOKIE['page'] : 1;
$cc_nump = isset($_COOKIE['nump']) ? $_COOKIE['nump'] : 10;
$cc_uid = isset($_COOKIE['uid']) ? $_COOKIE['uid'] : 0;
$cc_key = isset($_COOKIE['key']) ? $_COOKIE['key'] : '';

if($is_debug) {
    echo ' | cc_page:' . $cc_page;
    echo ' | cc_nump:' . $cc_nump;
    echo ' | cc_key:' . $cc_key;
    echo ' | cc_uid:' . $cc_uid;
    echo ' | <br>';
}

// 接收 GET 及 POST 傳入
$key = isset($_POST['key']) ? $_POST['key'] : (isset($_GET['key'])?$_GET['key']:'');
if(!empty($key)) {
    // 有新傳入的 key 參數，則回復到最原始
    $cc_page = 1;
    $cc_uid = 0;
}
else {
    // 沒有新傳入的 key 參數，則取得 Cookie 內的值
    $key = $cc_key;
}

// 頁碼參數
$page = isset($_GET['page']) ? $_GET['page'] : $cc_page;
$nump = isset($_GET['nump']) ? $_GET['nump'] : $cc_nump;
if(isset($_GET['nump']) || isset($_GET['page'])) {
    // 若是換頁，則 cc_uid 取消
    setcookie('uid', 0, time()+86400*7);
}

// 再寫入 COOKIE
setcookie('page', $page, time()+86400*7);
setcookie('nump', $nump, time()+86400*7);
setcookie('key', $key, time()+86400*7);

if($is_debug) {
    echo ' | page:' . $page;
    echo ' | nump:' . $nump;
    echo ' | key:' . $key;
    echo ' | cc_uid:' . $cc_uid;
    echo ' | <br>';
}

// 增加傳入 uid，把該筆記錄高亮標示
$uid_highlight = $cc_uid;

// 參數安全檢查
$page = intval($page);  // 轉為整數
$nump = intval($nump);  // 轉為整數
$page = ($page<=0) ? 1 : $page;  // 不可為零
$nump = ($nump<=0) ? 10 : $nump;  // 不可為零

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

$page = ($page>$total_page) ? $total_page : $page;  // 頁數超過時，維持在最後一頁
$page = ($page<=0) ? 1 : $page;

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

        // 指定的 uid 記錄高亮顯示
        $str_highlight = '';
        if($uid==$uid_highlight)
        {
            $str_highlight = 'class="hightlight"';
        }

        // 超連結
        $lnk_display = 'display.php?uid=' . $uid;
        $lnk_edit = 'edit.php?uid=' . $uid;
        $lnk_delete = 'delete.php?uid=' . $uid;

        $data .= <<< HEREDOC
            <tr {$str_highlight}>
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
    $ihc_navigator = pagination($total_page, $page, $nump);
    
    $lnk_add = 'add.php';

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
            <th colspan="3" align="center"><a href="{$lnk_add}">新增記錄</a></th>
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


if(!empty($key)) {
    $str_find = '列出姓名包含『' . $key . '』的記錄';
}
else {
    $str_find = '列出全部記錄';
}    

$html = <<< HEREDOC
<h2>{$str_find}</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>