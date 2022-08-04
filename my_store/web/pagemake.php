<?php

function pagemake($content)
{  
  $html = <<< HEREDOC
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="760" border="0" bgcolor="#AAEEAA" align="center">
  <tr>
    <td bgcolor="#AACCDD"><H1>資料管理系統</H1></td>
  </tr>
  <tr>
    <td bgcolor="#FF9900">
    	 <a href="index.php">回首頁</a>
	</td>
  </tr>
  <tr>
    <td>
    	{$content}
    	<p>&nbsp;</p>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FF9900"><p align="center">版權沒有．歡迎拷貝</p></td>
  </tr>
</table>
</body>
</html>  
HEREDOC;

echo $html;
}

?>