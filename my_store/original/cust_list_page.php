<?php
include 'config.php';
include 'utility.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$numpp = 15;  // 每頁的筆數

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

// 取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM customer ";
$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC))
{
   $total_rec = $row["total_rec"];
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資料

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM customer ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;


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

    
        // 顯示『password』密碼欄位的轉換
        $str_password = str_repeat("*", strlen($password));

        // 顯示『forget_a』密碼欄位的轉換
        $str_forget_a = str_repeat("*", strlen($forget_a));

        // 顯示『gentle』欄位的選項值及文字
        $str_gentle = "(" . $gentle. ") " . $a_gentle[$gentle];
        
        // 顯示『blood』欄位的選項值及文字
        $str_blood = "(" . $blood. ") " . $a_blood[$blood];
        
        // 顯示『job』欄位的選項值及文字
        $str_job = "(" . $job. ") " . $a_job[$job];
        
        // 顯示『epaper』欄位的核選值及文字
        $str_epaper = isset($a_epaper[$epaper]) ? $a_epaper[$epaper] : "*無勾選*";
        
        // 顯示『level』欄位的選項值及文字
        $str_level = "(" . $level. ") " . $a_level[$level];
        

   
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

       <td><a href="cust_display.php?uid=$uid">詳細</a></td>
       <td><a href="cust_edit.php?uid=$uid">修改</a></td>
       <td><a href="cust_delete.php?uid=$uid" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
    </tr>
HEREDOC;
    }


// ------ 分頁處理開始 -------------------------------------
// 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
$lnk_pageprev = '?page=' . (($page==1)?(1):($page-1));
$lnk_pagenext = '?page=' . (($page==$total_page)?($total_page):($page+1));
$lnk_pagehead = '?page=1';
$lnk_pagelast = '?page=' . $total_page;

// 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
$lnk_pagelist = "";
for($i=1; $i<=$page-1; $i++)
{ $lnk_pagelist .= '<a href="?page='.$i.'">'.$i.'</a> '; }
$lnk_pagelist .= '[' . $i . '] ';
for($i=$page+1; $i<=$total_page; $i++)
{ $lnk_pagelist .= '<a href="?page='.$i.'">'.$i.'</a> '; }

// 處理各頁之超連結：下拉式跳頁選單
$lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
$lnk_pagegoto .= '<select name="page" onChange="submit();">';
for($i=1; $i<=$total_page; $i++)
{
   $is_current = (($i-$page)==0) ? ' selected' : '';
   $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
}
$lnk_pagegoto .= '</select>';
$lnk_pagegoto .= '</form>';

// 將各種超連結組合成HTML顯示畫面
$ihc_navigator  = <<< HEREDOC
<table border="0" align="center">
 <tr>
  <td>頁數：{$page} / {$total_page} &nbsp;&nbsp;&nbsp;</td>
  <td>
  <a href="{$lnk_pagehead}">第一頁</a> 
  <a href="{$lnk_pageprev}">上一頁</a> 
  <a href="{$lnk_pagenext}">下一頁</a> 
  <a href="{$lnk_pagelast}">最末頁</a> &nbsp;&nbsp;
  </td>
 <td>移至頁數：</td>
 <td>{$lnk_pagegoto}</td>
</tr>
</table>
HEREDOC;
// ------ 分頁處理結束 -------------------------------------
}
else
{
   // 無法執行 query 指令時
   $html = error_message('list_all');
}


$html = <<< HEREDOC
<h2 align="center">共有 $total_rec 筆記錄</h2>
{$ihc_navigator}
<p></p>
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

include 'pagemake.php';
pagemake($html);
?>