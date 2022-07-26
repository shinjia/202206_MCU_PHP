<?php
/* my_form v0.1  @Shinjia  #2022/07/21 */

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM form ";

// 執行 SQL
try { 
    $sth = $pdo->query($sqlstr);

    $total_rec = $sth->rowCount();
    $cnt = 0;
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $uid = $row['uid'];
        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);
        $membcode = html_encode($row['membcode']);
        $remark   = html_encode($row['remark']);
    
        $cnt++;

        $data .= <<< HEREDOC
        <tr>
            <th>{$cnt}</th>
            <td>{$uid}</td>
            <td>{$formcode}</td>
            <td>{$formname}</td>
            <td>{$formdate}</td>
            <td>{$formfld1}</td>
            <td>{$formfld2}</td>
            <td>{$forminfo}</td>
            <td>{$membcode}</td>
            <td>{$remark}</td>
            <td><a href="form_display.php?uid={$uid}">詳細</a></td>
            <td><a href="form_edit.php?uid={$uid}">修改</a></td>
            <td><a href="form_delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
        </tr>
HEREDOC;
    }

   //網頁顯示
    $ihc_content = <<< HEREDOC
    <h3>共有 {$total_rec} 筆記錄</h3>
    <table border="1" class="table">
        <tr>
            <th>順序</th>
            <th>uid</th>
            <th>代碼</th>
            <th>主旨</th>
            <th>日期</th>
            <th>欄一</th>
            <th>欄二</th>
            <th>更多</th>
            <th>會員代號</th>
            <th>備註</th>
            <th colspan="3" align="center"><a href="form_add.php">新增記錄</a></th>
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
<h2>資料列表 (全部)</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>