<?php
include 'config.php';
include 'utility.php';

// 設定欄位『gentle』的值域選項
$a_gentle = array(
      "M"=>"男",
      "F"=>"女",
      "X"=>"未知" );

// 設定欄位『blood』的值域選項
$a_blood = array(
      "A"=>"A",
      "B"=>"B",
      "O"=>"O",
      "AB"=>"AB" );

// 設定欄位『job』的值域選項
$a_job = array(
      "A"=>"學生",
      "B"=>"上班族",
      "C"=>"自由業",
      "D"=>"家管",
      "X"=>"其他" );

// 設定欄位『epaper』的值域選項
$a_epaper = array(
      "Y"=>"願意收電子報" );

// 設定欄位『level』的值域選項
$a_level = array(
      "GUEST"=>"訪客",
      "MEMBER"=>"會員",
      "ADMIN"=>"管理員" );



// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM customer ";

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
      $account = convert_to_html($row['account']);
      $password = convert_to_html($row['password']);
      $forget_q = convert_to_html($row['forget_q']);
      $forget_a = convert_to_html($row['forget_a']);
      $nickname = convert_to_html($row['nickname']);
      $realname = convert_to_html($row['realname']);
      $gentle = convert_to_html($row['gentle']);
      $birthday = convert_to_html($row['birthday']);
      $blood = convert_to_html($row['blood']);
      $job = convert_to_html($row['job']);
      $interest = convert_to_html($row['interest']);
      $zipcode = convert_to_html($row['zipcode']);
      $address = convert_to_html($row['address']);
      $telephone = convert_to_html($row['telephone']);
      $email = convert_to_html($row['email']);
      $epaper = convert_to_html($row['epaper']);
      $level = convert_to_html($row['level']);
      $lastlogin = convert_to_html($row['lastlogin']);

    
      $data .= <<< HEREDOC
     <tr>
        <td>{$uid}</td>
        <td>{$account}</td>
        <td>{$str_password}</td>
        <td>{$forget_q}</td>
        <td>{$str_forget_a}</td>
        <td>{$nickname}</td>
        <td>{$realname}</td>
        <td>{$str_gentle}</td>
        <td>{$birthday}</td>
        <td>{$str_blood}</td>
        <td>{$str_job}</td>
        <td>{$interest}</td>
        <td>{$zipcode}</td>
        <td>{$address}</td>
        <td>{$telephone}</td>
        <td>{$email}</td>
        <td>{$str_epaper}</td>
        <td>{$str_level}</td>
        <td>{$lastlogin}</td>

       <td><a href="cust_display.php?uid={$uid}">詳細</a></td>
       <td><a href="cust_edit.php?uid={$uid}">修改</a></td>
       <td><a href="cust_delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
     </tr>
HEREDOC;
   }
   
   $html = <<< HEREDOC
   <h2 align="center">共有 {$total_rec} 筆記錄</h2>
   <table border="1" align="center">
      <tr>
        <th>序號</th>
        <th>帳號</th>
        <th>密碼</th>
        <th>改密碼Ｑ</th>
        <th>改密碼Ａ</th>
        <th>暱稱</th>
        <th>真實姓名</th>
        <th>性別</th>
        <th>生日</th>
        <th>血型</th>
        <th>職業</th>
        <th>興趣</th>
        <th>郵遞區號</th>
        <th>地址</th>
        <th>電話</th>
        <th>電子郵件</th>
        <th>收電子報</th>
        <th>等級</th>
        <th>最後登錄</th>

      <th colspan="3" align="center"><a href="cust_add.php">新增記錄</a></th>
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
pagemake($html);
?>