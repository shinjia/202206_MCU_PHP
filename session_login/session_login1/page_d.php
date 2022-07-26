<?php
session_start();

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';

$a_valid_usertype = array('MEMBER', 'ADMIN');  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype))
{
    header('Location: login_error.php');
    exit;
}


$html = <<< HEREDOC
<h2>會員及管理者均可使用</h2>
<p>這一支程式可讓『會員』或『管理者』執行</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>