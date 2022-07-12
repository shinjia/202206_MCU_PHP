
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