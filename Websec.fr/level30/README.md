The source code lies a bit, it tried to say that I need ob_end_clean(); to be called
So I need to make an object, and have it destructed before reaching the exception.
So I did this payload: 
```a:2:{i:0;O:1:"B":0:{}i:0;O:1:"B":0:{}}```
That makes an array, and puts the same object in the first index, so one is created and then when the second gets put in the same position we destruct and first and get the flag
WEBSEC{So_it_was_all_b(l)uff_in_the_end?}

