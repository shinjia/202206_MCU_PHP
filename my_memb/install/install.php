<?php
include '../common/config.php';

// ************ 以下為資料定義，依自行需要進行修改 ************
// 資料表之SQL語法 (採用陣列方式，可以設定多個。注意陣列的key即為資料表名稱)

$a_table['memb'] = '
CREATE TABLE memb
(
    uid int(11) NOT NULL auto_increment, 
    membcode VARCHAR(255) NULL,
    membname VARCHAR(255) NULL,
    membpass VARCHAR(255) NULL,
    membtele VARCHAR(255) NULL,
    membmail VARCHAR(255) NULL,
    membinfo VARCHAR(255) NULL,
    memblike VARCHAR(255) NULL,
    membpict VARCHAR(255) NULL,
    membpset VARCHAR(255) NULL,
    membtype VARCHAR(255) NULL,
    googleid VARCHAR(255) NULL,
    status   VARCHAR(255) NULL,
    remark VARCHAR(255) NULL,
    PRIMARY KEY (uid)
)
';


$a_table['form'] = '
CREATE TABLE form
(
    uid int(11) NOT NULL auto_increment, 
    formcode VARCHAR(255) NULL,
    formname VARCHAR(255) NULL,
    formdate VARCHAR(255) NULL,
    formfld1 VARCHAR(255) NULL,
    formfld2 VARCHAR(255) NULL,
    forminfo VARCHAR(255) NULL,
    membcode VARCHAR(255) NULL,
    remark   VARCHAR(255) NULL,
    PRIMARY KEY (uid)
)
';



// 如要預先新增記錄，定義於此
$a_record[] = "INSERT INTO memb(membcode, membname, membpass, membtele, membmail, membinfo, memblike, membpict, membpset, membtype, googleid, status, remark) VALUES 
('allen', 'Allen', '1234', '0937111111', 'aaa@gmail.com', '1111', '音樂,運動', 'xx.jpg', 'allen', 'MEMBER', '', '', ''),
('bruce', 'Bruce', '1234', '0937222222', 'bbb@gmail.com', '2222', '運動,美食', 'xx.jpg', 'bruce', 'MEMBER', '', '', '') ";  // 注意最後的符號

$a_record[] = "INSERT INTO form(formcode, formname, formdate, formfld1, formfld2, forminfo, membcode, remark) VALUES 
('2022070001', '閱覽室使用申請', '2022/07/01', 'f1', 'f2', '更多說明事項', 'allen', '' ),
('2022070002', 'XXXXXXXXX申請', '2022/07/03', 'f1', 'f2', '更多說明事項', 'allen', '' ),
('2022070003', '閱覽室使用申請', '2022/07/05', 'f1', 'f2', '更多說明事項', 'bruce', '' ) ";  // 注意最後的符號


// ************ 以下為此程式之功能執行，毋需修改 ************

function build_table_string($sth)
{
    $ret = '';

    // 以各欄位名稱當表格標題
    $fields = array(); 
    for ($i=0; $i<$sth->columnCount(); $i++)
    {
        $col = $sth->getColumnMeta($i);
        $fields[] = $col['name'];
    }

    $ret .= '<table border="1" cellpadding="2" cellspaceing="0">';
    $ret .= '<tr>';
    foreach ($fields as $val)
    {
        $ret .= '<th>' . $val . '</th>';
    }
    $ret .= '</tr>';
  
    // 列出各筆記錄資料
    while($row=$sth->fetch(PDO::FETCH_ASSOC))
    {
        $ret .= '<tr>';
        foreach($row as $one)
        {
            $ret .= '<td>' . $one . '</td>';
        }
        $ret .= '</tr>';
    }
    $ret .= '</table>';
   
    return $ret;
}



// ***** 主程式 *****
$do = isset($_GET['do']) ? $_GET['do'] : '';

// 接收傳入變數 (供 SQL_INPUT 及 SQL_QUERY 使用)
$sql = isset($_POST['sql']) ? $_POST['sql'] : '';
$sql = stripslashes($sql);  // 去除表單傳遞時產生的脫逸符號

$msg = '';
switch($do)
{
   case 'ADD_DATA' :
        $pdo = db_open();
        
        $msg = '<h2>新增記錄</h2>';
        foreach($a_record as $key=>$sqlstr)
        {
            $sth = $pdo->query($sqlstr);
            
            if($sth===FALSE)
            {
                $msg .= '<p>無法新增！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
                $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
                $msg .= '<p>新增成功 (uid=' . $new_uid .  ')</p>';
            }
        }
        break;
        
        
        
   case 'LIST_DATA' :
        $pdo = db_open();
        
        $msg = '<h2>記錄內容</h2>';
        foreach($a_table as $key=>$sqlstr)
        {
            $sqlstr = 'SELECT * FROM ' . $key;
            $sth = $pdo->query($sqlstr);
           
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            if ($sth===FALSE) 
            {
                $msg .= '<p>無法顯示</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
                $msg .= build_table_string($sth);
            }
        }
        break;
        
        
        
   case 'DESC_TABLE' :
        $pdo = db_open();
        
        $msg = '<h2>資料表結構</h2>';
        foreach($a_table as $key=>$sqlstr)
        {
            $sqlstr = 'DESC ' . $key;
            $sth = $pdo->query($sqlstr);

            $msg .= '<h3>資料表『' . $key . '』</h3>';

            if($sth===FALSE)
            {
                $msg .= '<p>無法顯示</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
               $msg .= build_table_string($sth);
           }
        }
        break;
        
        
        
   case 'CREATE_TABLE' : 
        $pdo = db_open();
        
        $msg .= '<h2>資料表建立結果</h2>';
        
        foreach($a_table as $key=>$sqlstr)
        {
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            
            $sth = $pdo->query($sqlstr);   
            if($sth===FALSE)
            {
                $msg .= '<p>無法建立！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
                $msg .= '<p>建立完成</p>';
            }
            
        }
        break;


        
   case 'DROP_TABLE' : 
        // 連接資料庫
        $pdo = db_open();
        
        // 執行SQL及處理結果
        $msg .= '<h2>資料表刪除結果</h2>';
        foreach($a_table as $key=>$sqlstr)
        {
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            
            $sqlstr = 'DROP TABLE ' . $key;
            $sth = $pdo->exec($sqlstr);   
  
            if($sth===FALSE)
            {
                $msg .= '<p>無法刪除！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
                $msg .= '<p>刪除成功</p>';
            }
        }
        break;
        
   
        
   case 'CREATE_DATABASE' : 
       
        try {
            $pdo = new PDO('mysql:host='.DB_SERVERIP, DB_USERNAME, DB_PASSWORD);
            if(defined('SET_CHARACTER')) $pdo->query(SET_CHARACTER);
            
            $sqlstr = 'CREATE DATABASE ' . DB_DATABASE;
            $sqlstr .= ' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ';   // or utf8
            
            $pdo->exec($sqlstr);  // or die(print_r($pdo->errorInfo(), true));
        }
        catch (PDOException $e)
        {
            die("DB ERROR: ". $e->getMessage());
        }
    
        $msg .= '<h2>資料庫建立</h2>';
        $msg .= print_r($pdo->errorInfo(),TRUE);
        $msg .= '<p>資料庫『' . DB_DATABASE . '』</p>';
        $msg .= '<p>' . $sqlstr . '</p>';
        $msg .= '<p>如要刪除 DROP DATABASE ' . DB_DATABASE . '</p>';
        break;
        
        
        
   case 'SQL_QUERY' :
        if(empty($sql))
        {
            $msg .= '<h2>SQL 範例</h2>' ;
            $msg .= '<p>SHOW TABLES</p>';
            $msg .= '<p>SHOW TABLE STATUS</p>';
            $msg .= '<p>--------------------</p>';
            foreach($a_table as $key=>$sqlstr)
            {
                $msg .= '<p>SELECT * FROM ' . $key . '</p>';
            }
        }
        else
        {
            $pdo = db_open();
            
            $sqlstr = $sql;
            $sth = $pdo->query($sqlstr);
            
            if($sth===FALSE)
            {
                $msg .= '<h3>執行結果失敗！</h3>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else
            {
                // SELECT 語法結果
                $msg .= '<h3>rowCount: ' . $sth->rowCount() . '</h3>';
                $msg .= build_table_string($sth);
            }
        }
        
        $msg = <<< HEREDOC
        <h2>請輸入SQL指令</h2>
        <form name="form1" method="post" action="?do=SQL_QUERY">
        <textarea name="sql" rows="3" cols="80">{$sql}</textarea><br />
        <input type="submit" value="送出查詢">
        </form>
        <hr />
        {$msg}
HEREDOC;
        break;
        
        
        
   case 'VIEW_DEFINE' :
        $msg .= '<table border="0"><tr><td>';
        $msg .= '<div align="left">';
        $msg .= '<h2>資料表 (程式內定義)</h2>';
        foreach($a_table as $key=>$sqlstr)
        {
           $msg .= '<h3>' . $key . '<h3>';
           $msg .= '<pre>' . $sqlstr . '</pre><hr />';
        }
        $msg .= '<h2>預設 SQL (程式內定義)</h2><hr />';
        foreach($a_record as $key=>$sqlstr)
        {
           $msg .= '<pre>' . $sqlstr . '</pre>';
        }
        $msg .= '</div>';
        $msg .= '</td></tr></table>';
        break;
        
        
        
   default :
       $msg .= '快速安裝程式';
}



$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統 - 安裝程式</title>
</head>
<body>
<h2>初始安裝工具程式</h2>
<p>
  | <a href="?do=VIEW_DEFINE">程式內SQL定義</a>
  | ---
  | <a href="?do=CREATE_DATABASE">建立資料庫</a>
  | ---
  | <a href="?do=CREATE_TABLE">建立資料表</a>
  | <a href="?do=DROP_TABLE" onClick="return confirm('確定要刪除嗎？');">刪除資料表</a>
  | <a href="?do=DESC_TABLE">查看結構</a>
  | ---
  | <a href="?do=ADD_DATA">新增預設記錄</a>
  | <a href="?do=LIST_DATA">查看記錄內容</a>
  | ---
  | <a href="?do=SQL_QUERY">SQL測試</a>
  |
<hr>
<div align="center">
{$msg}
</div>
</body>
</html>
HEREDOC;

echo $html;
?>