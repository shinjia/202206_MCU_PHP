<?php

function pagemake($content)
{  
  $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="760" border="0" bgcolor="#FFFF99" align="center">
  <tr>
    <td><H1>資料管理系統</H1></td>
  </tr>
  <tr>
    <td bgcolor="#FF99AA">後台管理 |
    	 <a href="cust_manage.php?op=LIST_PAGE">customer</a> | 
    	 <a href="prod_manage.php?op=LIST_PAGE">product</a> | 
    	 <a href="tran_manage.php?op=LIST_PAGE">tran</a> | 
    	 <a href="cart_manage.php?op=LIST_PAGE">cart</a> | 
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