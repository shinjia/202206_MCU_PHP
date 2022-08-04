<?php
include 'config.php';
include 'utility.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$numpp = 15;  // 每頁的筆數

// 設定欄位『cart_status』的值域選項
$a_cart_status = array(
      "CART"=>"置於購物車",
      "ORDER"=>"已訂購" );




// 連接資料庫
$pdo = db_open();

// 取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM cart ";
$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC))
{
   $total_rec = $row["total_rec"];
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數
$tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資料

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM cart ";
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
      $tran_code = convert_to_html($row['tran_code']);
      $account = convert_to_html($row['account']);
      $prod_code = convert_to_html($row['prod_code']);
      $unit_price = convert_to_html($row['unit_price']);
      $amount = convert_to_html($row['amount']);
      $cart_status = convert_to_html($row['cart_status']);

    
        // 顯示『cart_status』欄位的選項值及文字
        $str_cart_status = "(" . $cart_status. ") " . $a_cart_status[$cart_status];
        

   
   $data .= <<< HEREDOC
     <tr>
        <td>{$uid}</td>
        <td>{$tran_code}</td>
        <td>{$account}</td>
        <td>{$prod_code}</td>
        <td>{$unit_price}</td>
        <td>{$amount}</td>
        <td>{$str_cart_status}</td>

       <td><a href="cart_display.php?uid=$uid">詳細</a></td>
       <td><a href="cart_edit.php?uid=$uid">修改</a></td>
       <td><a href="cart_delete.php?uid=$uid" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
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
        <th>訂單代碼</th>
        <th>客戶代碼</th>
        <th>產品代碼</th>
        <th>單價</th>
        <th>數量</th>
        <th>項目狀態</th>

      <th colspan="3" align="center"><a href="cart_add.php">新增記錄</a></th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>