<?php
session_start();

$usercode = isset($_POST['usercode']) ? $_POST['usercode'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 存帳號及密碼的文字檔，注意格式
$file_password = 'user_password.txt';

// 用file讀入的資料後面會多出符號 (Windows:\r\n; Linux: \n)
$a_list = file($file_password);

// 會員檢查，注意格式 (!!帳號##密碼@@)
$chk_string  = '!!' . $usercode . '##' . $password . '@@';

// 比對是否符合
$valid = false;
foreach($a_list as $one){
    $newstr = substr($one, 0, strpos($one, '@@')+2);
    if($newstr==$chk_string){
        $valid = true;
        // 取得 usertype
        $n1 = strpos($one,'@@');
        $n2 = strpos($one,'==');
        $usertype = substr($one, $n1+2, $n2-$n1-2);  // 取出 usertype
        break;
    }
}

// 權限是否通過
if($valid){
    $_SESSION['usertype'] = $usertype;
    $_SESSION['usercode'] = $usercode;
    $msg = $usercode . ' 你好，歡迎光臨！ ';
}
else {
    $_SESSION['usertype'] = '';
    $_SESSION['usercode'] = '';
    $msg = '登入錯誤';
}


$html = <<< HEREDOC
<p>{$msg}</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>