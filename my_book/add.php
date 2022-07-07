<?php

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍資料系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h2 align="center">新增資料區</h2>

<form action="add_save.php" method="post">
  <p>書碼：<input type="text" name="bookcode"></p>
  <p>書名：<input type="text" name="bookname"></p>
  <p>內容：<input type="text" name="descr"></p>
  <p>作者：<input type="text" name="author"></p>
  <p>出版社：<input type="text" name="publish"></p>
  <p>出版日：<input type="text" name="pub_date"></p>
  <p>價格：<input type="text" name="price"></p>
  <p>照片：<input type="text" name="picture"></p>
  <p>備註：<input type="text" name="remark"></p>
  <input type="submit" value="新增">
</form>

</body>
</html>
HEREDOC;

echo $html;
?>