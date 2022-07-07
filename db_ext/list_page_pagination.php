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


// ------ 分頁處理開始 -------------------------------------
// 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
$lnk_pageprev = '?numpp=' . $numpp . '&page=' . (($page==1)?(1):($page-1));
$lnk_pagenext = '?numpp=' . $numpp . '&page=' . (($page==$total_page)?($total_page):($page+1));
$lnk_pagehead = '?numpp=' . $numpp . '&page=1';
$lnk_pagelast = '?numpp=' . $numpp . '&page=' . $total_page;

// 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
$lnk_pagelist = "";
for($i=1; $i<=$page-1; $i++)
{ $lnk_pagelist .= '<a href="?numpp='.$numpp.'&page='.$i.'">'.$i.'</a> '; }
$lnk_pagelist .= '[' . $i . '] ';
for($i=$page+1; $i<=$total_page; $i++)
{ $lnk_pagelist .= '<a href="?numpp='.$numpp.'&page='.$i.'">'.$i.'</a> '; }

// 處理各頁之超連結：下拉式跳頁選單
$lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
$lnk_pagegoto .= '<input type="hidden" name="numpp" value="'.$numpp.'">';
$lnk_pagegoto .= '<select name="page" onChange="submit();">';
for($i=1; $i<=$total_page; $i++)
{
   $is_current = (($i-$page)==0) ? (" SELECTED") : ("");
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
HEREDOC;

db_close($link);


// 套用 Pagination 的導覽列內容 (採用<li>方式處理)
$link_before = 6;   // 前面的頁數(可自行設定)
$link_after = 6;   // 後面的頁數(可自行設定)

$lnk_pagination = '';
$lnk_pagination .= '
   <ul>
     <li class="disabled">第一頁</li>
     <li><a href="' . $lnk_pageprev . '">上一頁</a></li>';

$gprev = ($page-$link_before<=1) ? 1 : ($page-$link_before);
for ($i=$gprev; $i<$page; $i++ )
{ $lnk_pagination .= '<li><a href="?numpp='.$numpp.'&page='.$i.'">'.$i.'</a></li>'; }
$lnk_pagination .= '<li class="current">' . $i . '</li>';
$gnext = ($page+$link_after>=$total_page)?($total_page):($page+$link_after);
for($i=$page+1; $i<=$gnext; $i++)
{ $lnk_pagination .= '<li><a href="?numpp='.$numpp.'&page='.$i.'">'.$i.'</a></li>'; }

$lnk_pagination .= '
     <li><a href="' . $lnk_pagenext . '">下一頁</a></li>
     <li class="disabled">最後一頁</li>
   </ul>';


// ------ 分頁處理結束 -------------------------------------

$head = '<link type="text/css" rel="stylesheet" href="pagination.css" />';

$html = <<< HEREDOC
<h2 align="center">共有 {$total_rec} 筆記錄</h2>

<h3 align="center" style="background-color:#AACC88;">原本的標準導覽列</h3>
{$ihc_navigator}<BR>

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
<br>

<h3 align="center" style="background-color:#AACC88;">其他各種結合CSS的分頁導覽列</h3>

<h2 class="pagination_title">Digg Style</h2>
<div class="pagination digg">{$lnk_pagination}</div>

<h2 class="pagination_title">Yahoo Style</h2>
<div class="pagination yahoo">{$lnk_pagination}</div>

<h2 class="pagination_title">Meneame Style</h2>
<div class="pagination meneame">{$lnk_pagination}</div>

<h2 class="pagination_title">Flickr Style</h2>
<div class="pagination flickr">{$lnk_pagination}</div>

<h2 class="pagination_title">Sabros.us Style (Mi sabros.us)</h2>
<div class="pagination sabrosus">{$lnk_pagination}</div>

<h2 class="pagination_title">Green Style</h2>
<div class="pagination scott">{$lnk_pagination}</div>

<h2 class="pagination_title">Gray Style</h2>
<div class="pagination quotes">{$lnk_pagination}</div>

<h2 class="pagination_title">Black Style</h2>
<div class="pagination black">{$lnk_pagination}</div>

<h2 class="pagination_title">Mis Algoritmos Style</h2>
<div class="pagination black2">{$lnk_pagination}</div>

<h2 class="pagination_title">Black-Red Style</h2>
<div class="pagination black-red">{$lnk_pagination}</div>

<h2 class="pagination_title">Gray Style 2</h2>
<div class="pagination grayr">{$lnk_pagination}</div>

<h2 class="pagination_title">Yellow Style</h2>
<div class="pagination yellow">{$lnk_pagination}</div>

<h2 class="pagination_title">Jogger Style</h2>
<div class="pagination jogger">{$lnk_pagination}</div>

<h2 class="pagination_title">starcraft 2 Style</h2>
<div class="pagination starcraft2">{$lnk_pagination}</div>

<h2 class="pagination_title">Tres Style</h2>
<div class="pagination tres">{$lnk_pagination}</div>

<h2 class="pagination_title">512megas Style</h2>
<div class="pagination megas512">{$lnk_pagination}</div>

<h2 class="pagination_title">Technorati Style</h2>
<div class="pagination technorati">{$lnk_pagination}</div>

<h2 class="pagination_title">YouTube Style</h2>
<div class="pagination youtube">{$lnk_pagination}</div>

<h2 class="pagination_title">MSDN Search Style</h2>
<div class="pagination msdn">{$lnk_pagination}</div>

<h2 class="pagination_title">Badoo Style</h2>
<div class="pagination badoo">{$lnk_pagination}</div>

<h2 class="pagination_title">Blue Style </h2>
<div class="pagination manu">{$lnk_pagination}</div>
HEREDOC;


include 'pagemake.php';
pagemake($html, $head);
?>