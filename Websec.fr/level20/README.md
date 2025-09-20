I first tried to understand what the 2 checks do:
1) Checks that there are no capital letters and ":" after them
2) Checks that there is no "O:" string with certain characters before/start of string and doesn't have either a number or a + after it

I looked at the provided CVE and what he does there is add a + before the size of the object's name to bypass the check, but in our case this is being checked as well...

I understood that the first check will not help me and started looking at ways to break the second check.

I tried adding multiple weird characters before or after the "O:" to help me bypass the check but nothing helped.

I then started looking at serialization formats in php and stumbled upon this page:
https://www.phpinternalsbook.com/php5/classes_objects/serialization.html

Which states that you can serialize a Class object using "C:" if the class implements the Serializable interface and the coresponding functions.

I then saw that Flag doesn't implement this but tried it anyway.

I passed into the cookie: ```C:4:"Flag":0:{}``` and then the site crashed!

Which meant it worked but something went wrong, I wasn't getting a b:0 output like until now which means the unserialization worked but then the code crashes somewhere after.

I then looked at the code an it was obvious, ```$data``` which was getting my unserialized object was being treated like an array and when it got a Flag instance instead it made the code crash.

So instead I passed this: ```a:1:{i:0;C:4:"Flag":0:{}}``` and got the flag
I then tried to understand why this worked even though the Flag class doesn't implement the Serializable interface. I tried debugging it on my own and saw that php throws an error when doing this but still unserializes the object.

nice song btw :)