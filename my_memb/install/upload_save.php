<?php
$a_file = $_FILES["file"];  // 上傳的檔案內容

$save_filename = '__temp__.csv';

// 上傳檔案處理
$msg = '';
if($a_file["size"]>0)
{
   move_uploaded_file($a_file["tmp_name"], $save_filename);
   header('Location: import_csv.php');
   exit;
}
else
{
   $msg .= '檔案上傳不成功！';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
</head>
<body>
{$msg}
</body>
</html>
HEREDOC;

echo $html;
?>