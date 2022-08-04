<?php
include '../common/config.php';
include '../common/utility.php';

$op  = isset($_GET['op']) ? $_GET['op'] : 'HOME'; 

$uid = (isset($_POST['uid'])) ? $_POST['uid']+0 : (isset($_GET['uid'])?$_GET['uid']+0:'');

$code = isset($_GET['code']) ? $_GET['code'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 15;

$tran_code = (isset($_POST['tran_code']))  ? $_POST['tran_code']  : '';
$account = (isset($_POST['account']))  ? $_POST['account']  : '';
$tran_date = (isset($_POST['tran_date']))  ? $_POST['tran_date']  : '';
$fee_product = (isset($_POST['fee_product']))  ? $_POST['fee_product']  : '';
$fee_delivery = (isset($_POST['fee_delivery']))  ? $_POST['fee_delivery']  : '';
$total_price = (isset($_POST['total_price']))  ? $_POST['total_price']  : '';
$notes = (isset($_POST['notes']))  ? $_POST['notes']  : '';
$tran_status = (isset($_POST['tran_status']))  ? $_POST['tran_status']  : '';


// 設定欄位『tran_status』的值域選項
$a_tran_status = array(
      "ORDER"=>"訂購",
      "PROC"=>"處理中",
      "CLOSE"=>"結案" );



// 連接資料庫
$pdo = db_open();

switch($op)
{
   case 'LIST_PAGE' :
        $url_page = '?op=LIST_PAGE';

        // 取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
        $sqlstr = "SELECT count(*) as total_rec FROM tran ";
        $sth = $pdo->query($sqlstr);
        if($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
           $total_rec = $row["total_rec"];
        }
        $total_page = ceil($total_rec / $numpp);  // 計算總頁數
        $tmp_start = ($page-1) * $numpp;  // 從第幾筆記錄開始抓取資料
        
        // 寫出 SQL 語法
        $sqlstr = "SELECT * FROM tran ";
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
      $tran_date = convert_to_html($row['tran_date']);
      $fee_product = convert_to_html($row['fee_product']);
      $fee_delivery = convert_to_html($row['fee_delivery']);
      $total_price = convert_to_html($row['total_price']);
      $notes = convert_to_html($row['notes']);
      $tran_status = convert_to_html($row['tran_status']);

            
                // 顯示『notes』欄位的文字區域文字
        $str_notes = nl2br($notes);

        // 顯示『tran_status』欄位的選項值及文字
        $str_tran_status = "(" . $tran_status. ") " . $a_tran_status[$tran_status];
        

           
           $data .= <<< HEREDOC
             <tr>
                <td>{$uid}</td>
        <td>{$tran_code}</td>
        <td>{$account}</td>
        <td>{$tran_date}</td>
        <td>{$fee_product}</td>
        <td>{$fee_delivery}</td>
        <td>{$total_price}</td>
        <td>{$str_notes}</td>
        <td>{$str_tran_status}</td>

               <td><a href="?op=DISPLAY&uid=$uid">詳細</a></td>
               <td><a href="?op=EDIT&uid=$uid">修改</a></td>
               <td><a href="?op=DELETE&uid=$uid" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
            </tr>
HEREDOC;
            }
        
        // ------ 分頁處理開始 -------------------------------------
        // 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
        $lnk_pageprev = '?op=LIST_PAGE&page=' . (($page==1)?(1):($page-1));
        $lnk_pagenext = '?op=LIST_PAGE&page=' . (($page==$total_page)?($total_page):($page+1));
        $lnk_pagehead = '?op=LIST_PAGE&page=1';
        $lnk_pagelast = '?op=LIST_PAGE&page=' . $total_page;
        
        // 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
        $lnk_pagelist = "";
        for($i=1; $i<=$page-1; $i++)
        { $lnk_pagelist .= '<a href="?op=LIST_PAGE&page='.$i.'">'.$i.'</a> '; }
        $lnk_pagelist .= '[' . $i . ']';
        for($i=$page+1; $i<=$total_page; $i++)
        { $lnk_pagelist .= '<a href="?op=LIST_PAGE&page='.$i.'">'.$i.'</a> '; }
        
        // 處理各頁之超連結：下拉式跳頁選單
        $lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
        $lnk_pagegoto .= '<input type="hidden" name="op" value="LIST_PAGE">';
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
        
        // 網頁輸出        
        $html = <<< HEREDOC
        <h2 align="center">資料列表，共有 {$total_rec} 筆記錄</h2>
        {$ihc_navigator}
        <p></p>
        <table border="1" align="center">   
           <tr>
        <th>序號</th>
        <th>訂單代碼</th>
        <th>客戶代碼</th>
        <th>訂單日期</th>
        <th>商品總價</th>
        <th>運費</th>
        <th>總價</th>
        <th>備註事項</th>
        <th>訂單狀態</th>

              <th colspan="3" align="center">[<a href="?op=ADD">新增記錄</a>]</th>
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
        
        break;
        
        
        
   case 'ADD' :
// 設定欄位『tran_status』的值域選項
$a_tran_status = array(
      "ORDER"=>"訂購",
      "PROC"=>"處理中",
      "CLOSE"=>"結案" );



        // 處理『tran_status』欄位的 RADIO 選項
        $radio_tran_status = '';
        foreach($a_tran_status as $key=>$value)
        {
           $radio_tran_status .= '<input type="radio" name="tran_status" value="' . $key . '">' . $value;
        }



        $html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="?op=ADD_SAVE" method="post">
<table>
    <tr><th>訂單代碼</th><td><input type="text" name="tran_code" value="" /></td></tr>
    <tr><th>客戶代碼</th><td><input type="text" name="account" value="" /></td></tr>
    <tr><th>訂單日期</th><td><input type="text" name="tran_date" value="" />**日期格式 Y-m-d**</td></tr>
    <tr><th>商品總價</th><td><input type="text" name="fee_product" value="" /></td></tr>
    <tr><th>運費</th><td><input type="text" name="fee_delivery" value="" /></td></tr>
    <tr><th>總價</th><td><input type="text" name="total_price" value="" /></td></tr>
    <tr><th>備註事項</th><td><textarea name="notes"></textarea></td></tr>
    <tr><th>訂單狀態</th><td>{$radio_tran_status}</td></tr>

</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;
        break;
        
       
        
   case 'ADD_SAVE' :
        // 寫出 SQL 語法
       $sqlstr = "INSERT INTO tran(tran_code, account, tran_date, fee_product, fee_delivery, total_price, notes, tran_status) VALUES (:tran_code, :account, :tran_date, :fee_product, :fee_delivery, :total_price, :notes, :tran_status)";
       
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':tran_code', $tran_code, PDO::PARAM_STR);
$sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':tran_date', $tran_date, PDO::PARAM_STR);
$sth->bindParam(':fee_product', $fee_product, PDO::PARAM_INT);
$sth->bindParam(':fee_delivery', $fee_delivery, PDO::PARAM_INT);
$sth->bindParam(':total_price', $total_price, PDO::PARAM_INT);
$sth->bindParam(':notes', $notes, PDO::PARAM_STR);
$sth->bindParam(':tran_status', $tran_status, PDO::PARAM_STR);

        
        // 執行SQL及處理結果
        if($sth->execute())
        {
           $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
           $url_display = '?op=DISPLAY&uid=' . $new_uid;
           header('Location: ' . $url_display);
        }
        else
        {
           header('Location: ?op=ERROR');
           echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit;  // 此列供開發時期偵錯用
        }
        break;
       
       
        
   case 'DISPLAY' :
        $sqlstr = "SELECT * FROM tran WHERE uid=:uid ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);

        // 執行 SQL
        if($sth->execute())
        {
           // 成功執行 query 指令
           if($row = $sth->fetch(PDO::FETCH_ASSOC))
           {
              $uid = $row['uid'];
              $tran_code = convert_to_html($row['tran_code']);
      $account = convert_to_html($row['account']);
      $tran_date = convert_to_html($row['tran_date']);
      $fee_product = convert_to_html($row['fee_product']);
      $fee_delivery = convert_to_html($row['fee_delivery']);
      $total_price = convert_to_html($row['total_price']);
      $notes = convert_to_html($row['notes']);
      $tran_status = convert_to_html($row['tran_status']);

                // 顯示『notes』欄位的文字區域文字
        $str_notes = nl2br($notes);

        // 顯示『tran_status』欄位的選項值及文字
        $str_tran_status = "(" . $tran_status. ") " . $a_tran_status[$tran_status];
        

           $data = <<< HEREDOC
                <table>
           <tr><th>訂單代碼</th><td>{$tran_code}</td></tr>
   <tr><th>客戶代碼</th><td>{$account}</td></tr>
   <tr><th>訂單日期</th><td>{$tran_date}</td></tr>
   <tr><th>商品總價</th><td>{$fee_product}</td></tr>
   <tr><th>運費</th><td>{$fee_delivery}</td></tr>
   <tr><th>總價</th><td>{$total_price}</td></tr>
   <tr><th>備註事項</th><td>{$str_notes}</td></tr>
   <tr><th>訂單狀態</th><td>{$str_tran_status}</td></tr>

                </table>
HEREDOC;
           }
           else
           {
         	   $data = '查不到相關記錄！';
           }
        }
        else
        {
           // 無法執行 query 指令時
           $data = error_message('display');
        }
        
        $html = <<< HEREDOC
<button onclick="location.href='?op=LIST_PAGE';">返回列表</button>
<h2>詳細資料</h2>
{$data}
HEREDOC;
        break;
        
        
   case 'EDIT' :
        $sqlstr = "SELECT * FROM tran WHERE uid=:uid ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);

        // 執行SQL及處理結果
        if($sth->execute())
        {
           // 成功執行 query 指令
           if($row = $sth->fetch(PDO::FETCH_ASSOC))
           {
              $tran_code = convert_to_html($row['tran_code']);
      $account = convert_to_html($row['account']);
      $tran_date = convert_to_html($row['tran_date']);
      $fee_product = convert_to_html($row['fee_product']);
      $fee_delivery = convert_to_html($row['fee_delivery']);
      $total_price = convert_to_html($row['total_price']);
      $notes = convert_to_html($row['notes']);
      $tran_status = convert_to_html($row['tran_status']);

        
                // 處理『tran_status』欄位的 RADIO 選項
        $radio_tran_status = '';
        foreach($a_tran_status as $key=>$value)
        {
        	$str_checked = ($tran_status==$key) ? ("checked") : ("");
           $radio_tran_status .= '<input type="radio" name="tran_status" value="' . $key . '" ' . $str_checked . '>' . $value;
        }


              
              $data = <<< HEREDOC
              <form action="?op=EDIT_SAVE" method="post">
              <table>
                <tr><th>訂單代碼</th><td><input type="text" name="tran_code" value="{$tran_code}" /></td></tr>
        <tr><th>客戶代碼</th><td><input type="text" name="account" value="{$account}" /></td></tr>
        <tr><th>訂單日期</th><td><input type="text" name="tran_date" value="{$tran_date}" />**輸入日期格式Y-m-d**</td></tr>
        <tr><th>商品總價</th><td><input type="text" name="fee_product" value="{$fee_product}" /></td></tr>
        <tr><th>運費</th><td><input type="text" name="fee_delivery" value="{$fee_delivery}" /></td></tr>
        <tr><th>總價</th><td><input type="text" name="total_price" value="{$total_price}" /></td></tr>
        <tr><th>備註事項</th><td><textarea name="notes">{$notes}</textarea></td></tr>
        <tr><th>訂單狀態</th><td>{$radio_tran_status}</td></tr>

              </table>
              <p>
                <input type="hidden" name="uid" value="{$uid}">
                <input type="submit" value="送出">
              </p>
              </form>
HEREDOC;
           }
           else
           {
         	   $data = '查不到相關記錄！';
           }
        }
        else
        {
           // 無法執行 query 指令時
           $data = error_message('edit');
        }

        $html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>修改資料</h2>
{$data}
HEREDOC;
        break;
        
        
        
   case 'EDIT_SAVE' :
        $sqlstr = "UPDATE tran SET tran_code=:tran_code, account=:account, tran_date=:tran_date, fee_product=:fee_product, fee_delivery=:fee_delivery, total_price=:total_price, notes=:notes, tran_status=:tran_status WHERE uid=:uid " ;
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':tran_code', $tran_code, PDO::PARAM_STR);
$sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':tran_date', $tran_date, PDO::PARAM_STR);
$sth->bindParam(':fee_product', $fee_product, PDO::PARAM_INT);
$sth->bindParam(':fee_delivery', $fee_delivery, PDO::PARAM_INT);
$sth->bindParam(':total_price', $total_price, PDO::PARAM_INT);
$sth->bindParam(':notes', $notes, PDO::PARAM_STR);
$sth->bindParam(':tran_status', $tran_status, PDO::PARAM_STR);

        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
        
        // 執行SQL及處理結果
        if($sth->execute())
        {
           $url_display = '?op=DISPLAY&uid=' . $uid;
           header('Location: ' . $url_display);
        }
        else
        {
           header('Location: ?op=ERROR');
           echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
        }
        break;
        
        

   case 'DELETE' :
        $sqlstr = "DELETE FROM tran WHERE uid=:uid ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);
        
        // 執行SQL及處理結果
        if($sth->execute())
        {
           $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
           header('Location: ' . $refer);
        }
        else
        {
           header('Location: ?op=ERROR');
           echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
        }
        break;



   case 'ERROR' :
        $type = isset($_GET['type']) ? $_GET['type'] : 'default';
        
        $html = error_message($type);
        break;
        
        

   case 'PAGE' :
        $path = 'data/';   // 存放網頁內容的資料夾
        $filename = $path . $code . '.html';  // 規定副檔案為 .htm
        
        if (!file_exists($filename))
        {
        	 // 找不到檔案時的顯示訊息
           $html  = '<p>錯誤：傳遞參數有誤。檔案『' . $filename . '』不存在！</p>';
        }
        else
        {
           $html = join ('', file($filename));   // 讀取檔案內容並組成文字串
        } 
        break;


        
   case 'HOME' : 
        $html = '<p><BR><BR><BR>Welcome...資料管理系統<BR><BR><BR><BR><BR><BR></p>';
        break;
   
   
   
   default :
        $html = '<p><BR><BR><BR>Welcome...資料管理系統<BR><BR><BR><BR><BR><BR></p>';
     
}

$pdo = null;


include 'pagemake.php';
pagemake($html, '');
?>
