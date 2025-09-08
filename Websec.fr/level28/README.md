I tried to look at all the various functions in there to see if anything is unsafe or I can abuse like: md5_file, fread, fopen, fclose etc. etc. 
And then I got stuck because I thought it was something to do with a broken logic or function with php like the previous levels.
But then I looked at it like a normal script and saw that there is a logical flaw within the script and I can upload a file and access it before it gets deleted.

I attacked the python script I used and a simple php script that just prints the flag