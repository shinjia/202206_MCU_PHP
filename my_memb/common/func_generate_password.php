<?php

function generate_password($length=8)
{
    $s1 = 'abcdefghijklmnopqrstuvwxyz';
    $s2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $s3 = '1234567890';
    $s4 = '!@#$%^&()_+.,';
    $s_all = $s1 . $s2 . $s3 . $s4;

    $ary = array();
    array_push($ary, substr($s1, mt_rand(0, strlen($s1)), 1));
    array_push($ary, substr($s2, mt_rand(0, strlen($s2)), 1));
    array_push($ary, substr($s3, mt_rand(0, strlen($s3)), 1));
    array_push($ary, substr($s4, mt_rand(0, strlen($s4)), 1));

    for($i=4; $i<$length; $i++) {
        array_push($ary, substr($s_all, mt_rand(0, strlen($s_all)), 1));
    }
    
    return str_shuffle(implode($ary));
}

?>
