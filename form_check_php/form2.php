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

<script>

document.getElementById('form1').onsubmit = function(){ return check_data(); };

function check_data()
{
   var flag = true;
   
   // 各個位置的錯誤訊息
   var msg_receiver = '';
   var msg_phone = '';
   var msg_sure = '';
   

   // 檢查收件者 (不能為空白)
   var receiver = document.getElementById('receiver');
   if( receiver.value == '' )
   {
      flag = false;
      msg_receiver = '收件者不能為空白';
   }


   // 檢查電話號碼 (不能為空白)
   var phone = document.getElementById('phone');
   if( phone.value=='' )
   {
      flag = false;
      msg_phone = '電話號碼有誤';
   }


   // 確認欄必須打勾
   var sure = document.getElementById('sure');
   if(!sure.checked)
   {
      flag = false;
      msg_sure = '確認欄必須打勾';
   }
   

   // 總結處理
   if(!flag)
   {
      document.getElementById('msg_receiver').innerHTML = msg_receiver;
      document.getElementById('msg_phone').innerHTML = msg_phone;
      document.getElementById('msg_sure').innerHTML = msg_sure;
   }
   
   return flag;
}
</script>
</body>
</html>
HEREDOC;

echo $html;
?>