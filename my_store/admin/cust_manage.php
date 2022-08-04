<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$op  = isset($_GET['op']) ? $_GET['op'] : 'HOME'; 

$uid = (isset($_POST['uid'])) ? $_POST['uid']+0 : (isset($_GET['uid'])?$_GET['uid']+0:'');

$code = isset($_GET['code']) ? $_GET['code'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 15;

$account = (isset($_POST['account']))  ? $_POST['account']  : '';
$password = (isset($_POST['password']))  ? $_POST['password']  : '';
$forget_q = (isset($_POST['forget_q']))  ? $_POST['forget_q']  : '';
$forget_a = (isset($_POST['forget_a']))  ? $_POST['forget_a']  : '';
$nickname = (isset($_POST['nickname']))  ? $_POST['nickname']  : '';
$realname = (isset($_POST['realname']))  ? $_POST['realname']  : '';
$gentle = (isset($_POST['gentle']))  ? $_POST['gentle']  : '';
$birthday = (isset($_POST['birthday']))  ? $_POST['birthday']  : '';
$blood = (isset($_POST['blood']))  ? $_POST['blood']  : '';
$job = (isset($_POST['job']))  ? $_POST['job']  : '';
$interest = (isset($_POST['interest']))  ? $_POST['interest']  : '';
$zipcode = (isset($_POST['zipcode']))  ? $_POST['zipcode']  : '';
$address = (isset($_POST['address']))  ? $_POST['address']  : '';
$telephone = (isset($_POST['telephone']))  ? $_POST['telephone']  : '';
$email = (isset($_POST['email']))  ? $_POST['email']  : '';
$epaper = (isset($_POST['epaper']))  ? $_POST['epaper']  : '';
$level = (isset($_POST['level']))  ? $_POST['level']  : '';
$lastlogin = (isset($_POST['lastlogin']))  ? $_POST['lastlogin']  : '';


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

switch($op)
{
   case 'LIST_PAGE' :
        $url_page = '?op=LIST_PAGE';

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
        $str_gentle = "(" . $gentle. ") " . (isset($a_gentle[$gentle])?$a_gentle[$gentle]:'');
        
        // 顯示『blood』欄位的選項值及文字
        $str_blood = "(" . $blood. ") " . (isset($a_blood[$blood])?$a_blood[$blood]:'');
        
        // 顯示『job』欄位的選項值及文字
        $str_job = "(" . $job. ") " . (isset($a_job[$job])?$a_job[$job]:'');
        
        // 顯示『epaper』欄位的核選值及文字
        $str_epaper = isset($a_epaper[$epaper]) ? $a_epaper[$epaper] : "*無勾選*";
        
        // 顯示『level』欄位的選項值及文字
        $str_level = "(" . $level. ") " . (isset($a_level[$level])?$a_level[$level]:'');
        

           
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



        // 處理『gentle』欄位的 RADIO 選項
        $radio_gentle = '';
        foreach($a_gentle as $key=>$value)
        {
           $radio_gentle .= '<input type="radio" name="gentle" value="' . $key . '">' . $value;
        }

        // 處理『blood』欄位的 RADIO 選項
        $radio_blood = '';
        foreach($a_blood as $key=>$value)
        {
           $radio_blood .= '<input type="radio" name="blood" value="' . $key . '">' . $value;
        }

        // 處理『job』欄位的 Select..Option 選項
        $select_job = '<select name="job">';
        foreach($a_job as $key=>$value)
        {
        	 $select_job .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $select_job .= '</select>';
        
        // 處理『epaper』欄位的 Checkbox 選項
        foreach($a_epaper as $key=>$value)
        {
           $checkbox_epaper = '<input type="checkbox" name="epaper" value="' . $key . '" />' . $value;
        }

        // 處理『level』欄位的 RADIO 選項
        $radio_level = '';
        foreach($a_level as $key=>$value)
        {
           $radio_level .= '<input type="radio" name="level" value="' . $key . '">' . $value;
        }



        $html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="?op=ADD_SAVE" method="post">
<table>
    <tr><th>帳號</th><td><input type="text" name="account" value="" /></td></tr>
    <tr><th>密碼</th><td><input type="password" name="password" value="" /></td></tr>
    <tr><th>改密碼Ｑ</th><td><input type="text" name="forget_q" value="" /></td></tr>
    <tr><th>改密碼Ａ</th><td><input type="password" name="forget_a" value="" /></td></tr>
    <tr><th>暱稱</th><td><input type="text" name="nickname" value="" /></td></tr>
    <tr><th>真實姓名</th><td><input type="text" name="realname" value="" /></td></tr>
    <tr><th>性別</th><td>{$radio_gentle}</td></tr>
    <tr><th>生日</th><td><input type="text" name="birthday" value="" />**日期格式 Y-m-d**</td></tr>
    <tr><th>血型</th><td>{$radio_blood}</td></tr>
    <tr><th>職業</th><td>{$select_job}</td></tr>
    <tr><th>興趣</th><td><input type="text" name="interest" value="" /></td></tr>
    <tr><th>郵遞區號</th><td><input type="text" name="zipcode" value="" /></td></tr>
    <tr><th>地址</th><td><input type="text" name="address" value="" /></td></tr>
    <tr><th>電話</th><td><input type="text" name="telephone" value="" /></td></tr>
    <tr><th>電子郵件</th><td><input type="text" name="email" value="" /></td></tr>
    <tr><th>收電子報</th><td>{$checkbox_epaper}</td></tr>
    <tr><th>等級</th><td>{$radio_level}</td></tr>
    <tr><th>最後登錄</th><td><input type="text" name="lastlogin" value="" />**日期格式 Y-m-d**</td></tr>

</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;
        break;
        
       
        
   case 'ADD_SAVE' :
        // 寫出 SQL 語法
       $sqlstr = "INSERT INTO customer(account, password, forget_q, forget_a, nickname, realname, gentle, birthday, blood, job, interest, zipcode, address, telephone, email, epaper, level, lastlogin) VALUES (:account, :password, :forget_q, :forget_a, :nickname, :realname, :gentle, :birthday, :blood, :job, :interest, :zipcode, :address, :telephone, :email, :epaper, :level, :lastlogin)";
       
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':password', $password, PDO::PARAM_STR);
$sth->bindParam(':forget_q', $forget_q, PDO::PARAM_STR);
$sth->bindParam(':forget_a', $forget_a, PDO::PARAM_STR);
$sth->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$sth->bindParam(':realname', $realname, PDO::PARAM_STR);
$sth->bindParam(':gentle', $gentle, PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':blood', $blood, PDO::PARAM_STR);
$sth->bindParam(':job', $job, PDO::PARAM_STR);
$sth->bindParam(':interest', $interest, PDO::PARAM_STR);
$sth->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
$sth->bindParam(':address', $address, PDO::PARAM_STR);
$sth->bindParam(':telephone', $telephone, PDO::PARAM_STR);
$sth->bindParam(':email', $email, PDO::PARAM_STR);
$sth->bindParam(':epaper', $epaper, PDO::PARAM_STR);
$sth->bindParam(':level', $level, PDO::PARAM_STR);
$sth->bindParam(':lastlogin', $lastlogin, PDO::PARAM_STR);

        
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
        $sqlstr = "SELECT * FROM customer WHERE uid=:uid ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);

        // 執行 SQL
        if($sth->execute())
        {
           // 成功執行 query 指令
           if($row = $sth->fetch(PDO::FETCH_ASSOC))
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
        $str_gentle = "(" . $gentle. ") " . (isset($a_gentle[$gentle])?$a_gentle[$gentle]:'');
        
        // 顯示『blood』欄位的選項值及文字
        $str_blood = "(" . $blood. ") " . (isset($a_blood[$blood])?$a_blood[$blood]:'');
        
        // 顯示『job』欄位的選項值及文字
        $str_job = "(" . $job. ") " . (isset($a_job[$job])?$a_job[$job]:'');
        
        // 顯示『epaper』欄位的核選值及文字
        $str_epaper = isset($a_epaper[$epaper]) ? $a_epaper[$epaper] : "*無勾選*";
        
        // 顯示『level』欄位的選項值及文字
        $str_level = "(" . $level. ") " . (isset($a_level[$level])?$a_level[$level]:'');
        

        

           $data = <<< HEREDOC
                <table>
           <tr><th>帳號</th><td>{$account}</td></tr>
   <tr><th>密碼</th><td>$str_password</td></tr>
   <tr><th>改密碼Ｑ</th><td>{$forget_q}</td></tr>
   <tr><th>改密碼Ａ</th><td>$str_forget_a</td></tr>
   <tr><th>暱稱</th><td>{$nickname}</td></tr>
   <tr><th>真實姓名</th><td>{$realname}</td></tr>
   <tr><th>性別</th><td>{$str_gentle}</td></tr>
   <tr><th>生日</th><td>{$birthday}</td></tr>
   <tr><th>血型</th><td>{$str_blood}</td></tr>
   <tr><th>職業</th><td>{$str_job}</td></tr>
   <tr><th>興趣</th><td>{$interest}</td></tr>
   <tr><th>郵遞區號</th><td>{$zipcode}</td></tr>
   <tr><th>地址</th><td>{$address}</td></tr>
   <tr><th>電話</th><td>{$telephone}</td></tr>
   <tr><th>電子郵件</th><td>{$email}</td></tr>
   <tr><th>收電子報</th><td>{$str_epaper}</td></tr>
   <tr><th>等級</th><td>{$str_level}</td></tr>
   <tr><th>最後登錄</th><td>{$lastlogin}</td></tr>

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
        $sqlstr = "SELECT * FROM customer WHERE uid=:uid ";
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':uid', $uid, PDO::PARAM_INT);

        // 執行SQL及處理結果
        if($sth->execute())
        {
           // 成功執行 query 指令
           if($row = $sth->fetch(PDO::FETCH_ASSOC))
           {
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

        // 處理『gentle』欄位的 RADIO 選項
        $radio_gentle = '';
        foreach($a_gentle as $key=>$value)
        {
        	$str_checked = ($gentle==$key) ? ("checked") : ("");
           $radio_gentle .= '<input type="radio" name="gentle" value="' . $key . '" ' . $str_checked . '>' . $value;
        }

        // 處理『blood』欄位的 RADIO 選項
        $radio_blood = '';
        foreach($a_blood as $key=>$value)
        {
        	$str_checked = ($blood==$key) ? ("checked") : ("");
           $radio_blood .= '<input type="radio" name="blood" value="' . $key . '" ' . $str_checked . '>' . $value;
        }

        // 處理『job』欄位的 SELECT..OPTION 選項
        $select_job = '<select name="job">';
        foreach($a_job as $key=>$value)
        {
        	  $str_selected = ($job==$key) ? ("selected") : ("");
           $select_job .= '<option value="' . $key . '" ' . $str_selected . '>' . $value . '</option>';
        }
        $select_job .= '</select>';
        
        // 處理『epaper』欄位的 Checkbox 選項
        $checkbox_epaper = '';
        $str_checked = (isset($a_epaper[$epaper])) ? ("checked") : ("");
        foreach($a_epaper as $key=>$value)
        {
           $checkbox_epaper .= '<input type="checkbox" name="epaper" value="' . $key . '" ' . $str_checked . ' />' . $value;
        }

        // 處理『level』欄位的 RADIO 選項
        $radio_level = '';
        foreach($a_level as $key=>$value)
        {
        	$str_checked = ($level==$key) ? ("checked") : ("");
           $radio_level .= '<input type="radio" name="level" value="' . $key . '" ' . $str_checked . '>' . $value;
        }


              
              $data = <<< HEREDOC
              <form action="?op=EDIT_SAVE" method="post">
              <table>
                <tr><th>帳號</th><td><input type="text" name="account" value="{$account}" /></td></tr>
        <tr><th>密碼</th><td><input type="password" name="password" value="{$password}" />**密碼欄位應該在修改程式中刪除**</td></tr>
        <tr><th>改密碼Ｑ</th><td><input type="text" name="forget_q" value="{$forget_q}" /></td></tr>
        <tr><th>改密碼Ａ</th><td><input type="password" name="forget_a" value="{$forget_a}" />**密碼欄位應該在修改程式中刪除**</td></tr>
        <tr><th>暱稱</th><td><input type="text" name="nickname" value="{$nickname}" /></td></tr>
        <tr><th>真實姓名</th><td><input type="text" name="realname" value="{$realname}" /></td></tr>
        <tr><th>性別</th><td>{$radio_gentle}</td></tr>
        <tr><th>生日</th><td><input type="text" name="birthday" value="{$birthday}" />**輸入日期格式Y-m-d**</td></tr>
        <tr><th>血型</th><td>{$radio_blood}</td></tr>
        <tr><th>職業</th><td>{$select_job}</td></tr>
        <tr><th>興趣</th><td><input type="text" name="interest" value="{$interest}" /></td></tr>
        <tr><th>郵遞區號</th><td><input type="text" name="zipcode" value="{$zipcode}" /></td></tr>
        <tr><th>地址</th><td><input type="text" name="address" value="{$address}" /></td></tr>
        <tr><th>電話</th><td><input type="text" name="telephone" value="{$telephone}" /></td></tr>
        <tr><th>電子郵件</th><td><input type="text" name="email" value="{$email}" /></td></tr>
        <tr><th>收電子報</th><td>{$checkbox_epaper}</td></tr>
        <tr><th>等級</th><td>{$radio_level}</td></tr>
        <tr><th>最後登錄</th><td><input type="text" name="lastlogin" value="{$lastlogin}" />**輸入日期格式Y-m-d**</td></tr>

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
        $sqlstr = "UPDATE customer SET account=:account, password=:password, forget_q=:forget_q, forget_a=:forget_a, nickname=:nickname, realname=:realname, gentle=:gentle, birthday=:birthday, blood=:blood, job=:job, interest=:interest, zipcode=:zipcode, address=:address, telephone=:telephone, email=:email, epaper=:epaper, level=:level, lastlogin=:lastlogin WHERE uid=:uid " ;
        
        $sth = $pdo->prepare($sqlstr);
        $sth->bindParam(':account', $account, PDO::PARAM_STR);
$sth->bindParam(':password', $password, PDO::PARAM_STR);
$sth->bindParam(':forget_q', $forget_q, PDO::PARAM_STR);
$sth->bindParam(':forget_a', $forget_a, PDO::PARAM_STR);
$sth->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$sth->bindParam(':realname', $realname, PDO::PARAM_STR);
$sth->bindParam(':gentle', $gentle, PDO::PARAM_STR);
$sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$sth->bindParam(':blood', $blood, PDO::PARAM_STR);
$sth->bindParam(':job', $job, PDO::PARAM_STR);
$sth->bindParam(':interest', $interest, PDO::PARAM_STR);
$sth->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
$sth->bindParam(':address', $address, PDO::PARAM_STR);
$sth->bindParam(':telephone', $telephone, PDO::PARAM_STR);
$sth->bindParam(':email', $email, PDO::PARAM_STR);
$sth->bindParam(':epaper', $epaper, PDO::PARAM_STR);
$sth->bindParam(':level', $level, PDO::PARAM_STR);
$sth->bindParam(':lastlogin', $lastlogin, PDO::PARAM_STR);

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
        $sqlstr = "DELETE FROM customer WHERE uid=:uid ";
        
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
