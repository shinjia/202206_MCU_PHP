<?php
include 'config.php';

// 連接資料庫
$link = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM person ";

// 執行 SQL
$result = mysqli_query($link, $sqlstr);

$total_rec = mysqli_num_rows($result);
$data = '';
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

   $data .= <<< HEREDOC
     <tr>
       <td>{$uid}</td>
       <td>{$usercode}</td>
       <td>{$username}</td>
       <td>{$address}</td>
       <td>{$birthday}</td>
       <td>{$height}</td>
       <td>{$weight}</td>
       <td>{$remark}</td>
       <th><a href="display.php?uid={$uid}">詳細</a></th>
       <th><a href="edit.php?uid={$uid}">修改</a></th>
       <th><a href="delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></th>
    </tr>
HEREDOC;
}

db_close($link);


//網頁顯示
$html = <<< HEREDOC
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
<table border="1" align="center">
   <tr>
      <th>序號</th>
      <th>代碼</th>
      <th>姓名</th>
      <th>地址</th>
      <th>生日</th>
      <th>身高</th>
      <th>體重</th>
      <th>備註</th>
      <th colspan="3" align="center"><a href="add.php">新增記錄</a></th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>