I googled about bypassing the 'open_basedir' and stumbled upon a nice exploit for it.
Inside the the ```/sandbox``` dir there is a ```tmp``` dir (I got this with scandir()), which can help me do the following.
I can run this payload:
```chdir("tmp/");ini_set("open_basedir", "../");chdir("../");chdir("../");var_dump(file_get_contents("./flag.php"));```
Which does this:
- it changes the working dir into /tmp, this is allowed because it is inside /sandbox
- it sets open_base_dir to ../. In the documentation it says that during runtime this can always be hardened. This is allowed becasuse this is interpreted to /sandbox/tmp/../ -> /sandbox
- but then ```../``` is added to the path whitelists which can be used, so we can change the working dir by doing ../ ../ ../ until we get to the flag directory
- read the flag