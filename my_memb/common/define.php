<?php
define('URL_ROOT', 'http://localhost/myweb/my_memb/');  // 網站根目錄

// 系統代碼 (用於系統檢查，例如 session、uid,chk)
define('SYSTEM_CODE', 'MEM');

// 用於登入權限及密碼檢查
define('DEF_PASSWORD_FILE', 'user_password.txt');  // 密碼文字檔
define('DEF_PASSWORD_PREFIX', 'MEM');  // 密碼加密的前置文字

// 登入權限檢查的判斷條件，不同的系統要改名稱
define('DEF_LOGIN_ADMIN', 'MEM_ADMIN');   // 登入檢查，ADMIN
define('DEF_LOGIN_MEMBER', 'MEM_MEMBER');   // 登入檢查，MEMBER

// email 的SMTP 設定 (此處暫時用在 PHP 程式的的 ini_set 中，仍應以 php.ini 設定為宜)
define('SET_SMTP', 'msa.hinet.net');
define('SET_SMTP_PORT', 25);
define('SET_SENDMAIL_FROM', 'xxxxx@gmail.com');  // 

?>