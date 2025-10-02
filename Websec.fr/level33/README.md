I can see that in the code, what I need to do is make the unserialize throw a fatal error so the code doesn't reach the ```ob_end_clean();```.

I used: ```O:7:"SQLite3":0:{}```
Which gave me the flag.

After submitting the flag I saw another payload that people used that could work was just making the code run out of memory:
```a:1000000000:{}```