<?php
$cc_style = isset($_COOKIE["style"]) ? $_COOKIE["style"] : "";

$file_css = "css/" . $cc_style . ".css";


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="{$file_css}" type="text/css">
</head>
<body>
<h1>大標題</h1>
<table border="1">
	<tr>
		<th>表格標題一</th>
		<th>表格標題二</th>
	</tr>
	<tr>
		<td>假字 假字 假字 假字 假字 </td>
		<td>假字 假字 假字 假字 假字 </td>
	</tr>
	<tr>
		<td>假字 假字 假字 假字 假字 </td>
		<td>假字 假字 假字 假字 假字 </td>
	</tr>
</table>

<form method="post" action="cookie3_save.php">
  請選擇你喜歡的CSS style定義
  <select name="style">
    <option>green</option>
    <option>grey</option>
    <option>ocean</option>
    <option>sky</option>
    <option>pnk</option>
    <option>black</option>
  </select>
  <input type="submit" value="更換Style樣式">
</form>

</body>
</html>
HEREDOC;

echo $html;
?>