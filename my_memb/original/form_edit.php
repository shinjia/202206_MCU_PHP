<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM form WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $uid = $row['uid'];

        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);
        $membcode = html_encode($row['membcode']);
        $remark   = html_encode($row['remark']);
        
        $data = <<< HEREDOC
        <form action="form_edit_save.php" method="post">
        <table class="table">
            <tr><th>代碼</th><td><input type="text" name="formcode" value="{$formcode}"></td></tr>
            <tr><th>主旨</th><td><input type="text" name="formname" value="{$formname}"></td></tr>
            <tr><th>日期</th><td><input type="text" name="formdate" value="{$formdate}"></td></tr>
            <tr><th>欄一</th><td><input type="text" name="formfld1" value="{$formfld1}"></td></tr>
            <tr><th>欄二</th><td><input type="text" name="formfld2" value="{$formfld2}"></td></tr>
            <tr><th>更多</th><td><input type="text" name="forminfo" value="{$forminfo}"></td></tr>
            <tr><th>會員代號</th><td><input type="text" name="membcode" value="{$membcode}"></td></tr>
            <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
        </table>
        <p>
            <input type="hidden" name="uid" value="{$uid}">
            <input type="submit" value="送出">
        </p>
        </form>
HEREDOC;
    }
    else {
        $data = '<p class="center">無資料</p>';
    }

    //網頁顯示
    $ihc_content = <<< HEREDOC
    <div>
        {$data}
    </div>
HEREDOC;
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();


//網頁顯示
$html = <<< HEREDOC
<h2>修改資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>