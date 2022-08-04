<?php


$html = <<< HEREDOC
<h2>會員、商品、購物車系統</h2>

<h3>前台頁面</h3>
<p>
<a href="prod_list.php">查看商品 (prod_list.php)</a><br />
<a href="login.php">登入(login.php)</a> | <a href="logout.php">登出(logout.php)</a>
</p>
<hr />
<a href="cart_list.php">查看購物車 (cart_list.php)</a><br />
<hr />
<a href="tran_input.php">進行結帳 (tran_input.php)</a><br />
<a href="tran_list.php">查看訂單 (tran_list.php)</a><br />

<p>
</p>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>