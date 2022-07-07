<?php
include 'config.php';

$key = isset($_POST['key']) ? $_POST['key'] : '';

// 連接資料庫
$link = db_open();

// SQL 語法
if(($key<=12) && ($key>=0))
{
   $str_find = '搜尋『' . $key . '』月份的壽星記錄';
}
else
{
   $str_find = '輸入之月份資料『' . $key . '』有誤';
   $key = 99;  // 在此設定一個不可能發生的值
}

$sqlstr = "SELECT * FROM person ";
$sqlstr .= " WHERE MONTH(birthday) = " . $key . " ";


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
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>