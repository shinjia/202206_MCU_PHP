<?php
$min = 0;
$max = 17;

$pic1 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic2 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic3 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic4 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic5 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic6 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic7 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic8 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic9 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic10 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic11 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic12 = 'images_majung/' . mt_rand($min,$max) . '.gif';
$pic13 = 'images_majung/' . mt_rand($min,$max) . '.gif';


$html = <<< HEREDOC
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Test</title>
</head>

<body>
<p>我的幸運數字</p>
<p>
<img src="{$pic1}" border="1" />
<img src="{$pic2}" border="1" />
<img src="{$pic3}" border="1" />
<img src="{$pic4}" border="1" />
<img src="{$pic5}" border="1" />
<img src="{$pic6}" border="1" />
<img src="{$pic7}" border="1" />
<img src="{$pic8}" border="1" />
<img src="{$pic9}" border="1" />
<img src="{$pic10}" border="1" />
<img src="{$pic11}" border="1" />
<img src="{$pic12}" border="1" />
<img src="{$pic13}" border="1" />
</p>
</body>
</html>
HEREDOC;

echo $html;
?>