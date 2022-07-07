<?php
include 'config.php';

if(!isset($_POST['username')) die('Cannot execute this program directly.');


// 接受外部表單傳入之變數
$usercode = isset($_POST['usercode'])? $_POST['usercode'] : '';
$username = isset($_POST['username'])? $_POST['username'] : '';
$address  = isset($_POST['address']) ? $_POST['address']  : '';
$birthday = isset($_POST['birthday'])? $_POST['birthday'] : '';
$height   = isset($_POST['height'])  ? $_POST['height']   : 0;
$weight   = isset($_POST['weight'])  ? $_POST['weight']   : 0;
$remark   = isset($_POST['remark'])  ? $_POST['remark']   : '';

// 連接資料庫
$link = db_open();


// 參考一：最原始參考，直接寫出所有的值 (注意文字和數字的差異)
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) 
           VALUES('104', 'David', 'Taipei', '2010-6-6', '180', '80', 'ok') ";


// 參考二：利用變數，置於雙引號內 (因為SQL敘述內的字串使用單引號)
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) 
           VALUES('$usercode', '$username', '$address', '$birthday', $height, $weight, '$remark') ";


// 參考三：把變數和常數分離 (逐項分開寫較清楚)
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES(
          '" . $usercode . "', 
          '" . $username . "', 
          '" . $address  . "', 
				  '" . $birthday . "', 
				   " . $height   . " , 
				   " . $weight   . " ,
          '" . $remark   . "') "; 


// 參考四：各列均採完整敘述 (標示清楚且易於修改及擴充)
$sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (";
$sqlstr .= "'" . trim($usercode) . "', ";
$sqlstr .= "'" . trim($username) . "', ";
$sqlstr .= "'" . trim($address)  . "', ";
$sqlstr .= "'" . $birthday       . "', ";
$sqlstr .= "'" . $height         . "', ";
$sqlstr .= "'" . $weight         . "', "; 
$sqlstr .= "'" . trim($remark)   . "') "; // 注意：最後一個欄位之後的符號


// 執行SQL
$result = @mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
if($result)
{
   echo 'Success...';
}
else
{
   echo 'Fail...<br />';
   echo mysqli_error() . '<br />' . $sqlstr;  // 偵錯用
}
?>