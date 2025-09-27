<?php
$flag = "{I_LOVE_WEBSEC}";
$obj = 'O:8:"stdClass":2:{s:4:"flag";N;s:5:"input";R:2;}';
$unserialized_obj = unserialize ($obj);
$unserialized_obj->flag = $flag;
var_dump($unserialized_obj);
if (hash_equals ($unserialized_obj->input, $unserialized_obj->flag))
    echo $flag;   
else 
    echo 'error';
?>