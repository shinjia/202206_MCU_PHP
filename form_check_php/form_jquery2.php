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
<script>
/* https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js */

$(function() {
  
    $('form').submit(function(event) {
      
       var flag = true;
      
       var msg_nickname = '';
       var msg_sure = '';
       var msg_blood = '';
       var msg_job = '';
       var msg_memo = '';
       
 
       // ---------- Check 1 ----------
        // 檢查姓名 (文字欄位必須有值)
        if($('#nickname').val()=='')
        {
           flag = false;
           msg_nickname = '姓名不能為空白';
        }
 
   
       // ---------- Check 2 ----------
       // 檢查確認 (核取方塊checkbox必須勾選) 
       if(!$('#sure').prop('checked'))
       {
          flag = false;
          msg_sure = '請勾選確認欄';
       }
 
     
       // ---------- Check 3 ----------
       // 檢查血型 (選項欄位radio必須有選擇)
       // 因同一組radio選項，故須特別注意各個name是相同，但各個id屬性值均不同
    
       // 方法1：使用 id 屬性
       // 逐一檢查
       var is_choice = false;
       if($('#blood1').prop('checked')) is_choice = true;
       if($('#blood2').prop('checked')) is_choice = true;
       if($('#blood3').prop('checked')) is_choice = true;
       if($('#blood4').prop('checked')) is_choice = true;
    
       if(!is_choice)
       {
          flag = false;
          msg_blood = '血型一定要選一種 (方法1)';
       }
   
       // 方法2：使用 name 屬性
       // 因同一組radio選項，有相同名稱，形成陣列，故須以迴圈取得陣列中各個元素
     
       var is_choice = false;
       var b = $('input[name=blood]');
       for(i in b)
       {
          if(b[i].checked)
          {
             is_choice = true;
          }    
       }
      
       if(!is_choice)
       {
          flag = false;
          msg_blood += '(方法2)';
       }
 
  
       // ---------- Check 4 ----------
       // 檢查職業欄 (選項欄位select一定要選)
       if($('#job').val()=="X")
       {
             flag = false;
             msg_job = '職業一定要選一種';
       }
 
   
       // ---------- Check 5 ----------
       // 檢查備註欄位 (文字方塊必須要有內容，和text相同)
       if($('#memo').val()=='')
       {
          flag = false;
          msg_memo = '備註不能為空白';
       }
   
       // 最後處理
       if(!flag) 
       {
          $('#msg_nickname').html(msg_nickname);
          $('#msg_sure').html(msg_sure);
          $('#msg_blood').html(msg_blood);
          $('#msg_job').html(msg_job);
          $('#msg_memo').html(msg_memo);
         
          event.preventDefault();
       }
      
    });
 
 });
</script>

</body>
</html>
HEREDOC;

echo $html;
?>