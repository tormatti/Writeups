The PHP create_function() documentation clearly states the problem, when creating this function there is an internal eval that runs.

I first tried passing ```echo $flag``` but that didn't work, because the eval is ran internally and doesn't run the function itself.

So I just escaped it:

```};echo $flag;```

But that didn't work, so I just added // to the end to comment anything that would give me a syntax exception:
```};echo $flag;//```