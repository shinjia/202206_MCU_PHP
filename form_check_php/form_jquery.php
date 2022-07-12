<?php

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>表單檢查 (jQuery)</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.message {
  color: #FFFF00;
  background-color: #FF0000;
}
</style>
</head>

<body>
<h2>各種表單元件的資料檢查 (jQuery)</h2>
<form method="post" action="result.php">

  <h3>問題一：姓名不得為空白 (文字欄位 text)</h3>
  <p>姓名
    <input type="text" name="nickname" id="nickname">
    <span id="msg_nickname" class="message"></span>
  </p>

  
  <h3>問題二：確認必須打勾 (核取方塊 checkbox)</h3>
  <p>確認 
    <input type="checkbox" name="sure" id="sure" value="Y">
    <span id="msg_sure" class="message"></span>
  </p>
  
  
  <h3>問題三：血型必須有選擇 (選項按鈕 radio)</h3>
  <p>血型<br />
    <input type="radio" name="blood" id="blood1" value="A">A
    <input type="radio" name="blood" id="blood2" value="B">B
    <input type="radio" name="blood" id="blood3" value="O">O
    <input type="radio" name="blood" id="blood4" value="AB">AB
    <span id="msg_blood" class="message"></span>
  </p>
    
  
  <h3>問題四：職業必須有選擇 (下拉清單 select)</h3>
  <p>職業
    <select name="job" id="job">
      <option value="X" SELECTED>請下拉選擇一項</option>
      <option value="1">學生</option>
      <option value="2">上班族</option>
      <option value="3">家管</option>
      <option value="4">自由業</option>
      <option value="5">其他</option>
    </select>
    <span id="msg_job" class="message"></span>
  </p>
  
  
  <h3>問題五：備註必須有內容 (文字方塊 textarea)</h3>
  <p>備註
    <textarea name="memo" id="memo" cols="30" rows="3"></textarea>
    <span id="msg_memo" class="message"></span>
  </p>
  
  
  <p><input type="submit" value="送出資料"></p>
</form>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src="check_jquery.js"></script>


</body>
</html>
HEREDOC;

echo $html;
?>