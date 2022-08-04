<?php

define('DB_SERVERIP', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'class');

define('SET_CHARACTER', 'set character set utf8');   // utf8或big5或此列加註移除
define('CHARSET', 'utf8');   // utf8或此列加註移除 (此用於PHP 5.0.5以上)

define('ERROR_CONNECT',  'Cannot connect server');  // 無法連接伺服器
define('ERROR_DATABASE', 'Cannot open database');  // 無法開啟資料庫
define('ERROR_CHARACTER','Character set error');  // 無法使用指定的校對字元集
define('ERROR_QUERY',    'Error in SQL Query');  // 無法執行資料庫查詢指令
define('ERROR_CHARSET',  'Set charset error');  // 無法設定指定的校對指令

// For PDO MySQL
define('DB_SOURCE', 'mysql:host='.DB_SERVERIP.';dbname='.DB_DATABASE);


function db_open()
{
   try {
      $pdo = new PDO(DB_SOURCE, DB_USERNAME, DB_PASSWORD);   
      if(defined('SET_CHARACTER')) $pdo->query(SET_CHARACTER);
   } catch (PDOException $e) { die("Error!: " . $e->getMessage()); } 
      
   return $pdo;
}

function db_close()
{
}
?>