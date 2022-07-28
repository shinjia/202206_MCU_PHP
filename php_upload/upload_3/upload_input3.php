<?php

$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
</head>
<body>
<h1>檔案上傳</h1>
<form name="form1" method="post" action="upload_save.php" enctype="multipart/form-data">
    檔案：<input name="file[]" type="file" multiple="multiple" />
    <input type="submit" value="上傳">                  
</form>                                                         
</body>
</html>                                                    
HEREDOC;

echo $html;                                                          
?>