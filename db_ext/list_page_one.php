<?php
include "config.php";

// 接收傳入變數
$page = isset($_GET['page']) ? $_GET['page'] : 1;  // 目前的頁碼

$numpp = 1;  // 每頁的筆數

// 連接資料庫
$link = db_open();


// 處理分頁
$sqlstr = "SELECT count(*) as total_rec FROM person ";
$result = mysqli_query($link, $sqlstr);

if($row=mysqli_fetch_array($result))
{
   $total_rec = $row['total_rec'];
   // $total_rec = mysqli_num_rows($result);  // 計算總筆數
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數
   

// 擷取該分頁資料
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資取資料

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

// 執行SQL及處理結果
$data = '';
$result = mysqli_query($link, $sqlstr);
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
 <td>
       
   <div style="width:500px; height:360px; background-color:#FFDDCC">
      <h3 align="center">可在此設計單筆記錄的顯示畫面</h3>
      <p>代碼：{$usercode}</p>
      <p>姓名：{$username}</p>
      <p>地址：{$address}</p>
      <p>生日：{$birthday}</p>
      <p>身高：{$height}</p>
      <p>體重：{$weight}</p>
      <p>備註：{$remark}</p>
   </div>
   
 </td>
</tr>
HEREDOC;
}

db_close($link);

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
   $is_current = (($i-$page)==0) ? ' SELECTED' : '';
   $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
}
$lnk_pagegoto .= '</select>';
$lnk_pagegoto .= '</form>';

// 將各種超連結組合成HTML顯示畫面
$ihc_navigator = '';
// $ihc_navigator .= '<table border="0" align="center"><tr><td>' . $lnk_pagelist . '</td></tr></table>';
$ihc_navigator .= <<< HEREDOC
<table border="0" align="center">
 <tr>
  <td>頁數：{$page} / {$total_page}</td>
  <td>&nbsp;&nbsp;&nbsp;</td>
  <td>
   <a href="{$lnk_pagehead}">第一頁</a> 
   <a href="{$lnk_pageprev}">上一頁</a> 
   <a href="{$lnk_pagenext}">下一頁</a> 
   <a href="{$lnk_pagelast}">最末頁</a>
  </td>
  <td>&nbsp;&nbsp;&nbsp;</td>
  <td>移至頁數</td>
  <td>{$lnk_pagegoto}</td>
 </tr>
</table>
HEREDOC;
// ------ 分頁處理結束 --------------------------------------


$html = <<< HEREDOC
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
{$ihc_navigator}
<BR>
<TABLE border="1" align="center">   
{$data}
</TABLE>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>