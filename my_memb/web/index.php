<?php

$html = <<< HEREDOC
<h2>程式測試</h2>
<h3>所有訪客均能使用的程式</h3>
<ul>
    <li><a href="signup.php">申請加入會員 (signup, signup_save, signup_after)</a></li>
    <li><a href="signup_verify.php">驗証 (必須從email裡的連結執行) (signup_verify)</a></li>
    <li></li>
    <li><a href="login.php">登入 (login)</a></li>
    <li><a href="logout.php">登出 (logout)</a></li>
</ul>
<br>
<h3>僅限會員能使用的程式</h3>
<ul>
    <li><a href="display_data.php">顯示會員基本資料 (display_data)</a></li>
    <li></li>
    <li><a href="edit_data.php">修改會員基本資料 (edit_data, edit_data_save)</a></li>
    <li><a href="edit_password.php">修改會員密碼 (edit_password, edit_password_save)</a></li>
    <li></li>
    <li><a href="edit_photo.php">大頭貼照片上傳 (edit_photo, edit_photo_save)</a></li>
    <li><a href="image_display.php">會員圖集管理 (image_display, image_save, image_delete)</a></li>
</ul>

<h3>會員有關表單的程式</h3>
<ul>
    <li><a href="mform_add.php">新增表單 (mform_add)</a></li>
    <li><a href="mform_list_all.php">統計並列出各個月份的表單數量 (mform_list_all)</a></li>
</ul>

HEREDOC;

include 'pagemake.php';
pagemake($html);
?>