<?php
$amt  = isset($_GET['amt']) ? $_GET['amt'] : 1;

$str = '';
for($i=1; $i<=$amt; $i++) {
    $str .= '<br>檔案：<input type="file" name="file[]" size="10">';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
<script>
function add_item() {
    div_item.innerHTML += '檔案：<input type="file" name="file[]" size="10"><br>';
}
</script>
</head>
<body>
<h1>檔案上傳</h1>
<p>注意：如要上傳多個檔案，請在網址後加上『?amt=數量』</p>
<form name="form1" method="post" action="upload_save.php" enctype="multipart/form-data">
    {$str}
    <div id="div_item"></div>
    <input type="button" value="增加上傳檔案數量" onclick="add_item();">
    <input type="submit" value="上傳">                  
</form>                                                         
</body>
</html>                                                    
HEREDOC;

echo $html;                                                          
?>