<?php
include "config.php";

// 接收傳入變數
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 6;  // 每頁的筆數 (每列欄數*列數)
$columns = 3;  // 多欄顯示之欄位數設定

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
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

// 執行SQL及處理結果
$cnt = 0;
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

   // 多欄處理：若為第一欄，資料顯示前需要先加上新列的頭 <TR)>
   if(($cnt % $columns)==0)
   {
      $data .= '<tr>';
   }
    
   // 配合多欄顯示，資料的顯示方法也需要修改
   // 包含：不含TR的定義；資料項目要包在一個TD內；最好能控制寬度
   $data .= <<< HEREDOC
       <td>
       <div style="width:140px; height:160px;">
          {$usercode}<BR>
          {$username}<BR>
          {$address}<BR>
          生日：{$birthday}<BR>
          身高：{$height}<BR>
          體重：{$weight}<BR>
          備註：{$remark}<BR>
       </div>
       </td>
       
HEREDOC;

   // 多欄處理：若為最後一欄，資料顯示後需要加上此列的尾 </TR>
   if(($cnt % $columns)==($columns-1))
   {
      $data .= '</tr>';
   }
   
   $cnt++;
}


// 多欄處理：若每頁筆數($numpp)未調整成欄數的倍數，則每頁均需補後面不足的空項
$cnt1 = $cnt % $columns;  // 此列已顯示的項目數
if( ($cnt1<$columns) && ($cnt1>0) )  // 不是最後也不是第一個
{
   for($i=$cnt1+1; $i<=$columns; $i++)
   {
      $data .= '<td><div style="width:140px; height:120px;">&nbsp;</div></td>';
   }
   $data .= '</TR>';
}

// 多欄處理：如有需要，在最後一頁，可考慮再把不滿的列數也補上
if($page==$total_page)
{
   $rec_last = $total_rec - ($numpp * ($page-1)); // 最後一頁的記錄數
   $rr1 = ceil($rec_last / $columns);  //最後一頁，出現資料的列數
   $rr2 = ceil($numpp / $columns);  // 應該有的列數
   for($j=$rr1+1; $j<=$rr2; $j++)
   {
      // 補上完整的第$i列      
      $data .= '<TR>';
      for($i=1; $i<=$columns; $i++)
      {
         $data .= '<TD><DIV style="width:140px; height:120px;">&nbsp;</DIV></TD>';
      }
      $data .= '</TR>';
   } 
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
<br>
<table border="1" align="center">
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>