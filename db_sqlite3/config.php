<?php

define('DB_SERVERIP', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'class');


define('DB_SOURCE'  , 'sqlite:'.DB_DATABASE.'.db');  // SQLite3，可自訂檔案名稱

define('SET_CHARACTER', 'set character set utf8');   // utf8 或 big5 或此列加註移除

define('ERROR_CONNECT',   'Cannot connect server');  // 無法連接伺服器
define('ERROR_DATABASE',  'Cannot open database');  // 無法開啟資料庫
define('ERROR_CHARACTER', 'Character set error');  // 無法使用指定的校對字元集
define('ERROR_QUERY',     'Error in SQL Query');  // 無法執行資料庫查詢指令


function db_open()
{
    try {
       $pdo = new PDO(DB_SOURCE, DB_USERNAME, DB_PASSWORD);   
       if(defined('SET_CHARACTER')) $pdo->query(SET_CHARACTER);
    } catch (PDOException $e) { die('Error!: ' . $e->getMessage());}
    
    return $pdo;
}

function db_close()
{
    
}

?>