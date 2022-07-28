<?php
/* my_form v0.1  @Shinjia  #2022/07/28 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM memb WHERE membcode=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $ss_usercode, PDO::PARAM_STR);

// 執行 SQL
try { 
    $sth->execute();

    if($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $membpass = html_encode($row['membpass']);
        
        $data = <<< HEREDOC
        <form action="edit_password_save.php" method="post" onsubmit="return check_data();">
        <table class="table">
            <tr>
                <th>密碼</th>
                <td>
                    <input type="password" name="membpass" id="membpass" value="">
                    <span id="msg_membpass" class="message_check"></span>
                </td>
            </tr>
            <tr>
                <th>請再輸入一次相同密碼</th>
                <td>
                    <input type="text" id="again" value="">
                    <span id="msg_again" class="message_check"></span>
                </td>
            </tr>
        </table>
        <p>
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

db_close();

$js = <<< HEREDOC
<style>
    .message_check {
        background-color:#FF0000;
        color:#FFFF00;;
    }
</style>

<script>
function check_data()
{
    var flag = true;
    var msg_membpass = '';
    var msg_again = '';

    // ---------- Check ----------
    
    // 輸入格式符合密碼規則
    // ^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=.\W).{6,30}$
    var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{6,20}$/;
    var password = document.getElementById('membpass').value;
    
    if(!pattern.test(password))
    {
        flag = false;
        msg_membpass = '必須符合密碼規則';
    }
    
    // -------- Check2 ------------
    var again = document.getElementById('again').value;
    if(password!=again)
    {
        flag = false;
        msg_again = '兩次密碼不一致';
    }
    
    // 最後處理
    if(!flag) 
    {
        document.getElementById('msg_membpass').innerHTML = msg_membpass;
        document.getElementById('msg_again').innerHTML = msg_again;
    }
    
    return flag;
}
</script>
HEREDOC;

//網頁顯示
$html = <<< HEREDOC
<h2>修改密碼</h2>
<h3>問題三：輸入必須符合密碼規則</h3>
<p>(必須包含數字、小寫文字、大寫文字、特殊符號、文字長度在6~20)</p>
{$ihc_content}
{$ihc_error}
HEREDOC;

include 'pagemake.php';
pagemake($html, $js);
?>