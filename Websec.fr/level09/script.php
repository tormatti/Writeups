<?php
//$s = "ZWNobyAibWF0dGkiOw==";
//$x = 'php://filter/read=convert.base64-decode/resource=/workspace/test';
$s = "\\x65\\x63\\x68\\x6F\\x20\\x22\\x70\\x77\\x6E\\x65\\x64\\x22\\x3B";
$x = '/workspace/test';
$s = str_replace (
                ['<?', '?>', '"', "'", '$', '&', '|', '{', '}', ';', '#', ':', '#', ']', '[', ',', '%', '(', ')'],
                '',
                $s
);
echo $s . "\n";
file_put_contents('/workspace/test', $s);
print_r(file_get_contents ($x) . "\n");
if (file_exists($x)){
    echo eval (stripcslashes (file_get_contents ($x)));
}
else {
    echo "not found";
}
?>