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

// 底下為 view 的建立
$a_view['mform_vw'] = '
CREATE VIEW mform_vw AS
    SELECT memb.membcode, memb.membname, 
        form.formcode, form.formname, form.formdate,
        form.formfld1, form.formfld2, form.forminfo
    FROM memb LEFT JOIN form ON memb.membcode=form.membcode
    ORDER BY form.formcode
';


// 如要預先新增記錄，定義於此
$a_record[] = "INSERT INTO memb(membcode, membname, membpass, membtele, membmail, membinfo, memblike, membpict, membpset, membtype, googleid, status, remark) VALUES 
('allen', 'Allen', 'f418d011e84f58e6210ca401253a7597', '0937111111', 'aaa@gmail.com', '1111', '音樂,運動', '', 'allen', 'MEM_MEMBER', '', '', '預設登入密碼是 11111@Allen'),
('bruce', 'Bruce', '0f0c38b7346182849e0f51df73234647', '0937222222', 'bbb@gmail.com', '2222', '運動,美食', '', 'bruce', 'MEM_VIP', '', '', '預設登入密碼是 22222@Bruce') ";  // 注意最後的符號

$a_record[] = "INSERT INTO form(formcode, formname, formdate, formfld1, formfld2, forminfo, membcode, remark) VALUES 
('2022060001', '閱覽室使用申請', '2022/06/01', 'AA', 'F2', '更多說明事項', 'allen', '' ),
('2022060002', '閱覽室使用申請', '2022/06/10', 'Try English', 'f2', '更多說明事項', 'allen', '' ),
('2022060003', '閱覽室使用申請', '2022/06/18', '中文和 English 混合', 'f2', '更多說明事項', 'allen', '' ),
('2022070001', '閱覽室使用申請', '2022/07/01', '特殊中文字堃(方方土)', 'f2', '更多說明事項', 'allen', '' ),
('2022070002', '健身房使用申請', '2022/07/03', '殊殊符號(!@#$%^&*)', 'f2', '更多說明事項', 'allen', '' ),
('2022070003', '閱覽室使用申請', '2022/07/05', 'XX', 'f2', '更多說明事項', 'bruce', '' ) ";  // 注意最後的符號


// ************ 以下為此程式之功能執行，毋需修改 ************

function build_table_string($sth) {
    $ret = '';

    // 以各欄位名稱當表格標題
    $fields = array();  
    for ($i=0; $i<$sth->columnCount(); $i++) {
        $col = $sth->getColumnMeta($i);
        $fields[] = $col['name'];
    }

    $ret .= '<table border="1" cellpadding="2" cellspaceing="0">';
    $ret .= '<tr>';
    foreach ($fields as $val) {
        $ret .= '<th>' . $val . '</th>';
    }
    $ret .= '</tr>';

    // 列出各筆記錄資料
    while($row=$sth->fetch(PDO::FETCH_ASSOC)) {
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
switch($do) {
    case 'ADD_DATA' :
        $pdo = db_open();
        
        $msg = '<h2>新增記錄</h2>';
        foreach($a_record as $key=>$sqlstr) {
            $sth = $pdo->query($sqlstr);
            
            if($sth===FALSE) {
                $msg .= '<p>無法新增！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $new_uid = $pdo->lastInsertId();    // 傳回剛才新增記錄的 auto_increment 的欄位值
                $msg .= '<p>新增成功 (uid=' . $new_uid .  ')</p>';
            }
        }
        break;
        
        
        
    case 'LIST_DATA' :
        $pdo = db_open();
        
        $msg = '<h2>記錄內容</h2>';
        foreach($a_table as $key=>$sqlstr) {
            $sqlstr = 'SELECT * FROM ' . $key;
            $sth = $pdo->query($sqlstr);

            $msg .= '<h3>資料表『' . $key . '』</h3>';
            if ($sth===FALSE) {
                $msg .= '<p>無法顯示</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= build_table_string($sth);
            }
        }
        break;
        
        
        
    case 'DESC_TABLE' :
        $pdo = db_open();
        
        $msg .= '<h2>資料表結構</h2>';
        foreach($a_table as $key=>$sqlstr) {
            $sqlstr = 'DESC ' . $key;
            $sth = $pdo->query($sqlstr);

            $msg .= '<h3>資料表『' . $key . '』</h3>';

            if($sth===FALSE) {
                $msg .= '<p>無法顯示</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= build_table_string($sth);
            }
        }
        
        $msg .= '<h2>資料 View 結構</h2>';
        foreach($a_view as $key=>$sqlstr) {
            $sqlstr = 'DESC ' . $key;
            $sth = $pdo->query($sqlstr);

            $msg .= '<h3>資料 View『' . $key . '』</h3>';

            if($sth===FALSE) {
                $msg .= '<p>無法顯示</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= build_table_string($sth);
            }
        }
        break;
        
        
        
    case 'CREATE_TABLE' : 
        $pdo = db_open();
        
        $msg .= '<h2>資料表建立結果</h2>';
        
        foreach($a_table as $key=>$sqlstr) {
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            
            $sth = $pdo->query($sqlstr);   
            if($sth===FALSE) {
                $msg .= '<p>無法建立！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= '<p>建立完成</p>';
            }
        }
        break;

        
    case 'CREATE_TABLE' : 
        $pdo = db_open();
        
        $msg .= '<h2>資料表建立結果</h2>';
        
        foreach($a_table as $key=>$sqlstr) {
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            
            $sth = $pdo->query($sqlstr);   
            if($sth===FALSE) {
                $msg .= '<p>無法建立！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= '<p>建立完成</p>';
            }
            
        }
        break;

        
    case 'DROP_TABLE' : 
        // 連接資料庫
        $pdo = db_open();
        
        // part1: table
        $msg .= '<h2>資料表刪除結果</h2>';
        foreach($a_table as $key=>$sqlstr) {
            $msg .= '<h3>資料表『' . $key . '』</h3>';
            
            $sqlstr = 'DROP TABLE ' . $key;
            $sth = $pdo->exec($sqlstr);   

            if($sth===FALSE) {
                $msg .= '<p>無法刪除！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= '<p>刪除成功</p>';
            }
        }

        // part2: delete view
        $msg .= '<h2>資料 VIEW 刪除結果</h2>';
        foreach($a_view as $key=>$sqlstr) {
            $msg .= '<h3>資料 VIEW『' . $key . '』</h3>';
            
            $sqlstr = 'DROP VIEW ' . $key;
            $sth = $pdo->exec($sqlstr);   

            if($sth===FALSE) {
                $msg .= '<p>無法刪除！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= '<p>刪除成功</p>';
            }
        }
        break;
        

                
    case 'CREATE_VIEW' : 
        $pdo = db_open();
        
        $msg .= '<h2>資料 VIEW 建立結果</h2>';
        
        foreach($a_view as $key=>$sqlstr) {
            $msg .= '<h3>資料 View『' . $key . '』</h3>';
            
            $sth = $pdo->query($sqlstr);   
            if($sth===FALSE) {
                $msg .= '<p>無法建立！</p>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
                $msg .= '<p>建立完成</p>';
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
        catch (PDOException $e) {
            die("DB ERROR: ". $e->getMessage());
        }
    
        $msg .= '<h2>資料庫建立</h2>';
        $msg .= print_r($pdo->errorInfo(),TRUE);
        $msg .= '<p>資料庫『' . DB_DATABASE . '』</p>';
        $msg .= '<p>' . $sqlstr . '</p>';
        $msg .= '<p>如要刪除 DROP DATABASE ' . DB_DATABASE . '</p>';
        break;
        
        
        
    case 'SQL_QUERY' :
        if(empty($sql)) {
            $msg .= <<< HEREDOC
            <h3 style="margin:0px;">SQL 範例：查詢 Tables and Views</h3>
            <ul>
                <li>SHOW TABLES</li>
                <li>SHOW TABLE STATUS</li>
                <li>SHOW FULL TABLES IN class WHERE TABLE_TYPE LIKE 'VIEW'</li>
            </ul>
HEREDOC;
            // Tables
            $msg .= '<h3 style="margin:0px;">顯示定義裡的 Tables</h3>';
            $msg .= '<ul style="display: inline-block; text-align: left">';
            foreach($a_table as $key=>$sqlstr) {
                $msg .= '<li>SELECT * FROM ' . $key . '</li>';
            }
            $msg .= '</ul>';

            // Views
            $msg .= '<h3 style="margin:0px;">顯示定義裡的 Views</h3>';
            $msg .= '<ul style="display: inline-block; text-align: left">';
            foreach($a_view as $key=>$sqlstr) {
                $msg .= '<li>SELECT * FROM ' . $key . '</li>';
            }
            $msg .= '<ul>';
        }
        else {
            $pdo = db_open();
            
            $sqlstr = $sql;
            $sth = $pdo->query($sqlstr);
            
            if($sth===FALSE) {
                $msg .= '<h3>執行結果失敗！</h3>';
                $msg .= print_r($pdo->errorInfo(),TRUE);
            }
            else {
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
        foreach($a_table as $key=>$sqlstr) {
            $msg .= '<h3>' . $key . '<h3>';
            $msg .= '<pre>' . $sqlstr . '</pre><hr />';
        }
        
        $msg .= '<h2>資料 VIEW (程式內定義)</h2>';
        foreach($a_view as $key=>$sqlstr) {
            $msg .= '<h3>' . $key . '<h3>';
            $msg .= '<pre>' . $sqlstr . '</pre><hr />';
        }

        $msg .= '<h2>預設 SQL (程式內定義)</h2><hr />';
        foreach($a_record as $key=>$sqlstr) {
            $msg .= '<pre>' . $sqlstr . '</pre>';
        }
        $msg .= '</div>';
        $msg .= '</td></tr></table>';
        break;
        
        
        
    default :
        $msg .= '';

}



$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統 - 安裝程式</title>
<script>
function menu_toggle() {
    var obj = document.getElementById('menu');
    var str = (obj.style.display=='block') ? 'none' : 'block';
    obj.style.display = str;
}
</script>
</head>
<body>
<h2>初始安裝工具程式</h2>
<button onclick="location.href='?';">回首頁</button>
<button onclick="menu_toggle();">顯示功能表</button>
<div id="menu" style="display:none; background-color:#FFEE88;">
    <h3>安裝資料庫及資料表</h3>
    <ul>
        <li><a href="?do=CREATE_DATABASE">建立資料庫 (建議避免)</a></li>
        <li><a href="?do=CREATE_TABLE">建立資料表</a></li>
        <li><a href="?do=CREATE_VIEW">建立View</a></li>
        <li><a href="?do=DROP_TABLE" onClick="return confirm('確定要刪除嗎？');">刪除資料表(含View)</a></li>
    </ul>

    <h3>查看狀況</h3>
    <ul>
        <li><a href="?do=VIEW_DEFINE">程式內寫的 SQL 定義</a></li>
        <li><a href="?do=DESC_TABLE">查看結構</a></li>
        <li><a href="?do=LIST_DATA">查看記錄內容</a></li>
    </ul>

    <h3>資料維護</h3>
    <ul>
        <li><a href="?do=ADD_DATA">新增預設記錄 (開發測試用)</a></li>
        <li><a href="import_csv.php" target="area_output">匯入資料 (注意：按下即執行，需預先準備好 data.csv 檔案)</a></li>
        <li><a href="upload_input.php" target="area_output">上傳檔案後匯入資料</a></li>
        <li><a href="export_csv.php" target="area_output">資料匯出存檔 (不含 uid 欄位)</a></li>
    </ul>

    <h3>SQL 測試</h3>
    </ul>
        <li><a href="?do=SQL_QUERY">SQL測試</a></li>
    </ul>
    <br>
</div> <!-- end of menu div -->

<hr>

<div style="text-align: center;">
{$msg}
</div>
<iframe src="" name="area_output" width="100%" height="200"></iframe>

</body>
</html>
HEREDOC;

echo $html;
?>