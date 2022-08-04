<?php
$code = isset($_GET['code']) ? $_GET['code'] : 'XX';

switch($code)
{
    case '台北' :
        $a_data = array('木柵', '萬華', '信義', '大同' );
        break;
    
    case '新北' :
        $a_data = array('板橋', '三重', '永和', '新莊', '新店' );
        break;
    
    default:
        $a_data = array('xxx', 'yyy', 'zzz');
}


$str = '';
$str .= '<select size="6">';
foreach($a_data as $one) {
    $str .= '<option>' . $one . '</option>' . "\n";
}
$str .= '</select>';

echo $str;
?>