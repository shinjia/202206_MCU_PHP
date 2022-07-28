<?php
/* my_form v0.1  @Shinjia  #2022/07/27 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

include '../common/function.get_entry_in_dir.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

// 指定照片的資料夾
$path = DEF_PHOTO_PATH;
$path_img = $path . $ss_usercode;

// 讀取目錄列出檔案
$a_dir = get_entry_in_dir($path_img, 'FILE');  // 讀取實際檔案
sort($a_dir);

// 移除非 .jpg, .png 檔
foreach($a_dir as $key=>$one) {
    $tmp = explode(".", $one);
    $file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
    if(strtolower($file_ext)!='jpg' && strtolower($file_ext)!='png') {
        unset($a_dir[$key]); 
    }
}

//echo $path_img;
//echo '<pre>';
//print_r($a_dir);
//echo '</pre>';

$cnt = 0;
$columns = 2;
$data = '';
$data .= '<table style="margin:0px 0px 0px 30px;">';
foreach($a_dir as $one) {
    // 多欄處理：若為第一欄，資料顯示前需要先加上新列的頭 <TR)>
    if(($cnt % $columns)==0) {
        $data .= '<tr>';
    }
    
    $file_show = $path_img . '/' . $one;
    $file_link = $path_img . '/' . $one;
    
    $img_size = 400;
    $show_w = 400 + 10;
    $show_h = 400 + 20;
    $data .= <<< HEREDOC
    <td align="center" style="width:{$show_w}px;  border:1px; border: 1px solid black;">
        <div class="table_empty">
        <table>
        <tr><td align="center" width="400">
        <a href="{$file_link}" rel="lightbox[patt]">
            <img src="{$file_show}" border="0" style="vertical-align: middle; max-width:400px; max-height:200px; _width:expression(this.width > 400 && this.width > this.height ? 400: auto);">
        </a></td></tr>
        <tr><td align="center">
        <span style="display:none;">
            | <a href="{$file_link}">查看</a>
            | <a href="image_delete.php?file={$one}" onclick="return confirm('確定要刪除嗎？ ');">刪除</span></a>
            </span>
            <input type="button" value="{$one}" onclick="window.location.href='{$file_link}';">
            <input type="button" value="刪" onclick="do_delete('{$one}');">
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        </table>
        </div>
    </td>
HEREDOC;

    // 多欄處理：若為最後一欄，資料顯示後需要加上此列的尾 </TR>
    if(($cnt % $columns)==($columns-1)) {
        $data .= '</tr>';
    }

    $cnt++;
}

// 多欄處理：若每頁筆數($numpp)未調整成欄數的倍數，則每頁均需補後面不足的空項
$cnt1 = $cnt % $columns;  // 此列已顯示的項目數
if( ($cnt1<$columns) && ($cnt1>0) )  // 不是最後也不是第一個
{
    for($i=$cnt1+1; $i<=$columns; $i++) {
        $data .= '<td><div style="width:400px;">&nbsp;</div></td>';
    }
    $data .= '</tr>';
}

$data .= '</table>';

// 沒有圖的情況
if(!$a_dir) {
    $data = '目前沒有圖片';
}

$data_input = <<< HEREDOC
<form name="form1" method="post" action="image_save.php" enctype="multipart/form-data"> 
    <div class="table_empty">  
        <h2>圖檔管理</h2>
        <p>
            <input name="file[]" type="file" multiple="multiple" />
            <input type="hidden" name="MAX_FILE_SIZE" value="20000000">
            <input type="submit" value="上傳"> 
        </p>
        <p> (可上傳.jpg, .png 或.zip 自動解壓；可選擇多個檔案)</p>
    </div>
</form>
HEREDOC;


$head = <<< HEREDOC
<script>
function do_delete(fname)
{
    if(confirm('確定要刪除嗎？'))
    {
        window.location.href= 'image_delete.php?file=' + fname;
    }
}
</script>
HEREDOC;


$html = <<< HEREDOC
{$data_input}
<br><hr>
{$data}
<br>
HEREDOC;

include 'pagemake.php';
echo pagemake($html, $head);
?>