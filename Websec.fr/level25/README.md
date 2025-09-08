I understood that I need somehow to bypass the ```if (stripos($v, 'flag') !== false)``` and then I would get the flag
I tried messing with _SERVER parameter and seeing how it stores its values.
After looking for a while I searched for parse_url online and saw that it doesn't handle well malformed urls.
So I tried to mess with the url and ended up adding extra /// and it solved the level.
What happenes is that when you add /// the parse_url function doesn't know to distinguish between then different params and that's when it returns false.

Some malformations worked on the level but not on an online compiler, meaning some got patched along the PHP versions