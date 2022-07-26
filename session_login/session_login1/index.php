<?php
session_start();

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';


switch($ss_usertype)
{
    case 'ADMIN' :
    case 'MEMBER' :
            $msg = '<p>Hi，<span style="color:#FF0000;">' . $ss_usercode . '</span> 您好，</p>';
            break;
            
    default:
            $msg = '你尚未登入系統，請 <a href="login.php">按這裡</a> 登入！';
}


$html = <<< HEREDOC
<p>{$msg}</p>
<p>主要程式類型如下</p>
<ul>
    <li><a href="page_a.php">page_a</a>---任何人均可觀看之網頁</li>
    <li><a href="page_b.php">page_b</a>---只有會員可用之網頁</li>
    <li><a href="page_c.php">page_c</a>---系統管理者可用之網頁</li>
    <li><a href="page_d.php">page_d</a>---系統管理者及會員均可用之網頁</li>
</ul>
<hr>
<p>測試網頁</p>
<p>
    <a href="view_session.php">查看session變數</a><br>
    <a href="login.php">重新登入</a><br>
    <a href="logout.php">登出</a>
</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>