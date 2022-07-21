<?php

function pagemake($content='', $head='')
{  
  $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>基本資料庫系統</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/css/sticky-footer-navbar.css" >

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  
{$head}
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">後台管理系統</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">首頁</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="list_all.php">全部顯示</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="list_page.php">分頁顯示</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="page.php?code=home">說明 home</a></li>
            <li><a class="dropdown-item" href="page.php?code=note2">說明 note2</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>


<div class="container">

   <div class="row">
     <div class="col">
       <div class="alert alert-primary mt-4">後台資料庫管理</div>
     </div>
   </div>
    
   <div class="row">
     <div class="col">
       {$content}
     </div>
   </div>

</div>

<footer class="footer mt-auto py-3 bg-dark">
    <div class="container">
      <span class="text-muted">版權沒有，歡迎拷貝</span>
    </div>
</footer>

</body>
</html>  
HEREDOC;

echo $html;
}

?>