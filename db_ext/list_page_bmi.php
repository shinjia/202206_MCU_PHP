<?php
include "config.php";

// 接收傳入變數
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 10;  // 每頁的筆數

// 定義BMI等級的評語
$a_msg = array(
    'A' => '<font color="#FF0000">太胖了</font>',
    'B' => '<font color="#FFAAAA">稍重</font>'  , 
    'C' => '<font color="#0000FF">標準</font>'  ,
    'D' => '<font color="#44FF44">太輕了</font>',
    'X' => '不詳' );


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
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取

// 寫出 SQL 語法
$sqlstr = "SELECT uid, usercode, username, height, weight, (weight/((height/100)*(height/100))) as bmi FROM person ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

// 執行SQL及處理結果
$data = '';
$result = mysqli_query($link, $sqlstr);
$i = 0;
while($row=mysqli_fetch_array($result))
{
   $uid      = $row['uid'];
   $usercode = $row['usercode'];
   $username = $row['username'];
   $height   = $row['height'];
   $weight   = $row['weight'];
   $bmi      = $row['bmi'];

   $str_bmi = number_format($bmi,1);  // 顯示在網頁上的值取一位小數
   
   // 進行判斷
   if( ($bmi >= 25.0) && ($bmi<50) ) $grade = "A";
   elseif(($bmi>=23.0)&&($bmi<25.0)) $grade = "B";
   elseif(($bmi>=18.5)&&($bmi<23.0)) $grade = "C";
   elseif(($bmi< 18.5)&&($bmi>10.0)) $grade = "D";
   else $grade = "X";
   
   $str_msg = $a_msg[$grade];
   
   $data .= <<< HEREDOC
     <tr>
       <td>{$usercode}</td>
       <td>{$username}</td>
       <td align="right">{$height}</td>
       <td align="right">{$weight}</td>
       <td align="right">{$str_bmi}</td>
       <td>{$str_msg}</td>
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


$head = <<< HEREDOC
<script language="javascript">
function show_sql()
{
   alert("{$sqlstr}");
}
</script>
HEREDOC;


$html = <<< HEREDOC
<p align="center"><a href="javascript:show_sql();">查看SQL語法</a></p>
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
{$ihc_navigator}
<br />
<table border="1" align="center">   
   <tr>
      <th>代碼</th>
      <th>姓名</th>
      <th>身高</th>
      <th>體重</th>
      <th>BMI值</th>      
      <th>判定</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>