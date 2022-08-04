<?php





$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="prod_add_save.php" method="post">
<table>
    <tr><th>商品代碼</th><td><input type="text" name="prod_code" value="" /></td></tr>
    <tr><th>商品名稱</th><td><input type="text" name="prod_name" value="" /></td></tr>
    <tr><th>種類代號</th><td><input type="text" name="category" value="" /></td></tr>
    <tr><th>商品描述</th><td><textarea name="description"></textarea></td></tr>
    <tr><th>標示原價</th><td><input type="text" name="price_mark" value="" /></td></tr>
    <tr><th>實際售價</th><td><input type="text" name="price" value="" /></td></tr>
    <tr><th>商品圖檔</th><td><input type="text" name="picture" value="" /></td></tr>
    <tr><th>圖檔目錄</th><td><input type="text" name="pictset" value="" /></td></tr>

</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>