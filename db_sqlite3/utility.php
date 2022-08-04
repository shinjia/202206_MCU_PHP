<?php

function error_message($type='', $ext='')
{
   $a_msg = array(
     'add_save'    => '無法新增資料 (add_save)',
     'display'     => '無法列出資料 (display)',
     'list_all'    => '無法列出資料 (list_all)',
     'list_page'   => '無法列出資料 (list_page)',
     'list_page_1' => '無法列出資料 (list_page_1)',
     'list_page_2' => '無法列出資料 (list_page_2)',
     'edit'        => '無法編輯資料 (edit)',
     'edit_save'   => '無法修改資料 (edit_save)',
     'delete'      => '無法刪除資料 (delete)',
	  'default'     => '有錯誤發生！' );

   $msg = isset($a_msg[$type]) ? $a_msg[$type] : $a_msg['default'];
   
   if($type=='page')
   {
      $msg = '檔案資料『" . $ext . "』不存在';
   }
   
   $ret_str  = '<h2>錯誤警告</h2>';
   $ret_str .= '<p>' . $msg . '</p>';

   return $ret_str;
}


function convert_to_html($sText)
{
   /* 幾個和html轉換有關的函式
    * addslashes() 在特定的符號前加反斜線 (包括 ' " \ 及 NULL)
     (使用get_magic_quotes_gpc() 檢查，若為真，則不能再次使用 addslashes)
    * stripslashes() 刪除由addslashes() 函式增加的反斜線
    * htmlspecialchars() 轉換下表的五個符號
    * htmlentities() 除了轉換下表的五個符號, 也轉換中文 (速度慢)
    * htmlspecialchars_decode() 是htmlspecialchars的反函式
    * html_entity_decode() 是htmlentities的反函式
    * mysql_real_escape_string() 轉換在SQL指令中使用的特殊符號 (包括 x00 \n \r ' " x1a)   
   -----------------------------------------
     & (ampersand)     &amp;
     " (double quote)  &quot;
     ' (single quote)  '&#039; or &apos;
     < (less than)     &lt;
     > (greater than)  &gt;
   -----------------------------------------
   */
   $_str = $sText;
	
   $_str = htmlspecialchars($_str, ENT_QUOTES, 'UTF-8');
   //$_str = preg_replace("/&amp;#([[:alnum:]]{3,5});/is","&#\\1;",$_str);
   //$_str = preg_replace("/&amp;([[:alpha:]]{2,7});/is","&\\1;",$_str);
   //$_str = str_replace("\"","&quot;",$_str);
   //$_str = str_replace("'","&#39;",$_str);

   return $_str;
}

?>