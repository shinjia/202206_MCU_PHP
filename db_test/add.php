<?php

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h2>新增資料區</h2>
<p>請在下列欄位輸入資料後按下『新增』按鈕。</p>
<form action="add_save.php" method="post">
<p>
  代碼：<input type="text" name="usercode"><br />
  姓名：<input type="text" name="username"><br />
  地址：<input type="text" name="address"><br />
  生日：<input type="text" name="birthday"><br />
  身高：<input type="text" name="height"><br />
  體重：<input type="text" name="weight"><br />
  備註：<input type="text" name="remark"><br />
</p>
<p><input type="submit" value="新增"></p>
</form>
</body>
</html>
HEREDOC;

echo $html;
?>
