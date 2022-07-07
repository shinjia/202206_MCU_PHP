<?php
include 'config.php';

$key_cd = isset($_POST["key_cd"]) ? $_POST["key_cd"] : "XX";
$key_mv = isset($_POST["key_mv"]) ? $_POST["key_mv"] : "";


// 連接資料庫
$link = db_open();

// 寫出 SQL 語法
switch($key_cd)
{
   case "A": // 查詢姓名
        $sql_where = " WHERE username LIKE '%" . $key_mv . "%' ";
        $str_find = '搜尋姓名為『' . $key_mv . '』的記錄';
        break;
        
   case "B": // 查詢地址
        $sql_where = " WHERE address='" . $key_mv . "' ";
        $str_find = '搜尋地址為『' . $key_mv . '』的記錄';
        break;
        
   case "C": // 查詢生日
        $sql_where = " WHERE birthday='" . $key_mv . "' ";
        $str_find = '搜尋生日為『' . $key_mv . '』的記錄';
        break;
        
   default:
        $sql_where = " WHERE false ";
}

$sqlstr = "SELECT * FROM person ";
$sqlstr .= $sql_where;

// 執行SQL及處理結果
$result = mysqli_query($link, $sqlstr) or die(ERROR_QUERY);
$total_rec = mysqli_num_rows($result);
$data = '';
$cnt = 0;
while($row=mysqli_fetch_array($result))
{
   $uid      = $row['uid'];
   $usercode = $row['usercode'];
   $username = $row['username'];
   $address  = $row['address'];
   $birthday = $row['birthday'];
   $height   = $row['height'];
   $weight   = $row['weight'];
   $remark   = $row['remark'];
   
   $cnt++;
   
   $data .= <<< HEREDOC
     <tr>
       <th align="center">{$cnt}</th>
       <td>{$usercode}</td>
       <td>{$username}</td>
       <td>{$address}</td>
       <td>{$birthday}</td>
       <td>{$height}</td>
       <td>{$weight}</td>
       <td>{$remark}</td>
    </tr>
HEREDOC;
}

$head = <<< HEREDOC
<script>
function show_sql()
{
   alert("{$sqlstr}");
}
</script>
HEREDOC;


$html = <<< HEREDOC
<p align="center"><a href="javascript:show_sql();">查看SQL語法</a></p>
<h2 align="center">共有 {$total_rec} 筆記錄</h2>
<table border="1" align="center">   
   <tr>
      <th>順序</th>
      <th>代碼</th>
      <th>姓名</th>
      <th>地址</th>
      <th>生日</th>
      <th>身高</th>
      <th>體重</th>
      <th>備註</th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, $head);
?>