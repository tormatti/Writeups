I did use Burp to solve this with type juggling and pass flag[].

But I did it as well without Burp by editing the source code of the site to this:
<input name="flag[]" class="form-control" type="text" placeholder="Guessed flag">