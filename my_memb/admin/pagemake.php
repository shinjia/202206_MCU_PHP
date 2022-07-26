<?php
/* my_form v0.1  @Shinjia  #2022/07/26 */

function pagemake($content='', $head='')
{  
    $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>my_memb</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="style.css" rel="stylesheet">
{$head}
</head>
<body>

<div class="container">
    <div id="header">
        <h1>my_memb 後台資料庫管理</h1>
    </div>
    
    <div id="nav">     
        | <a href="index.php" target="_top">首頁</a>
        | <a href="page.php?code=note">說明</a> 
        | <a href="memb_list_page.php">會員(memb)</a>
        | <a href="form_list_page.php">表單(form)</a> |
        | <a href="login.php">登入</a>
        | <a href="logout.php">登出</a>
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