<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Test</title>
    <base target="_blank">
</head>
<body>
<h1>Cookie Test</h1>
<p>測試在各個資料夾設定 Cookie 影響的範圍</p>
<ul>
    <li><a href="root.php">root</a></li>
    <ul>
        <li><a href="sys_a/index.php">/sys_a</a></li>
        <li><a href="sys_b/index.php">/sys_b</a></li>
        <ul>
            <li><a href="sys_b/sub/index.php">/sys_b/sub</a></li>
        </ul>
    </ul>    
</ul>
<p><button onclick="open4();">同時開啟以上四個視窗</button></p>

<script>
function open4()
{
    window.open('root.php');
    window.open('sys_a/index.php');
    window.open('sys_b/index.php');
    window.open('sys_b/sub/index.php');
}
</script>

</body>
</html>