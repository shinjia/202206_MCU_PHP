<?php
session_start();

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';


$html = <<< HEREDOC
<p>此程式為查看session的變數內容，謹供程式開發測試用。</p>
<ul>
    <li>usertype: {$ss_usertype}</li>
    <li>usercode: {$ss_usercode}</li>
</ul>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>