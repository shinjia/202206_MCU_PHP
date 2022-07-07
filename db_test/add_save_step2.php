<?php
// 連接資料庫
$link = @mysqli_connect('localhost', 'root', '', 'class') or die('Cannot connect server');

// 寫出 SQL 語法 
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) 
           VALUES('102', 'Bruce', 'Taichung', '2010-4-9', '180', '70', 'ok') ";

// 執行SQL
$result = @mysqli_query($link, $sqlstr)
if($result)
{
   echo 'Success...';
}
else
{
   echo 'Fail...<br />';
   echo mysqli_error($link) . '<br />' . $sqlstr;  // 偵錯用
}
?>