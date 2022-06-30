<?php
$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$gender   = isset($_POST['gender'])   ? $_POST['gender']   : '';
$blood    = isset($_POST['blood'])    ? $_POST['blood']    : '';
$birth_yy = isset($_POST['birth_yy']) ? $_POST['birth_yy'] : '';
$birth_mm = isset($_POST['birth_mm']) ? $_POST['birth_mm'] : '';
$birth_dd = isset($_POST['birth_dd']) ? $_POST['birth_dd'] : '';
$marriage = isset($_POST['marriage']) ? $_POST['marriage'] : '';
$hobby1   = isset($_POST['hobby1'])   ? $_POST['hobby1']   : '';
$hobby2   = isset($_POST['hobby2'])   ? $_POST['hobby2']   : '';
$hobby3   = isset($_POST['hobby3'])   ? $_POST['hobby3']   : '';
$hobby4   = isset($_POST['hobby4'])   ? $_POST['hobby4']   : '';
$intro    = isset($_POST['intro'])    ? $_POST['intro']    : '';


//  extract($_POST);   // 不安全


// 處理姓名的狀況 (單一條件)
if($nickname=='')
{
	$nickname = '無名氏';
}



// 處理性別的輸入 (雙重條件)
if( $gender=='M' )
{
	$str_gender1 = '先生';
	$str_gender2 = '男';
}
else
{
	$str_gender1 = '小姐';
	$str_gender2 = '女';
}



// 處理出生季節 (多重條件)
$m = $birth_mm;
if($m==3 || $m==4 || $m==5)
{
	$str_season = '春天';
}
elseif( ($m==6) || ($m==7) || ($m==8) )
{
	$str_season = '夏天';
}
elseif( $m>=9 && $m<=11 )
{
	$str_season = '秋天';
}
elseif( $m==12 || $m==1 || $m==2 )
{
	$str_season = '冬天';
}
else
{
	$str_season = '!!!!!不詳';  // 注意是有可能發生的
	exit;
}



// 計算年齡
$age = date('Y', time()) - $birth_yy;



// 處理血型 (多重條件，根據一個變數的不同值進行判斷)
switch($blood)
{
	case 'A' :
	case 'a' :
		$str_blood = 'A型的你XXXXXX';			
		break;     
		
	case 'b' :
	case 'B' :
		$str_blood = 'B型的你XXXXXX';	
		break;
		
	case 'O' :
		$str_blood = 'O型的你XXXXXX';	
		break;
		
	case 'AB' :
		$str_blood = 'AB型的你XXXXXX';
		break;
		
	default:
		$str_blood = '血型有誤!!!';
}


// 另一種寫法
if($blood=='A')
{
	$str_blood = 'A型的你XXXXXX';
}
elseif($blood=='B')
{
	$str_blood = 'B型的你XXXXXX';
}
elseif($blood=='O')
{
	$str_blood = 'O型的你XXXXXX';
}
elseif($blood=='AB')
{
	$str_blood = 'AB型的你XXXXXX';
}
else
{
	$str_blood = '血型有誤!!!';
}


// 計算興趣勾選的數量 (問號冒號用法：依條件傳回不同的值)

// 傳統的寫法，注意只有處理一個興趣，必須另外加上其他的hobby2, hobby3, hobby4
$cnt = 0;
if($hobby1=='Y')
{
	$cnt = $cnt + 1;
	$cnt += 1;
	$cnt++;
}


/*
if($hobby1=='Y')
{
	$cnt += 1;
}
else
{
	$cnt += 0;
}

$cnt +=  ($hobby1=='Y') ? 1 : 0;
$cnt +=  ($hobby2=='Y') ? 1 : 0;
$cnt +=  ($hobby3=='Y') ? 1 : 0;
$cnt +=  ($hobby4=='Y') ? 1 : 0;
*/


// 精簡的寫法 (依據條件傳回不同的結果 ? : )
$cnt = 0;  // 計算數量
$cnt += ( ($hobby1=='Y') ? 1 : 0 );
$cnt += ( ($hobby2=='Y') ? 1 : 0 );
$cnt += ( ($hobby3=='Y') ? 1 : 0 );
$cnt += ( ($hobby4=='Y') ? 1 : 0 );

$str_hobby = '';  // 顯示的文字
$str_hobby .= ( ($hobby1=='Y') ? '電腦 ' : '' );
$str_hobby .= ( ($hobby2=='Y') ? '音樂 ' : '' );
$str_hobby .= ( ($hobby3=='Y') ? '旅遊 ' : '' );
$str_hobby .= ( ($hobby4=='Y') ? '閱讀 ' : '' );




// 將密碼隱藏顯示，有幾個字就出現幾個星號
$str_password = str_repeat('*', strlen($password) );


// 將簡介內原有的最後換列，確實顯示出來
$str_intro = nl2br($intro);



// 顯示網頁
$html = <<< HEREDOC
<!DOCTYPE html> 
<html> 
<head> 
<meta charset="UTF-8"> 
<title>Survey</title> 
</head> 

<body> 
<h2>{$nickname} {$str_gender1}已收到你的資料如下</h2>

<p>姓名：{$nickname}</p>
<p>密碼：{$str_password}</p>
<p>性別：{$str_gender2}</p>
<p>血型：{$str_blood}</p>
<p>生日：{$birth_yy} 年 {$birth_mm} 月 {$birth_dd} 日 ...... {$str_season}；年齡 {$age} 歲</p>
<p>已婚：{$marriage}</p>
<p>興趣：{$str_hobby} ...... 共有 {$cnt} 項</p>
<p>介紹：{$str_intro}</p>

</body> 
</html> 
HEREDOC;

echo $html; 
?>