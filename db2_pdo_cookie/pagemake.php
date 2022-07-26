<?php
/* db2_pdo_cookie v1.0  @Shinjia  #2022/07/22 */

function pagemake($content='', $head='')
{
    $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>db_pdo2</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="style.css" rel="stylesheet">
{$head}
</head>
<body>

<div class="container">
    <div id="header">
        <h1>後台資料庫管理 db2_pdo_cookie</h1>
    </div>
    
    <div id="nav">     
        | <a href="index.php" target="_top">首頁</a>
        | <a href="page.php?code=note2">說明</a> 
        |
    </div>
    
    <div id="main">
        {$content}
    </div>

    <div id="footer">
        <p>版權聲明</p>
    </div>

</div>

</body>
</html>  
HEREDOC;

echo $html;
}

?>