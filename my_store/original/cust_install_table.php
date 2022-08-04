<?php
include 'config.php';
include 'utility.php';

// 連接資料庫
$pdo = db_open();


// 新增資料表之SQL語法 (採用陣列方式，可以設定多個)
$a_table["customer"] = "

CREATE TABLE customer
(
   uid int(11) NOT NULL auto_increment, 
   account VARCHAR(255) NULL, 
   password VARCHAR(255) NULL, 
   forget_q VARCHAR(255) NULL, 
   forget_a VARCHAR(255) NULL, 
   nickname VARCHAR(255) NULL, 
   realname VARCHAR(255) NULL, 
   gentle VARCHAR(10) NULL, 
   birthday DATE NULL, 
   blood VARCHAR(10) NULL, 
   job VARCHAR(10) NULL, 
   interest VARCHAR(255) NULL, 
   zipcode VARCHAR(10) NULL, 
   address VARCHAR(255) NULL, 
   telephone VARCHAR(255) NULL, 
   email VARCHAR(255) NULL, 
   epaper VARCHAR(10) NULL, 
   level VARCHAR(10) NULL, 
   lastlogin DATETIME NULL, 
   PRIMARY KEY (uid) ); 

";


// 執行SQL及處理結果
$msg = '';
foreach($a_table as $key=>$sqlstr)
{
   $sth = $pdo->exec($sqlstr);   
   if($sth===FALSE)
   {
      $msg .= '資料表『' . $key . '』無法建立<br />';
      $msg .= print_r($pdo->errorInfo(),TRUE) . '<br />' . $sqlstr;
   }
   else
   {
      $msg .= '資料表『' . $key . '』建立完成<BR>';
   }
}


$html = <<< HEREDOC
<body>
<h2>資料表建立結果</h2>
{$msg}
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>