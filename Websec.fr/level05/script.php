<?php
// $q = "{eval('echo \'Hello world!\'')}";
// $corrected = preg_replace ("/(.*?)/ie", 'strtoupper("\\1")', $q);
// $input = "2 + 2; system('ls');";
// $result = preg_replace("/(.+)/e", "$1", $input);
function correct($str) {
    return "meow";
}
requiremeow.txt;
$filename = 'flag.php';
$input = '${$filename}';
$blacklist = implode (["'", '"', '(', ')', ' ', '`']);

$corrected = preg_replace ("/(.*)/ie", 'correct ("\\1")', $input);

echo "Executed code:\n";
echo $corrected;
?>