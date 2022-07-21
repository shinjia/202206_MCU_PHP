<?php
include 'config.php';
include 'utility.php';

$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];

      $usercode = convert_to_html($row['usercode']);
      $username = convert_to_html($row['username']);
      $address  = convert_to_html($row['address']);
      $birthday = convert_to_html($row['birthday']);
      $height   = convert_to_html($row['height']);
      $weight   = convert_to_html($row['weight']);
      $remark   = convert_to_html($row['remark']);
      
      $data = <<< HEREDOC
      <form action="edit_save.php" method="post">

		  <div class="mb-3">
			<label for="usercode" class="form-label">代碼</label>
			<input type="text" class="form-control" id="usercode" name="usercode" value="{$usercode}">
		  </div>
		  
		  <div class="mb-3">
			<label for="username" class="form-label">姓名</label>
			<input type="text" class="form-control" id="username" name="username" value="{$username}">
		  </div>
		  
		  <div class="mb-3">
			<label for="address" class="form-label">地址</label>
			<input type="text" class="form-control" id="address" name="address" value="{$address}">
		  </div>
		  
		  <div class="mb-3">
			<label for="birthday" class="form-label">生日</label>
			<input type="text" class="form-control" id="birthday" name="birthday" placeholder="yyy-mm-dd" value="{$birthday}">
		  </div>
		  
		  <div class="mb-3">
			<label for="height" class="form-label">身高</label>
			<input type="text" class="form-control" id="height" name="height" value="{$height}">
		  </div>
		  
		  <div class="mb-3">
			<label for="weight" class="form-label">體重</label>
			<input type="text" class="form-control" id="weight" name="weight" value="{$weight}">
		  </div>

		  <div class="mb-3">
			<label for="remark" class="form-label">備註</label>
			<input type="text" class="form-control" id="remark" name="remark" value="{$remark}">
		  </div>

  
        <div class="row">
          <input type="hidden" name="uid" value="{$uid}">
          <input type="submit" value="送出" class="btn btn-success">
        </div>

      </form>
HEREDOC;
   }
   else
   {
 	   $data = '查不到相關記錄！';
   }
}
else
{
   // 無法執行 query 指令時
   $data = error_message('edit');
}


$html = <<< HEREDOC
<button onclick="history.back();" class="btn btn-primary">返回</button>
<h2>修改資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>