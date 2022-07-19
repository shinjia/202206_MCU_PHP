<?php
/* db_pdo v1.0  @Shinjia  #2022/07/17 */

include 'config.php';
include 'utility.php';

$op  = isset($_GET['op']) ? $_GET['op'] : 'HOME';
$uid = isset($_POST['uid']) ? $_POST['uid'] : (isset($_GET['uid'])?$_GET['uid']:'');

$code = isset($_GET['code']) ? $_GET['code'] : '';

$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$address  = isset($_POST['address'])  ? $_POST['address']  : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$height   = isset($_POST['height'])   ? $_POST['height']   : '';
$weight   = isset($_POST['weight'])   ? $_POST['weight']   : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 頁碼參數
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼
$nump = isset($_GET['nump']) ? $_GET['nump'] : 10;   // 每頁的筆數

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 變數設定
$total_rec = 0;
$total_page = 0;

// 連接資料庫
$pdo = db_open();


switch($op)
{
   case 'LIST_PAGE' :
        $url_page = '?op=LIST_PAGE';

      // SQL 語法：取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
      $sqlstr = "SELECT count(*) as total_rec FROM person ";
      $sth = $pdo->prepare($sqlstr);
      try {
         $sth->execute();
         if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $total_rec = $row["total_rec"];
         }
         $total_page = ceil($total_rec / $nump);  // 計算總頁數
      }
      catch(PDOException $e) {
         // db_error(ERROR_QUERY, $e->getMessage());
         $ihc_error = error_message(ERROR_QUERY, $e->getMessage());
      }

      $page = ($page<=$total_page) ? $page : $total_page;  // 頁數超過時，維持在最後一頁

      // SQL 語法：分頁資訊
      $sqlstr = "SELECT * FROM person ";
      $sqlstr .= " LIMIT " . (($page-1)*$nump) . "," . $nump;

      // 執行 SQL
      try { 
         $sth = $pdo->query($sqlstr);

         $cnt = (($page-1)*$nump);  // 注意分頁的起始順序
         $data = '';
         while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uid = $row['uid'];
            $usercode = html_encode($row['usercode']);
            $username = html_encode($row['username']);
            $address  = html_encode($row['address']);
            $birthday = html_encode($row['birthday']);
            $height   = html_encode($row['height']);
            $weight   = html_encode($row['weight']);
            $remark   = html_encode($row['remark']);
         
            $cnt++;

            // 超連結
            $lnk_display = '?op=DISPLAY&uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
            $lnk_edit = '?op=EDIT&uid=' . $uid . '&page=' . $page . '&nump=' . $nump;
            $lnk_delete = '?op=DELETE&uid=' . $uid . '&page=' . $page . '&nump=' . $nump;

            $data .= <<< HEREDOC
                  <tr>
                  <th>{$cnt}</th>
                  <td>{$uid}</td>
                  <td>{$usercode}</td>
                  <td>{$username}</td>
                  <td>{$address}</td>
                  <td>{$birthday}</td>
                  <td>{$height}</td>
                  <td>{$weight}</td>
                  <td>{$remark}</td>
                  <td><a href="{$lnk_display}">詳細</a></td>
                  <td><a href="{$lnk_edit}">修改</a></td>
                  <td><a href="{$lnk_delete}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
            </tr>
HEREDOC;
         }

         // 分頁導覽列
         $a_ext = array("op"=>"LIST_PAGE");
         $ihc_navigator = pagination_ext($total_page, $page, $nump, $a_ext);
         
         $lnk_add = '?op=ADD&page=' . $page . '&nump=' . $nump;

         //網頁顯示
         $ihc_content = <<< HEREDOC
         <h3>共有 $total_rec 筆記錄</h2>
         {$ihc_navigator}
         <table border="1" class="table">   
            <tr>
                  <th>順序</th>
                  <th>uid</th>
                  <th>代碼</th>
                  <th>姓名</th>
                  <th>地址</th>
                  <th>生日</th>
                  <th>身高</th>
                  <th>體重</th>
                  <th>備註</th>
                  <th colspan="3" align="center"><a href="{$lnk_add}">新增記錄</a></th>
            </tr>
         {$data}
         </table>
HEREDOC;

         // 找不到資料時
         if($total_rec==0) { $ihc_content = '<p class="center">無資料</p>';}
      }
      catch(PDOException $e) {
         // db_error(ERROR_QUERY, $e->getMessage());
         $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
      }

        break;
        
        
   case 'ADD' :
      $ihc_content = <<< HEREDOC
      <h2 align="center">新增資料區</h2>
      <form action="?op=ADD_SAVE" method="post">
          <p>代碼：<input type="text" name="usercode"></p>
          <p>姓名：<input type="text" name="username"></p>
          <p>地址：<input type="text" name="address"></p>
          <p>生日：<input type="text" name="birthday"></p>
          <p>身高：<input type="text" name="height"></p>
          <p>體重：<input type="text" name="weight"></p>
          <p>備註：<input type="text" name="remark"></p>
          <input type="submit" value="新增">
      </form>
HEREDOC;
        break;
        
        
   case 'ADD_SAVE' :
         // SQL 語法
         $sqlstr = "INSERT INTO person(usercode, username, address, birthday, height, weight, remark) VALUES (:usercode, :username, :address, :birthday, :height, :weight, :remark)";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);
         $sth->bindParam(':username', $username, PDO::PARAM_STR);
         $sth->bindParam(':address' , $address , PDO::PARAM_STR);
         $sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
         $sth->bindParam(':height'  , $height  , PDO::PARAM_INT);
         $sth->bindParam(':weight'  , $weight  , PDO::PARAM_INT);
         $sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
         
         // 執行 SQL
         try { 
            $sth->execute();
         
            $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
            $lnk_display = "?op=DISPLAY&uid=" . $new_uid;
            header('Location: ' . $lnk_display);
         }
         catch(PDOException $e) {
            // db_error(ERROR_QUERY, $e->getMessage());
            $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
            
            $html = <<< HEREDOC
            {$ihc_error}
HEREDOC;
            include 'pagemake.php';
            pagemake($html);
         }
        break;
       
        
   case 'DISPLAY' :
         // SQL 語法
         $sqlstr = "SELECT * FROM person WHERE uid=?";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindValue(1, $uid, PDO::PARAM_INT);
         
         // 執行 SQL
         try {
            $sth->execute();
            
            if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
               $uid = $row['uid'];
               $usercode = html_encode($row['usercode']);
               $username = html_encode($row['username']);
               $address  = html_encode($row['address']);
               $birthday = html_encode($row['birthday']);
               $height   = html_encode($row['height']);
               $weight   = html_encode($row['weight']);
               $remark   = html_encode($row['remark']);
         
               $data = <<< HEREDOC
               <table border="1" class="table">
                     <tr><th>代碼</th><td>{$usercode}</td></tr>
                     <tr><th>姓名</th><td>{$username}</td></tr>
                     <tr><th>地址</th><td>{$address}</td></tr>
                     <tr><th>生日</th><td>{$birthday}</td></tr>
                     <tr><th>身高</th><td>{$height}</td></tr>
                     <tr><th>體重</th><td>{$weight}</td></tr>
                     <tr><th>備註</th><td>{$remark}</td></tr>
               </table>
HEREDOC;
         
               // 網頁內容
               $ihc_content = <<< HEREDOC
               {$data}
HEREDOC;
            }
            else {
               $ihc_data = '<p class="center">查不到相關記錄！</p>';
            }
         }
         catch(PDOException $e) {
            // db_error(ERROR_QUERY, $e->getMessage());
            $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
         }
        break;
        
        
   case 'EDIT' :
         // SQL 語法
         $sqlstr = "SELECT * FROM person WHERE uid=? ";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindValue(1, $uid, PDO::PARAM_INT);
         
         // 執行 SQL
         try { 
            $sth->execute();
         
            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
               $uid = $row['uid'];
         
               $usercode = html_encode($row['usercode']);
               $username = html_encode($row['username']);
               $address  = html_encode($row['address']);
               $birthday = html_encode($row['birthday']);
               $height   = html_encode($row['height']);
               $weight   = html_encode($row['weight']);
               $remark   = html_encode($row['remark']);
               
               $data = <<< HEREDOC
               <form action="?op=EDIT_SAVE" method="post">
               <table class="table">
                     <tr><th>代碼</th><td><input type="text" name="usercode" value="{$usercode}"></td></tr>
                     <tr><th>姓名</th><td><input type="text" name="username" value="{$username}"></td></tr>
                     <tr><th>地址</th><td><input type="text" name="address" value="{$address}"></td></tr>
                     <tr><th>生日</th><td><input type="text" name="birthday" value="{$birthday}"></td></tr>
                     <tr><th>身高</th><td><input type="text" name="height" value="{$height}"></td></tr>
                     <tr><th>體重</th><td><input type="text" name="weight" value="{$weight}"></td></tr>
                     <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
               </table>
               <p>
                     <input type="hidden" name="uid" value="{$uid}">
                     <input type="submit" value="送出">
               </p>
               </form>
HEREDOC;
            }
            else {
               $data = '<p class="center">無資料</p>';
            }
         
            //網頁顯示
            $ihc_content = <<< HEREDOC
            <div>
               {$data}
            </div>
HEREDOC;
         }
         catch(PDOException $e) {
            // db_error(ERROR_QUERY, $e->getMessage());
            $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
         }
        break;
        
        
   case 'EDIT_SAVE' :
         // SQL 語法
         $sqlstr = "UPDATE person SET usercode=:usercode, username=:username, address=:address, birthday=:birthday, height=:height, weight=:weight, remark=:remark WHERE uid=:uid ";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindParam(':usercode', $usercode, PDO::PARAM_STR);
         $sth->bindParam(':username', $username, PDO::PARAM_STR);
         $sth->bindParam(':address' , $address , PDO::PARAM_STR);
         $sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
         $sth->bindParam(':height'  , $height  , PDO::PARAM_INT);
         $sth->bindParam(':weight'  , $weight  , PDO::PARAM_INT);
         $sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
         $sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);
         
         // 執行 SQL
         try { 
            $sth->execute();
         
            $lnk_display = "?op=DISPLAY&uid=" . $uid;
            header('Location: ' . $lnk_display);
         }
         catch(PDOException $e) {
            // db_error(ERROR_QUERY, $e->getMessage());
            $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
            
            $html = <<< HEREDOC
            {$ihc_error}
HEREDOC;
            include 'pagemake.php';
            pagemake($html);
         }
        break;
        

   case 'DELETE' :
         // SQL 語法
         $sqlstr = "DELETE FROM person WHERE uid=?";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindValue(1, $uid, PDO::PARAM_INT);
         
         // 執行 SQL
         try { 
            $sth->execute();
         
            $refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁
            header('Location: ' . $refer);
         }
         catch(PDOException $e) {
            // db_error(ERROR_QUERY, $e->getMessage());
            $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
               
            $html = <<< HEREDOC
            {$ihc_error}
HEREDOC;
            include 'pagemake.php';
            pagemake($html);
         }
        break;


   case 'PAGE' :
        $path = 'data/';   // 存放網頁內容的資料夾
        $filename = $path . $code . '.html';  // 規定副檔案為 .html
        
        if (!file_exists($filename))
        {
        	 // 找不到檔案時的顯示訊息
           $html  = '錯誤：傳遞參數有誤。檔案『' . $filename . '』不存在！';
        }
        else
        {
           $html = join ('', file($filename));   // 讀取檔案內容並組成文字串
        } 
        break;

        
   case 'HOME' : 
        $html = '<p><br><br><br>Welcome...資料管理系統<br><br><br><br><br><br></p>';
        break;
   
   
   default :
        $html = '<p><br><br><br>Welcome...資料管理系統<br><br><br><br><br></p>';
     
}

// db_close();
$pdo = null;


//網頁顯示
$html = <<< HEREDOC
<h2>詳細資料</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
