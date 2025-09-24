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
        $sha = sha1($str, true);
        if($sha[0] === "\x7c" && $sha[1] === "\x00")
            echo "Found it: " . $str . "\n";
    }

}

?>
