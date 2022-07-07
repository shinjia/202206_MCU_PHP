<?php
include "config.php";

// 接收傳入變數
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 10;  // 每頁的筆數

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
$lnk_pagelist .= '[' . $i . '] ';  // 目前的頁面
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


// 分頁導覽列的變化：標準形式
$ihc_navigator  = <<< HEREDOC
<h3 align="center" style="background-color:#AACC88;">原本的標準導覽列</h3>
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


// 分頁導覽列的變化：仿Google形式
$link_before = 5;   // 前面的頁數(可自行設定)
$link_after = 4;   // 後面的頁數(可自行設定)
$lnk_google = '';
$gprev = ($page-$link_before<=1) ? 1 : ($page-$link_before);
for ($i=$gprev; $i<$page; $i++ )
{ $lnk_google .= '<a href="?page='.$i.'">'.$i.'</a> '; }
$lnk_google .= '[' . $page . '] ';   // 目前的頁面
$gnext = ($page+$link_after>=$total_page)?($total_page):($page+$link_after);
for($i=$page+1; $i<=$gnext; $i++)
{ $lnk_google .= '<a href="?page='.$i.'">'.$i.'</a> '; }

$ihc_navigator_google = <<< HEREDOC
<h3 align="center" style="background-color:#AACC88;">仿 Google 的分頁導覽列 (可分別設定之前及之後的頁碼數)</h3>
<p align="center">{$lnk_google}</p>
HEREDOC;


// 分頁導覽列的變化：全部都列出來
$ihc_navigator_all  = <<< HEREDOC
<h3 align="center" style="background-color:#AACC88;">全部的頁數都顯示出來</h3>
<p align="center">{$lnk_pagelist}</p>
HEREDOC;

// ------ 分頁處理結束 -------------------------------------


$html = <<< HEREDOC
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
{$ihc_navigator}<br>
{$ihc_navigator_google}<br>
{$ihc_navigator_all}<br>
<h3 align="center" style="background-color:#FFCC88;">以下為本頁之資料記錄</h3>
<table border="1" align="center">
   <tr>
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
pagemake($html);
?>