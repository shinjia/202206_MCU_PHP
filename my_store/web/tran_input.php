<?php
session_start();

include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';

$ss_usertype = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
$ss_usercode = isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '';

if(($ss_usertype!=DEF_LOGIN_MEMBER))
{
   header('Location: login_error.php');
   exit;
}


//------ End of Login Check ------------------------

$session_id = session_id();


// 連接資料庫
$pdo = db_open();


// 執行SQL：檢查是否有訂單
$sqlstr  = "SELECT * FROM cart ";
$sqlstr .= "WHERE account=:session_id ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':session_id', $session_id, PDO::PARAM_STR);

$data = '';
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {

      $total_rec = $sth->rowCount();
      if($total_rec==0)
      {
   	    $msg = '購物車內並無資料。';
      }
      else
      {
         // 寫出 SQL 語法
         $sqlstr = "SELECT * FROM customer WHERE account=':ss_usercode' ";
         
         $sth = $pdo->prepare($sqlstr);
         $sth->bindParam(':ss_usercode', $ss_usercode, PDO::PARAM_STR);
   
         // 執行 SQL
         if($sth->execute())
         {
            // 成功執行 query 指令
            $data = '';
            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
               $uid = $row['uid'];
               $account = $row['account'];
               $nickname = $row['nickname'];
               $realname = $row['realname'];
               $zipcode = $row['zipcode'];
               $address = $row['address'];
               $telephone = $row['telephone'];
               
               $data .= '收件人：' . $realname . "\n";
               $data .= '郵遞區號：' . $zipcode . "\n";
               $data .= '地址：' . $address . "\n";
               $data .= '電話：' . $telephone . "\n\n";
               $data .= '其他通知事項：' . "\n";
            }
         }
            
         $msg = <<< HEREDOC
         <h2>填寫郵寄等相關資料</h2>
         <form name="form1" method="post" action="tran_build.php">
            <textarea name="input_notes" cols="60" rows="8">{$data}</textarea>
            <BR><input type="submit" value="確定結帳">
         </form>
HEREDOC;
      }
   }
}


$html = $msg;
include 'pagemake.php';
pagemake($html, '');
?>