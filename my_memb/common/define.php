<?php
define('URL_ROOT', 'http://localhost/myweb/my_memb/');  // 網站根目錄

// 系統代碼 (用於系統檢查，例如 uid,chk)
define('SYSTEM_CODE', 'MEM');

// 定義 SESSION 的變數名稱
define('DEF_SESSION_USERTYPE', 'MEM_usertype');
define('DEF_SESSION_USERCODE', 'MEM_usercode');

// 用於登入權限及密碼檢查
define('DEF_PASSWORD_FILE', 'user_password.txt');  // 密碼文字檔
define('DEF_PASSWORD_PREFIX', 'MEM');  // 密碼加密的前置文字

// 登入權限檢查的判斷條件，不同的系統要改名稱
define('DEF_LOGIN_ADMIN' , 'MEM_ADMIN');   // 登入檢查，ADMIN
define('DEF_LOGIN_MEMBER', 'MEM_MEMBER');  // 登入檢查，MEMBER
define('DEF_LOGIN_VIP'   , 'MEM_VIP');     // 登入檢查，VIP
define('DEF_LOGIN_APPLY' , 'MEM_APPLY');   // 登入檢查，APPLY

// 路徑
define('DEF_PHOTO_PATH', '../photo/');   // 上傳照片的路徑

// email 的SMTP 設定 (此處暫時用在 PHP 程式的的 ini_set 中，仍應以 php.ini 設定為宜)
define('SET_SMTP', 'msa.hinet.net');
define('SET_SMTP_PORT', 25);
define('SET_SENDMAIL_FROM', 'shinjia168@gmail.com');  // 

?>