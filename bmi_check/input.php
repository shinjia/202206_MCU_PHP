<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<h1>BMI</h1>

<form method="post" action="calc.php" onsubmit="return check_data();">
<p>身高：<input type="text" name="height" id="height" size="4"> (公分)</p>
<p>體重：<input type="text" name="weight" id="weight" size="4"> (公斤)</p>
<p><input type="submit" value="計算 BMI"></p>
</form>


<script>
function check_data()
{
    var flag = true;
    var message = '';
    
    // ---------- Check 1 ----------
    // 檢查 height (文字欄位必須有值)
    // isNaN(t.value)  檢查必須為數字

    var t = document.getElementById('height');
    if(t.value=='')
    {
        flag = false;
        message += '(1) 身高不能為空白\n';
    }

    alert(message);

    return flag;
}
</script>

</body>
</html>