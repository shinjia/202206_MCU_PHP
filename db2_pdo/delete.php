<?php
/* db2_pdo v1.0  @Shinjia  #2022/07/19 */

include 'config.php';
include 'utility.php';

// 接收傳入變數
$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$nump = isset($_GET['nump']) ? $_GET['nump'] : 10;   // 每頁的筆數

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "DELETE FROM person WHERE uid=?";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行 SQL
try { 
    $sth->execute();

    $lnk_list = 'list_page.php?page=' . $page . '&nump=' . $nump;
    $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
    header('Location: ' . $lnk_list);
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
        
    $html = <<< HEREDOC
    {$ihc_error}
HEREDOC;
    include 'pagemake.php';
    pagemake($html);
}

db_close();

?>