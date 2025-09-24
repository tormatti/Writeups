At first I noticed that the [] check doesn't work, I can pass a [] and the sha1() function will return "" because it got an array.

Second I tried this as my input: ```);$h2=crypt('123', '$2y$04$00000000$');//``` in hopes that I will be able to escape it and make use of a known CVE in password_verify, where if the salt part has a $ in it it will bug out and return true, but didn't work.

Then I saw another known CVE, where if password_verify gets a hash that starts with a null byte, an empty password will work.
https://github.com/php/php-src/security/advisories/GHSA-h746-cjrr-wfmr

I investigated more into this CVE and understood that it works because when password_verify sees a null byte it interprets it as the end of the string because behind the scenes it uses a C compiler that sees it as a delimiter.
So I then had the idea to see if a hash is the same until a null byte if the vulnerability would still work, and it did:

```
$flag = "\x23\x00\x12";
$pw   = "\x23\x00\x99";

$hash = password_hash($flag, PASSWORD_DEFAULT);

var_dump(password_verify($pw, $hash));
```
Outputs: True

I then looked at the provided hash of the flag and I saw that the second byte is a null byte so I just had to find a string that when hashed it wil give me the same first byte and a null byte at the end. 

I wrote a php (./script.php) to brute force strings and found 2 that work: CWM and 0EK