<?php

function pagemake($content="", $head="")
{  
  $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
<link rel="stylesheet" href="styles.css">
{$head}
</head>
<body>

<table width="760" border="0" bgcolor="#AAFFEE" align="center">
  <tr>
    <td><H1>資料管理系統</H1></td>
  </tr>
  <tr>
    <td bgcolor="#FF9900">
    	 <a href="cart_index.php" target="_top">首頁</a> | db2系列：
    	 <a href="page.php?op=PAGE&code=note2">說明</a> |    	 
    	 <a href="cart_list_page.php">資料列表</a> |
    	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;db3系列：
    	 <a href="cart_manage.php?op=PAGE&code=note3">說明</a> | 
    	 <a href="cart_manage.php?op=LIST_PAGE">集中系列(db3)</a> |
    </td>
  </tr>
  <tr>
    <td>
    	{$content}
    	<p>&nbsp;</p>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FF9900"><p align="center">版權聲明</p></td>
  </tr>
</table>
</body>
</html>  
HEREDOC;

echo $html;
}

?>