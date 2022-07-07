<?php
// 連接資料庫
$link = mysqli_connect('localhost', 'root', '', 'class');

// 寫出 SQL 語法 
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) 
           VALUES('101', 'Alannn', 'Taipei', '2010-3-8', 170, 60, 'OK') ";

// 執行SQL
mysqli_query($link, $sqlstr);

mysqli_close($link);  // 關閉資料庫，可省略

echo 'OK';
?>