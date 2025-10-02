<?php 
$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
function r_generate_strings($len, $prefix = '') {
    global $charset;
    if ($len === 0) {
        return $prefix . ",";
    }

    $final = '';
    for ($i=0;$i<strlen($charset);$i++){
        $final .= r_generate_strings($len-1, $prefix . $charset[$i]);
    }
    return $final;
}


$len = 4;
for($i = 0; $i < $len; $i++){
    $strings = r_generate_strings($i);
    $strings_arr = explode(",", $strings);
    foreach($strings_arr as $str) {
        $sha = md5($str);
        print_r($sha[1]);
        if($sha[1] === "4")
            echo "Found it: " . $str . "\n";
    }

}

?>
