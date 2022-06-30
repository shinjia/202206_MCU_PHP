<?php
$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

// 時區設定
ini_set( 'date.timezone', 'Asia/Taipei');

// email 設定 (建議在 php.ini 中做永久的設定)
ini_set('SMTP','msa.hinet.net');
ini_set('smtp_port',25);
ini_set('sendmail_from', 'shinjia168@gmail.com');


// 設定是否啟用通知
$is_mail = false;
$is_line = true;


$now = date('Y-m-d H:i:s', time());


// 要存的內容
$data = <<< HEREDOC
時間：{$now}
姓名：{$nickname}
{$comment}
------------------------------------------------

HEREDOC;

// 自動建立資料夾
$dir = 'save';
if(!is_dir($dir))
{
    mkdir($dir, 777);
}


// 檔案名稱
$filename = $dir . '/save_' . date('Ymd',time()) . '.txt';

// 方法一：留言寫入(新增在後面)
// file_put_contents($filename, $data, FILE_APPEND);

// 方法二：新留言放前面
if(!file_exists($filename))
{
    file_put_contents($filename, '');
}

$old = file_get_contents($filename);
$new = $data . $old;
file_put_contents($filename, $new);


// 寄 email
$msg_mail = '';
if($is_mail)
{
    $to = 'shinjia168@gmail.com';
    $title = 'You Got Mail. 收到客戶留言. ';
    $content = $data;

    if(mail($to, $title, $content))
    {
        $msg_mail = '已寄送mail通知!';
    }
}



// LINE Notify 通知
$msg_line = '';
if($is_line)
{
    $token = 'P4RHKdFvsSc9saSZQ28qU39b1fTNLMxJa3eBFulmmYF';  // 更換自己的 token

    $url = "https://notify-api.line.me/api/notify";

    $headers = array(
    'Content-Type: multipart/form-data',
    'Authorization: Bearer ' . $token);

    // $message = array('message' => $data);
    
    $message = array(
        'message' => $data,
        'imageFile' => curl_file_create('D:\\xampp\htdocs\myweb\line\dog.png')
        );


    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL , $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
    $result = curl_exec($ch);
    curl_close($ch);

    $msg_line = '已發送 LINE 通知!';
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>已收到留言!!</p>
    <p>{$msg_mail}</p>
    <p>{$msg_line}</p>
</body>
</html>
HEREDOC;

echo $html;
?>