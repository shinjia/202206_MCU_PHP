<?php

$link = mysqli_connect('localhost', 'root', '', 'class');

$sqlstr = "INSERT INTO person(usercode, username) VALUES ('P103', 'xxx')";
mysqli_query($link, $sqlstr);

mysqli_close($link);

echo 'OK';
?>