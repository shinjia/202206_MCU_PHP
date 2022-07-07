<?php

function pagemake($content='', $head='')
{  
  $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style type="text/css">
* {
  margin: 0px;
}

div.container {
  padding: 10px;
  margin: 0 auto;
  width: 760px;
}

div#header {
  padding: 10px;
  background-color: #AAEEAA; 
}

div#nav {
  padding: 10px;
  background-color: #FFAA33; 
}


div#main {
  padding: 10px;
  background-color: #EEEEAA; 
}

div#footer {
  padding: 10px;
  background-color: #AAAA33; 
  text-align: center;
}

</style>

{$head}
</head>
<body>

<div class="container">
   <div id="header">
      <h1>後台資料庫管理</h1>
   </div>
  
   <div id="nav">     
      | <a href="index.php" target="_top">首頁</a>
      | <a href="page.php?code=note2">說明</a> 
      | <a href="list_page.php">資料列表</a> 
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