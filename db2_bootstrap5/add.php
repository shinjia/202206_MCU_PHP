<?php

$html = <<< HEREDOC
<button onclick="history.back();" class="btn btn-primary">返回</button>
<h2>新增資料</h2>
<form action="add_save.php" method="post">
  <div class="mb-3">
    <label for="usercode" class="form-label">代碼</label>
    <input type="text" class="form-control" id="usercode" name="usercode">
  </div>
  
  <div class="mb-3">
    <label for="username" class="form-label">姓名</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  
  <div class="mb-3">
    <label for="address" class="form-label">地址</label>
    <input type="text" class="form-control" id="address" name="address">
  </div>
  
  <div class="mb-3">
    <label for="birthday" class="form-label">生日</label>
    <input type="text" class="form-control" id="birthday" name="birthday">
  </div>
  
  <div class="mb-3">
    <label for="height" class="form-label">身高</label>
    <input type="text" class="form-control" id="height" name="height">
  </div>
  
  <div class="mb-3">
    <label for="weight" class="form-label">體重</label>
    <input type="text" class="form-control" id="weight" name="weight">
  </div>

  <div class="mb-3">
    <label for="remark" class="form-label">備註</label>
    <input type="text" class="form-control" id="remark" name="remark">
  </div>

  <div class="row">
    <input type="submit" value="新增" class="btn btn-success">
  </div>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>