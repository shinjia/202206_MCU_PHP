<?php
/* db2_pdo_cookie v1.0  @Shinjia  #2022/07/22 */

include 'config.php';

$table_name = 'person'; // 指定資料表名稱

$sqlstr_install_table = '
CREATE TABLE person (
    uid int NOT NULL auto_increment,
    usercode varchar(255) NULL,
    username varchar(255) NULL,
    address  varchar(255) NULL,
    birthday date default NULL,
    height   int default NULL,
    weight   int default NULL,
    remark   varchar(255) NULL,
    PRIMARY KEY  (uid)
)';


$op = isset($_GET['op']) ? $_GET['op'] : 'HOME';


$msg = '';
switch($op)
{
    case 'CREATE_TABLE' :
        $msg .= '資料表『' . $table_name . '』';

        $pdo = db_open();
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
        $sqlstr = $sqlstr_install_table;
        try
        {
            $pdo->exec($sqlstr);
            $msg .= '建立成功！';
        }
        catch(PDOException $e)
        {
            $msg .= '無法建立！<br>';
            $msg .= $e->getMessage();//Remove or change message in production code
        }
        break;


    case 'DROP_TABLE' :
        $msg .= '資料表『' . $table_name . '』';

        $pdo = db_open();
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling

        $sqlstr = 'DROP TABLE ' . $table_name;
        try
        {
            $pdo->exec($sqlstr);
            $msg .= '刪除成功！';
        }
        catch(PDOException $e)
        {
            $msg .= '無法刪除！<br>';
            $msg .= $e->getMessage();//Remove or change message in production code
        }
        //$sth = $pdo->exec($sqlstr);   
        //$msg .= '資料表『' . $table_name . '』';
        //$msg .= ($sth===TRUE) ? '刪除完成！' : '無法刪除！<br/>'.print_r($pdo->errorInfo(), TRUE);
        break;


    case 'CREATE_DATABASE' :
        $msg .= '資料庫『' . DB_DATABASE . '』';

        $pdo = new PDO('mysql:host='.DB_SERVERIP, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling

        $sqlstr = 'CREATE DATABASE ' . DB_DATABASE . ' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
        try
        {
            $pdo->exec($sqlstr);
            $msg .= '建立成功！';
        }
        catch(PDOException $e)
        {
            $msg .= '無法建立！<br>';
            $msg .= $e->getMessage();//Remove or change message in production code
        }

        break;


    default:
        $msg = '';
}



$html = <<< HEREDOC
<h2>資料庫安裝程式</h2>
<ul>
    <li><a href="install.php?op=CREATE_TABLE">安裝資料表 (person)</a></li>
    <li><a href="install.php?op=DROP_TABLE">移除資料表 (person)</a></li>
    <li><a href="install.php?op=CREATE_DATABASE">安裝資料庫 (class)</a></li>
</ul>
<hr />
{$msg}

HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>