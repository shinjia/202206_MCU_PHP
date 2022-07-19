<?php
include 'config.php';
include 'utility.php';


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   $data = '';
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $usercode = convert_to_html($row['usercode']);
      $username = convert_to_html($row['username']);
      $address  = convert_to_html($row['address']);
      $birthday = convert_to_html($row['birthday']);
      $height   = convert_to_html($row['height']);
      $weight   = convert_to_html($row['weight']);
      $remark   = convert_to_html($row['remark']);
    
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
          <td><a href="display.php?uid={$uid}">詳細</a></td>
          <td><a href="edit.php?uid={$uid}">修改</a></td>
          <td><a href="delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
       </tr>
HEREDOC;
   }
   
   $html = <<< HEREDOC
   <h2 align="center">共有 {$total_rec} 筆記錄</h2>
   <table border="1" align="center">
      <tr>
         <th>👨‍🚀</th>
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
}
else
{
   // 無法執行 query 指令時
   $html = error_message('list_all');
}

include 'pagemake.php';
pagemake($html, '');
?>