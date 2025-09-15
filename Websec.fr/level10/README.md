At first I looked at the way the page calculates the MD5s, I know that MD5 is breakable but I gave up pretty quickly because I didn't think I would get asked that.

Then I saw the loose comparison in ```$request == $hash``` and thought that if I could pass a hash that could use type juggling to bypass the statement while still having flag.php passed in the file I would do it.
I searched online for the tpye junggling diagram and say that strings that this is vulnerable to type juggling "0e99" == 0 => True.

The thing is the hash when just passing flag.php doesn't start with a 0.

Then I read online that show_source can get as many leading .///// before the file name and it will not error.

So I made a script to brute_force in and I succeeded