<?php
// 此為單一資料表的匯出，要設定欄位名稱及 SQL 語法
$file_csv = 'output' . date('_Ymd_His') . '.csv';


include '../common/config.php';

// 依序匯入匯出的欄位及對應欄位名稱
$a_mapping = array(
    'f01' =>'membcode',
    'f02' =>'membname',
    'f03' =>'membpass',
    'f04' =>'membtele',
    'f05' =>'membmail',
    'f06' =>'membinfo',
    'f07' =>'memblike',
    'f08' =>'membpict',
    'f09' =>'membpset',
    'f10' =>'membtype',
    'f11' =>'googleid',
    'f12' =>'status',
    'f13' =>'remark' );


// 資料表及匯入的各個欄位
$ary = array();
foreach($a_mapping as $k=>$value)
{
    $ary[] = $value;
}

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=' . $file_csv);  
$output = fopen("php://output", "w"); 


fputcsv($output, $ary);  


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM memb ORDER BY membcode ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        unset($row['uid']);  // remove uid field
        
        fputcsv($output, $row);  
    }
}
else
{
    $msg = 'Error!';
}

fclose($output);  

?>