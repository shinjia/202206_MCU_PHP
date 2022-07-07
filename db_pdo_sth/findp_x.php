<?php
// 含分頁之資料列表
include 'config.php';
include 'utility.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$key = isset($_POST['key']) ? $_POST['key'] : (isset($_GET['key'])?$_GET['key']:'^$!@#');

$numpp = 10;  // 每頁的筆數

// 連接資料庫
$pdo = db_open(); 

$tmp_start = ($page-1) * $numpp;  // 擷取記錄之起始位置

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person ";
$sqlstr .= "WHERE username LIKE ? ";  // 依條件修改
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

$sth = $pdo->prepare($sqlstr);

$keyword = '%' . $key . '%';  // 注意
$sth->bindValue(1, $keyword, PDO::PARAM_STR);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   // $total_rec = $sth->rowCount();
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
          <td><a href="display.php?uid=$uid">詳細</a></td>
          <td><a href="edit.php?uid=$uid">修改</a></td>
          <td><a href="delete.php?uid=$uid" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
        </tr>
HEREDOC;
   }

   // ------ 分頁處理開始 -------------------------------------
   // // 取得分頁所需之資訊 (總筆數、總頁數)
   $sqlstr = "SELECT count(*) as total_rec FROM person ";
   $sqlstr .= "WHERE username LIKE ? ";  // 依條件修改

   $sth = $pdo->prepare($sqlstr);

   $keyword = '%' . $key . '%';  // 注意
   $sth->bindValue(1, $keyword, PDO::PARAM_STR);

   // 執行SQL及處理結果
   if($sth->execute())
   {
      if($row = $sth->fetch(PDO::FETCH_ASSOC))
      {
         $total_rec = $row["total_rec"];
      }
   }
   $total_page = ceil($total_rec / $numpp);  // 計算總頁數

   // 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
   $lnk_pageprev = '?key=' . $key . '&page=' . (($page==1)?(1):($page-1));
   $lnk_pagenext = '?key=' . $key . '&page=' . (($page==$total_page)?($total_page):($page+1));
   $lnk_pagehead = '?key=' . $key . '&page=1';
   $lnk_pagelast = '?key=' . $key . '&page=' . $total_page;

   // 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
   $lnk_pagelist = '';
   for($i=1; $i<=$page-1; $i++)
   { $lnk_pagelist .= '<a href="?key=' . $key . '&page='.$i.'">'.$i.'</a> '; }
   $lnk_pagelist .= '[' . $i . '] ';
   for($i=$page+1; $i<=$total_page; $i++)
   { $lnk_pagelist .= '<a href="?key=' . $key . '&page='.$i.'">'.$i.'</a> '; }

   // 處理各頁之超連結：下拉式跳頁選單
   $lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
   $lnk_pagegoto .= '<select name="page" onChange="submit();">';
   for($i=1; $i<=$total_page; $i++)
   {
      $is_current = (($i-$page)==0) ? ' SELECTED' : '';
      $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
   }
   $lnk_pagegoto .= '</select>';
   $lnk_pagegoto .= '<input type="hidden" name="key" value="' . $key . '">';  // 帶入搜尋條件
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


   $html = <<< HEREDOC
   <h2 align="center">共有 $total_rec 筆記錄</h2>
   {$ihc_navigator}
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
}
else
{
   // 無法執行 query 指令時
   $html = error_message('list_page');
}


include 'pagemake.php';
pagemake($html, '');
?>