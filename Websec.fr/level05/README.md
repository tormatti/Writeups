This level was pretty easy, it uses the /e identifier in preg_replace which takes all of the matches characters, and runs it as a code.
This is a known RCE and is patched since PHP 7.
The thing is that I am obligated to not use any character in the blacklist.
Also I am inside a ```correct()``` functions which means I have to encapsulate my payload with ${} so it actually runs and doesn't just get interpreted as a string.
Based on the comments inside the code the flag is in a $flag varbiale inside the flag.php file, so what I want to run is:
```${include 'flag.php'} ${$flag}``` which will include the file and run the ```correct()``` function on the flag and print it to us.
We need to deal with the blacklist, in our payload there are these things we need to solve:

1) ```'flag.php'``` - We can't use ''
2) The spaces that we can't use

for the first one we can just pass it in another parameter to the server like this: ```${include $_REQUEST[file]}``` and it will pass all the checks, then when the eval runs on it, it will substitue it for the parameter referenced.

for the second one I tried to mess with it and found 2 things:
- turns out we don't need spaces. Turns our internal php functions like include and require don't need to have a space between them and the param
- if we really want to we can use either tabs or newlines

So the final payload could be either:
```q=${include$_REQUEST[file]}${$flag}&file=flag.php&submit=```
or:
```q=${include%09$_REQUEST[file]}%0A${$flag}&file=flag.php&submit=``` (%09 - Tab url encoded, %0A - newline url encoded)

And this gives us our flag:
WEBSEC{Writing_a_sp3llcheckEr_in_php_aint_no_fun}

I will say that I tried for a long time to get a working RCE without limitations and didn't succeed, I will maybe come back to this sometime