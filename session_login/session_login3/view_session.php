<?php
session_start();

include 'define.php';

$ss_usertype = isset($_SESSION[SYSTEM_CODE.'usertype']) ? $_SESSION[SYSTEM_CODE.'usertype'] : '';
$ss_usercode = isset($_SESSION[SYSTEM_CODE.'usercode']) ? $_SESSION[SYSTEM_CODE.'usercode'] : '';

$system_code = SYSTEM_CODE;

$html = <<< HEREDOC
<p>此程式為查看session的變數內容，謹供程式開發測試用。</p>
<p>SYSTEM_CODE: <span style="color:#FF0000;">{$system_code}</span>
<ul>
    <li><span style="color:#FF0000;">{$system_code}</span>usertype: {$ss_usertype}</li>
    <li><span style="color:#FF0000;">{$system_code}</span>usercode: {$ss_usercode}</li>
</ul>

<h3>系統內存放的 SESSION 變數</h3>
HEREDOC;

$html .= '<pre>';
$html .= print_r($_SESSION, true);
$html .= '</pre>';

include 'pagemake.php';
pagemake($html);
?>