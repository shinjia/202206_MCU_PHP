<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>測試</title>

<script type="text/javascript" src="jquery.js"></script>
<script>
$(document).ready( function() {

   // $(":checkbox").change
   // $('#btn').click

   $(":checkbox").change( function() {

      $('#showarea').html('loading...');
          
      $.ajax({
        url: 'ajax_getdata.php',
        data: $('#form1').serialize(),
        type: 'POST',
        dataType: 'html',
        success: function(data,textStatus,jqXHR)
        {
          console.log('success');
          var str_data = build(data);
          $('#showarea').html(str_data);
        },
        error: function()
        {
          console.log('error');
          $('#showarea').html('error...');
        },
        complete: function()
        {
          console.log('complete');
          // Do something
        }
        
      });

   });
	

});


function build(s)
{
  var vjson = JSON.parse(s);

  // console.log(vjson);

  var str = '';
  for(i=0; i<vjson.length; i++)
  {
   var s_name  = vjson[i].name;
   var s_pic   = vjson[i].pic;
   var s_descr = vjson[i].descr;
   
    str += '<table width="460" bgcolor="#EEEEEE" border="1" cellspacing="4" cellpadding="2"><tr><td>';
    str += '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr bgcolor="#FFDDFF"><td>';
    str += '<div style="text-align:center;">'+ s_name +'</div>';
    str += '<div style="text-align:center;"><img src="../images/'+ s_pic +'" width="150" style="float:left;"></div>';
    str += '<div style="text-align:left;">'+ s_descr +'</div>';
    str += '</td></tr></table>';
    str += '</td></tr></table>';
    str += '<br>';
  }

  // $('#showarea').html(str);
  return str;
}

</script>
</head>
<body>
<h2>餐點選擇</h2>
<form name="form1" id="form1" method="post" action="">
<p>
<input type="checkbox" name="fd01" value="Y"> 大腸麵線
<input type="checkbox" name="fd02" value="Y"> 魷魚羹
<input type="checkbox" name="fd03" value="Y"> 肉圓
<input type="checkbox" name="fd04" value="Y"> 蚵仔煎
<input type="checkbox" name="fd05" value="Y"> 臭豆腐
<input type="checkbox" name="fd06" value="Y"> 擔仔麵
<input type="checkbox" name="fd07" value="Y"> 米粉湯
<input type="checkbox" name="fd08" value="Y"> 生煎包
<input type="checkbox" name="fd09" value="Y"> 刈包
<input type="checkbox" name="fd10" value="Y"> 珍珠奶茶
</p>
<input type="button" id="btn" value="點餐">
<form>
    
<div id="showarea">......</div>
    
</body>
</html>