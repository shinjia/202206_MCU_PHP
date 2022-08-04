<?php

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
<form action="cust_add_save.php" method="post">
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

include 'pagemake.php';
pagemake($html, '');
?>