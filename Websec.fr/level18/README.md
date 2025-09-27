For this level I first looked at the php version on the site per usual (5.6.26) and saw that we evaluate the strings with (hash_equals).

I tried searching online for known vulneralities and when I didn't find any I opened the source code (https://github.com/php/php-src/blob/dd1b97c3de8bca56c97cb47936726d9b4b79afe1/ext/hash/hash.c#L739)

I saw that in difference to the more new version of php, here the compiler checks if the strings are the same size and if they are not it immediately returns false. This is a gate to timing attacks but I'm sure it's not the intended solution.

Then I looked more carefully at the code and found the solution, I'll just pass an object which the input field points to the flag field.

Payload:
```O:8:"stdClass":2:{s:4:"flag";N;s:5:"input";R:2;}```
Which means the flag attribute is null and the input has a refference (R) to the second variable (stdClass being the first)

We pass this as the cookie and get the flag:
WEBSEC{You_have_impressive_refrences._We'll_call_you_back.}
