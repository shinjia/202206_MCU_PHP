<?php
include 'config.php';
include 'utility.php';

$op  = isset($_GET['op']) ? $_GET['op'] : 'HOME';
$uid = isset($_POST['uid']) ? $_POST['uid'] : (isset($_GET['uid'])?$_GET['uid']:'');

$code = isset($_GET['code']) ? $_GET['code'] : '';

$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$address  = isset($_POST['address'])  ? $_POST['address']  : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$height   = isset($_POST['height'])   ? $_POST['height']   : '';
$weight   = isset($_POST['weight'])   ? $_POST['weight']   : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 15;  // 每頁的筆數


// 連接資料庫
$pdo = db_open();


switch($op)
{
   case 'LIST_PAGE' :
        $url_page = '?op=LIST_PAGE';

        // 處理分頁
        $sqlstr = "SELECT count(*) as total_rec FROM person ";
        $sth = $pdo->query($sqlstr) or die(ERROR_QUERY.'<br />'.print_r($pdo->errorInfo(),TRUE));
        while($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
           $total_rec = $row['total_rec'];
        }
        $total_page = ceil($total_rec / $numpp);  // 計算總頁數       
        $tmp_start = ($page-1) * $numpp;         // 從第幾筆記錄開始抓取資料
        
        // 寫出 SQL 語法 (僅擷取該分頁資料)
        $sqlstr = "SELECT * FROM person ";
        $sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;
        
        // 執行SQL及處理結果
        $data = '';
        $sth = $pdo->query($sqlstr);
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
    <td><a href="?op=DISPLAY&uid={$uid}">詳細</a></td>
    <td><a href="?op=EDIT&uid={$uid}">修改</a></td>
    <td><a href="?op=DELETE&uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
</tr>
HEREDOC;
        }
        
        // ------ 分頁處理開始 -------------------------------------
        // 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
        $lnk_pageprev = $url_page . '&page=' . (($page==1)?(1):($page-1));
        $lnk_pagenext = $url_page . '&page=' . (($page==$total_page)?($total_page):($page+1));
        $lnk_pagehead = $url_page . '&page=1';
        $lnk_pagelast = $url_page . '&page=' . $total_page;
        
        // 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
        $lnk_pagelist = '';
        for($i=1; $i<=$page-1; $i++)
        { $lnk_pagelist .= '<a href="'.$url_page.'&page='.$i.'">'.$i.'</a>'; }
        $lnk_pagelist .= '[' . $i . ']';
        for($i=$page+1; $i<=$total_page; $i++)
        { $lnk_pagelist .= '<a href="'.$url_page.'&page='.$i.'">'.$i.'</a>'; }
        
        // 處理各頁之超連結：下拉式跳頁選單
        $lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
        $lnk_pagegoto .= '<input type="hidden" name="op" value="LIST_PAGE">';
        $lnk_pagegoto .= '<select name="page" onChange="submit();">';
        for($i=1; $i<=$total_page; $i++)
        {
           $is_current = (($i-$page)==0) ? (" SELECTED") : ('');
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
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
{$ihc_navigator}
<p></p>
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
        <th colspan="3" align="center">[<a href="?op=ADD">新增記錄</a>]</th>
    </tr>
    {$data}
</table>
HEREDOC;
        break;
        
        
   case 'ADD' :
        $html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>      
<form action="?op=ADD_SAVE" method="post">
<table>
    <tr><th>代碼</th><td><input type="text" name="usercode" value=''></td></tr>
    <tr><th>姓名</th><td><input type="text" name="username" value=''></td></tr>
    <tr><th>地址</th><td><input type="text" name="address" value=''></td></tr>
    <tr><th>生日</th><td><input type="text" name="birthday" value=''></td></tr>
    <tr><th>身高</th><td><input type="text" name="height" value=''></td></tr>
    <tr><th>體重</th><td><input type="text" name="weight" value=''></td></tr>
    <tr><th>備註</th><td><input type="text" name="remark" value=''></td></tr>
</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;
        break;
        
        
   case 'ADD_SAVE' :
        // 寫出 SQL 語法
        $sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindValue(1, $usercode, PDO::PARAM_STR);
        $sth->bindValue(2, $username, PDO::PARAM_STR);
        $sth->bindValue(3, $address , PDO::PARAM_STR);
        $sth->bindValue(4, $birthday, PDO::PARAM_STR);
        $sth->bindValue(5, $height  , PDO::PARAM_INT);
        $sth->bindValue(6, $weight  , PDO::PARAM_INT);
        $sth->bindValue(7, $remark  , PDO::PARAM_STR);
        
        // 執行SQL及處理結果
        if($sth->execute())
        {
           $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
           $url_display = $url_self . '?op=DISPLAY&uid=' . $new_uid;
           header('Location: ' . $url_display);
        }
        else
        {
           header('Location: ?op=ERROR');
           echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit;  // 此列供開發時期偵錯用
        }
        break;
       
        
   case 'DISPLAY' :
        // 寫出 SQL 語法
        $sqlstr = "SELECT * FROM person WHERE uid=" . $uid;
        
        // 執行 SQL
        $sth = $pdo->query($sqlstr);
        if($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
           $uid = $row['uid'];
           $usercode = convert_to_html($row['usercode']);
           $username = convert_to_html($row['username']);
           $address  = convert_to_html($row['address']);
           $birthday = convert_to_html($row['birthday']);
           $height   = convert_to_html($row['height']);
           $weight   = convert_to_html($row['weight']);
           $remark   = convert_to_html($row['remark']);

           $data = <<< HEREDOC
<table>
    <tr><th>代碼</th><td>{$usercode}</td></tr>
    <tr><th>姓名</th><td>{$username}</td></tr>
    <tr><th>地址</th><td>{$address}</td></tr>
    <tr><th>生日</th><td>{$birthday}</td></tr>
    <tr><th>身高</th><td>{$height}</td></tr>
    <tr><th>體重</th><td>{$weight}</td></tr>
    <tr><th>備註</th><td>{$remark}</td></tr>
</table>
HEREDOC;
        }
        else
        {
        	 $data = '查不到相關記錄！';
        }
        
        $html = <<< HEREDOC
<button onclick="location.href='?op=LIST_PAGE';">返回列表</button>
<h2>詳細資料</h2>
{$data}
<br /><br />
HEREDOC;
        break;
        
        
   case 'EDIT' :
        // 寫出 SQL 語法
        $sqlstr = "SELECT * FROM person WHERE uid=" . $uid;
        
        // 執行SQL及處理結果
        $sth = $pdo->query($sqlstr);
        if($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
           $uid = $row['uid'];
           $usercode = convert_to_html($row['usercode']);
           $username = convert_to_html($row['username']);
           $address  = convert_to_html($row['address']);
           $birthday = convert_to_html($row['birthday']);
           $height   = convert_to_html($row['height']);
           $weight   = convert_to_html($row['weight']);
           $remark   = convert_to_html($row['remark']);

           $data = <<< HEREDOC
<form action="?op=EDIT_SAVE" method="post">
<table>
    <tr><th>代碼</th><td><input type="text" name="usercode" value="{$usercode}"></td></tr>
    <tr><th>姓名</th><td><input type="text" name="username" value="{$username}"></td></tr>
    <tr><th>地址</th><td><input type="text" name="address" value="{$address}"></td></tr>
    <tr><th>生日</th><td><input type="text" name="birthday" value="{$birthday}"></td></tr>
    <tr><th>身高</th><td><input type="text" name="height" value="{$height}"></td></tr>
    <tr><th>體重</th><td><input type="text" name="weight" value="{$weight}"></td></tr>
    <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
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
        	 $data = '查不到相關記錄';
        }

        $html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>修改資料</h2>
{$data}
<br /><br />
HEREDOC;
        break;
        
        
   case 'EDIT_SAVE' :
        // 寫出 SQL 語法
        $sqlstr = "UPDATE person SET usercode=?, username=?, address=?, birthday=?, height=?, weight=?, remark=? WHERE uid=? ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindValue(1, $usercode, PDO::PARAM_STR);
        $sth->bindValue(2, $username, PDO::PARAM_STR);
        $sth->bindValue(3, $address , PDO::PARAM_STR);
        $sth->bindValue(4, $birthday, PDO::PARAM_STR);
        $sth->bindValue(5, $height  , PDO::PARAM_INT);
        $sth->bindValue(6, $weight  , PDO::PARAM_INT);
        $sth->bindValue(7, $remark  , PDO::PARAM_STR);
        $sth->bindValue(8, $uid     , PDO::PARAM_INT);
        
        // 執行SQL及處理結果
        if($sth->execute())
        {
           $url_display = '?op=DISPLAY&uid=' . $uid;
           header('Location: ' . $url_display);
        }
        else
        {
           echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit; // 此列供開發時期偵錯用
           header('Location: ?op=ERROR');
        }
        break;
        

   case 'DELETE' :
        // 寫出 SQL 語法
        $sqlstr = "DELETE FROM person WHERE uid=" . $uid;
        
        // 執行SQL及處理結果
        $sth = $pdo->query($sqlstr);
        if($sth===FALSE)
        {
           header('Location: error.php');
           echo print_r($pdo->errorInfo(),TRUE) . '<br />' . $sqlstr;  // 此列供開發時期偵錯用
        }
        else
        {
           header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        break;


   case 'PAGE' :
        $path = 'data/';   // 存放網頁內容的資料夾
        $filename = $path . $code . '.html';  // 規定副檔案為 .html
        
        if (!file_exists($filename))
        {
        	 // 找不到檔案時的顯示訊息
           $html  = '錯誤：傳遞參數有誤。檔案『' . $filename . '』不存在！';
        }
        else
        {
           $html = join ('', file($filename));   // 讀取檔案內容並組成文字串
        } 
        break;

        
   case 'HOME' : 
        $html = '<p><br><br><br>Welcome...資料管理系統<br><br><br><br><br><br></p>';
        break;
   
   
   default :
        $html = '<p><br><br><br>Welcome...資料管理系統<br><br><br><br><br></p>';
     
}

$pdo = null;

include 'pagemake.php';
pagemake($html, '');
?>
