<?php
include "config.php";

$key_name = isset($_POST["key_name"]) ? $_POST["key_name"] : "";
$key_addr = isset($_POST["key_addr"]) ? $_POST["key_addr"] : "";
$key_yy = isset($_POST["key_yy"]) ? $_POST["key_yy"] : "";
$key_mm = isset($_POST["key_mm"]) ? $_POST["key_mm"] : "";
$key_dd = isset($_POST["key_dd"]) ? $_POST["key_dd"] : "";
$key_h1 = isset($_POST["key_h1"]) ? intval($_POST["key_h1"]) : 0;
$key_h2 = isset($_POST["key_h2"]) ? intval($_POST["key_h2"]) : 0;
$key_w1 = isset($_POST["key_w1"]) ? intval($_POST["key_w1"]) : 0;
$key_w2 = isset($_POST["key_w2"]) ? intval($_POST["key_w2"]) : 0;


// 連接資料庫
$link = db_open();


// SQL 語法
$sql_where = "WHERE true ";
$sql_where .= (empty($key_name)) ? "" : " AND username LIKE '%" . $key_name . "%' ";  // 處理姓名欄位
$sql_where .= (empty($key_addr)) ? "" : " AND address LIKE '%" . $key_addr . "%' ";  // 處理地址欄位
$sql_where .= (empty($key_yy)) ? "" : " AND YEAR(birthday)=" . ($key_yy+0);  // 處理生日欄位的年
$sql_where .= (empty($key_mm)) ? "" : " AND MONTH(birthday)=". ($key_mm+0);  // 處理生日欄位的月
$sql_where .= (empty($key_dd)) ? "" : " AND DAY(birthday)="  . ($key_dd+0);  // 處理生日欄位的日
// 處理身高
if(empty($key_h1) && empty($key_h2))
{
   // Nothing to do
}
elseif(!empty($key_h1) && empty($key_h2))
{
   $sql_where .= " AND height > " . $key_h1;
}
elseif(empty($key_h1) && !empty($key_h2))
{
   $sql_where .= " AND height < " . $key_h2;
}
else
{
   $sql_where .= " AND height BETWEEN " . min($key_h1,$key_h2) . " AND " . max($key_h1,$key_h2);
}
// 處理體重 (方法同身高)
if(empty($key_w1) && empty($key_w2))
{
   // Nothing to do
}
elseif(!empty($key_w1) && empty($key_w2))
{
   $sql_where .= " AND weight > " . $key_w1;
}
elseif(empty($key_w1) && !empty($key_w2))
{
   $sql_where .= " AND weight < " . $key_w2;
}
else
{
   $sql_where .= " AND weight BETWEEN " . min($key_w1,$key_w2) . " AND " . max($key_w1,$key_w2);
}

$str_find = '搜尋符合的記錄';

$sqlstr = "SELECT * FROM person ";
$sqlstr .= $sql_where;


// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
$total_rec = mysqli_num_rows($result);
$data = '';
$cnt = 0;
while($row=mysqli_fetch_array($result))
{
   $uid      = $row["uid"];
   $usercode = $row["usercode"];
   $username = $row["username"];
   $address  = $row["address"];
   $birthday = $row["birthday"];
   $height   = $row["height"];
   $weight   = $row["weight"];
   $remark   = $row["remark"];
   
   $cnt++;
   
   $data .= <<< HEREDOC
     <tr>
       <th align="center">{$cnt}</th>
       <td>{$usercode}</td>
       <td>{$username}</td>
       <td>{$address}</td>
       <td>{$birthday}</td>
       <td>{$height}</td>
       <td>{$weight}</td>
       <td>{$remark}</td>
    </tr>
HEREDOC;
}


$head = <<< HEREDOC
<script>
function show_sql()
{
   alert("{$sqlstr}");
}
</script>
HEREDOC;


$html = <<< HEREDOC
<p align="center"><font color="#FF0000">{$str_find}</font><br><a href="javascript:show_sql();">查看SQL語法</a></p>
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
<table border="1" align="center">   
   <tr>
      <th>順序</th>
      <th>代碼</th>
      <th>姓名</th>
      <th>地址</th>
      <th>生日</th>
      <th>身高</th>
      <th>體重</th>
      <th>備註</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);;
?>