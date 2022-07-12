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