I first tried to look for vulnerable functions that could help me.
I looked at explode, implode, unset and even (int), but nothing.

But then I looked closer and tried to look at the problem not from a php point a view, and the solution was easy.

It's a classic mistake to iterate over an array and change the size of it while iterating over it.

So the solution is easy, non integer values will not be checked if they are at the end of the array and there are non integer elements at the start.

I first tried to input ```,0```, and it worked!
I got: User admin with id 0 has all privileges.

So I then proceeded to sqli this:
```,,,)) union SELECT user_password user_id,1,1 FROM users--```
And then I got the flag!!