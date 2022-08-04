<?php
include '../common/config.php';
include '../common/define.php';
include '../common/utility.php';
include '../common/function.get_entry_in_dir.php';

$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM product WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':uid', $uid, PDO::PARAM_INT);


// 執行 SQL
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $prod_code = convert_to_html($row['prod_code']);
      $prod_name = convert_to_html($row['prod_name']);
      $category = convert_to_html($row['category']);
      $description = convert_to_html($row['description']);
      $price_mark = convert_to_html($row['price_mark']);
      $price = convert_to_html($row['price']);
      $picture = convert_to_html($row['picture']);
      $pictset = convert_to_html($row['pictset']);
   }
   else
   {
 	   $data = '查不到相關記錄！';
   }
}
else
{
   // 無法執行 query 指令時
   $data = error_message('display');
}

//=======================================================

// 依類型定義相對應的路徑目錄
$path_img = '../upload/' . $pictset . '/';


// 讀取目錄列出檔案
$a_dir = get_entry_in_dir($path_img, 'FILE');  // 讀取實際檔案
sort($a_dir);

// 移除非 .jpg 檔
foreach($a_dir as $key=>$one)
{
   $tmp=explode(".", $one);
   $file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
   if(strtolower($file_ext)!='jpg')
   {
      unset($a_dir[$key]); 
   }
}

//echo $path_img;
//echo '<pre>';
//print_r($a_dir);
//echo '</pre>';

$cnt = 0;
$columns = 4;
$data = '';
$data .= '<TABLE style="margin:0px 0px 0px 30px;">';
foreach($a_dir as $one)
{
   
   // 多欄處理：若為第一欄，資料顯示前需要先加上新列的頭 <TR)>
   if(($cnt % $columns)==0)
   {
      $data .= '<TR>';
   }
 
   $file_link = $path_img . '/' . $one;
   $file_show = $path_img . '/' . $one;
   
   $img_size = 200;
   $show_w = 200 + 10;
   $show_h = 200 + 20;
   $data .= <<< HEREDOC
      <td align="center" style="width:{$show_w}px;">
        <div class="table_empty">
        <table>
          <tr><td align="center" width="300">
          <a href="{$file_link}" rel="lightbox[patt]">
            <img src="{$file_show}" border="0" style="vertical-align: middle; max-width:160px; max-height:160px; _width:expression(this.width > 200 && this.width > this.height ? 100: auto);">
          </a></td></tr>
          <tr><td align="center">
          <span style="display:none;">
            | <a href="{$file_link}">下載</a>
            | <a href="prod_img_delete.php?uid={$uid}&file={$one}" onclick="return confirm('確定要刪除嗎？ ');">刪除</a>
            </span>
            <input type="button" value="顯示" onclick="window.location.href='{$file_link}';">
            <input type="button" value="刪除" onclick="do_delete('{$one}');">
            </td></tr>
        </table>
        </div>
      </td>
HEREDOC;
   
      
   // 多欄處理：若為最後一欄，資料顯示後需要加上此列的尾 </TR>
   if(($cnt % $columns)==($columns-1))
   {
      $data .= '</TR>';
   }

   $cnt++;
}
   
           
// 多欄處理：若每頁筆數($numpp)未調整成欄數的倍數，則每頁均需補後面不足的空項
$cnt1 = $cnt % $columns;  // 此列已顯示的項目數
if( ($cnt1<$columns) && ($cnt1>0) )  // 不是最後也不是第一個
{
   for($i=$cnt1+1; $i<=$columns; $i++)
   {
      $data .= '<TD><DIV style="width:180px;">&nbsp;</DIV></TD>';
   }
   $data .= '</TR>';
}

$data .= '</TABLE>';

$data_input = <<< HEREDOC
<form name="form1" method="post" action="prod_img_save.php" enctype="multipart/form-data"> 
  <div class="table_empty">  
  <table>
    <tr>
      <td>新檔案上傳：</td>
      <td>
        <input type="file" name="file">
        <input type="hidden" name="uid" value="{$uid}">
        <input type="hidden" name="MAX_FILE_SIZE" value="20000000"><input type="submit" value="上傳"> (可上傳.jpg檔，或.zip自動解壓)
      </td>
    </tr>
  </table>
  </div>
</form>
HEREDOC;






        // 顯示各張圖
        

// 依類型定義相對應的路徑目錄
$path_img = '../upload/' . $pictset;

// 讀取目錄列出檔案
$a_dir = get_entry_in_dir($path_img, 'FILE');  // 讀取實際檔案
sort($a_dir);

// 移除非 .jpg 檔
foreach($a_dir as $key=>$one)
{
   $tmp=explode(".", $one);
   $file_ext   = end($tmp);  // 最後一個小數點後的文字為副檔名
   if(strtolower($file_ext)!='jpg')
   {
      unset($a_dir[$key]); 
   }
}

$cnt = 0;
$data .= '<code>';
foreach($a_dir as $one)
{
   $file_show = $path_img . '/' . $one;
   
   $img_size = 200;
   $a_size = getimagesize($file_show);
   $str_size = $a_size[3];
   
   $data .= <<< HEREDOC
<br>
&lt;img src="{$file_show}" {$str_size}&gt;
<br>
HEREDOC;
   
}
$data .= '<br></code>';   


$ihc_head = '';

$ihc_head .= <<< HEREDOC
<style type="text/css">
CODE { display: block; /* fixes a strange ie margin bug */ 
       font-family: Courier New;
       font-size: 8pt; 
       overflow:auto; 
       background: #FFFFBF url(images/code_bar.gif) left top repeat-y; 
       border: 1px solid #ccc; 
       padding: 10px 10px 10px 21px; 
       max-height:600px; 
       line-height: 1.2em; }
</style>
HEREDOC;

        
        



$ihc_head .= <<< HEREDOC
<script language="javascript">
function do_delete(fname)
{
   if(confirm('確定要刪除嗎？'))
   {
      window.location.href= 'prod_img_delete.php?uid={$uid}&file=' + fname;
   }
}
</script>
HEREDOC;

   
$ihc_head .= '
<script src="../lightbox/js/jquery-1.7.2.min.js"></script>
<script src="../lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="../lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="../lightbox/js/lightbox.js"></script>
<link rel="stylesheet" href="../lightbox/css/lightbox.css" type="text/css" media="screen" />
';



$ihc_html = <<< HEREDOC
<p>
產品代號：{$prod_code}<br/>
產品名稱：{$prod_name}
<hr />
{$data_input}
<BR>
{$data}
HEREDOC;


$ihc_html .= <<< HEREDOC
<script>
  jQuery(document).ready(function($) {
      $('a').smoothScroll({
        speed: 1000,
        easing: 'easeInOutCubic'
      });

      $('.showOlderChanges').on('click', function(e){
        $('.changelog .old').slideDown('slow');
        $(this).fadeOut();
        e.preventDefault();
      })
  });
/*
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
*/
</script>
HEREDOC;


include 'pagemake.php';
pagemake($ihc_html, $ihc_head);
?>