<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>測試</title>

<script type="text/javascript" src="jquery.js"></script>
<script>
function check_data()
{
    var obj = {};
    
    var formTexts = $('input:text');
    $.map(formTexts, function(n, i) {
        obj[n.name] = $(n).val();
    });

   var formCheckbox = $('input:checkbox');
   $.map(formCheckbox, function(n, i) {
      obj[n.name] = $(n).attr("checked") ? $(n).val() : "false";
   });
 
   var str = JSON.stringify(obj);
   $('#postdata').val(str);  
   return true;
}
</script>
</head>
<body>
<h2>餐點選擇</h2>
<form name="form1" id="form1" method="post" action="getdata.php" onSubmit="return check_data();">
<br><input type="checkbox" name="fd01" id="fd01" value="Y"> 大腸麵線
<br><input type="checkbox" name="fd02" id="fd02" value="Y"> 魷魚羹
<br><input type="checkbox" name="fd03" id="fd03" value="Y"> 肉圓
<br><input type="checkbox" name="fd04" id="fd04" value="Y"> 蚵仔煎
<br><input type="checkbox" name="fd05" id="fd05" value="Y"> 臭豆腐
<br><input type="checkbox" name="fd06" id="fd06" value="Y"> 擔仔麵
<br><input type="checkbox" name="fd07" id="fd07" value="Y"> 米粉湯
<br><input type="checkbox" name="fd08" id="fd08" value="Y"> 生煎包
<br><input type="checkbox" name="fd09" id="fd09" value="Y"> 刈包
<br><input type="checkbox" name="fd10" id="fd10" value="Y"> 珍珠奶茶
<br><input type="text" name="memo" value="備註">
<input type="hidden" name="postdata" id="postdata" value="">

<br>
<input type="submit" value="點餐">
<form>
<span id="results"></span>

</body>
</html>