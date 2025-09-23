I have access to the $blacklist array which holds all the forbidden functions.
The problem is [] is blocked so I can't call the functions.
I found that in earlier version of php you can use {} instead of [] to access variables.
This means I can bruteforce and call each function untill I find var_dump()
I have wrote a script for this in script.php.
by mistake I found serialize() and not var_dump() but idc

WEBSEC{But_I_was_told_that_OOP_was_flawless_and_stuff_:<}