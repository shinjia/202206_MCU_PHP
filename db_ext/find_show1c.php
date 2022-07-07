<?php
include 'config.php';

$key1 = isset($_POST['key1']) ? $_POST['key1'] : '';
$key2 = isset($_POST['key2']) ? $_POST['key2'] : '';


$key1 = (empty(trim($key1))) ? 0 : $key1;
$key2 = (empty(trim($key2))) ? 0 : $key2;

// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT *, (weight/((height/100)*(height/100))) as bmi ";
$sqlstr .= " FROM person ";
$sqlstr .= " WHERE (weight/((height/100)*(height/100))) BETWEEN " . $key1 . " AND " . $key2;
$sqlstr .= " ORDER BY bmi ";

$str_find = '搜尋BMI值介於『' . $key1 . '』和『' . $key2 . '』之間的記錄';


// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
$total_rec = mysqli_num_rows($result);
$data = '';
$cnt = 0;
while($row=mysqli_fetch_array($result))
{
   $uid      = $row['uid'];
   $usercode = $row['usercode'];
   $username = $row['username'];
   $address  = $row['address'];
   $birthday = $row['birthday'];
   $height   = $row['height'];
   $weight   = $row['weight'];
   $remark   = $row['remark'];
   $bmi      = $row['bmi'];
   
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
       <td>{$bmi}</td>
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
<p align="center"><a href="javascript:show_sql();">查看SQL語法</a></p>
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
      <th>BMI值</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>