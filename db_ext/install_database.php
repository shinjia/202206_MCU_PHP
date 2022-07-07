<?php
include "config.php";

// 連接資料庫
$link = @mysqli_connect(DB_SERVERIP, DB_USERNAME, DB_PASSWORD) or die(ERROR_CONNECT);
// @mysql_select_db(DB_DATABASE) or die(ERROR_DATABASE);
if(defined('SET_CHARACTER')) mysqli_query($link, SET_CHARACTER) or die(ERROR_CHARACTER);

// 寫出 SQL 語法
$sqlstr = "CREATE DATABASE " . DB_DATABASE;
$sqlstr .= " DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ";

// 執行SQL及處理結果
$result = @mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
if( $result )
{
    $msg = '資料庫 ' . DB_DATABASE . ' 建立成功！';
}
else
{
   $msg = '資料庫無法建立！<HR>';
   $msg .= $sqlstr . '<HR>' . mysqli_error($link);
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
</head>
<body>
<h2>資料庫建立</h2>
{$msg}
</body>
</html>
HEREDOC;

echo $html;
?>