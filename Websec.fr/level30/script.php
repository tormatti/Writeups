<?php
    $flag = "flag!!!";
    class B {
    function __destruct() {
        global $flag;
        echo $flag;
    }
    }
    $a = [new B(), new B()];
    var_dump(serialize($a));

?>