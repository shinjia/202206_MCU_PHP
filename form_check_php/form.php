<?php


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Form Check</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
.message {color:#C00; background-color:#FF0;}
</style>
</head>

<body>
<h2>寄件資料輸入</h2>
<form id="form1" method="post" action="result.php">
  <p>姓名：
    <input type="text" name="receiver" id="receiver" />
    <span id="msg_receiver" class="message"></span>
  </p>
  <p>電話：
      <input type="text" name="phone" id="phone"  />
      <span id="msg_phone" class="message"></span>
  </p>
  <p>確認：
      <input type="checkbox" name="sure" id="sure" value="Y" />
      <span id="msg_sure" class="message"></span>
  </p>
  <p>
    <input type="submit" value="送出" />
  </p>
</form>

<script src="check.js"></script>
</body>
</html>
HEREDOC;

echo $html;
?>