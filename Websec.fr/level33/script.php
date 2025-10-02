<?php
    $flag = "flag!!!";
    class B {
    function __destruct() {
        global $flag;
        echo $flag;
    }
    }
    $payload = 'O:16:"SimpleXMLElement":1:{s:2:"ab"}';

    $a = unserialize($payload);



?>