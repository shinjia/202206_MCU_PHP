<?php
include 'config.php';
include 'function.chinese_name.php';

$count = isset($_POST['count']) ? $_POST['count'] : 0;

$a_addr = array('基隆', '台北', '新北', '桃園', '新竹','台中', '彰化', '雲林', '嘉義', '台南', '高雄', '屏東', '台東', '花蓮', '宜蘭', '南投');


// 連接資料庫
$link = db_open();

$msg = '';
for($i=1; $i<=$count; $i++)
{
   $usercode = uniqid();
   $username = chinese_name();
   $address  = $a_addr[array_rand($a_addr)];
   $birthday = @date('Y-m-d', @strtotime('-'.mt_rand(0,650*50).' day'));  // 前五十年內的任一天
   $height   = mt_rand(150, 190);
   $weight   = mt_rand(45, 95);
   $remark   = CHR(mt_rand(65, 90));

   // 寫出 SQL 語法
   $sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (";
   $sqlstr .= "'" . $usercode . "', ";
   $sqlstr .= "'" . $username . "', ";
   $sqlstr .= "'" . $address  . "', ";
   $sqlstr .= "'" . $birthday . "', ";
   $sqlstr .= ($height+0) . ", ";
   $sqlstr .= ($weight+0) . ", ";
   $sqlstr .= "'" . $remark . "') ";   // 注意：最後一個欄位之後的符號

   // 執行SQL及處理結果
   $result = mysqli_query($link, $sqlstr);
   $msg .= ($result) ? 'O ' : 'X ';
}


$html = <<< HEREDOC
<h2>新增記錄</h2>
<form method="post" action="add_many.php" style="margin:0px;">
  一次新增<input type="text" name="count" size="2" value="">筆記錄
  <input type="submit" value="執行">
</form>
<p>{$msg}</p>
<p>一個點『O』代表新增成功一筆，一個『X』代表錯誤一筆</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>