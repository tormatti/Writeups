Firstly I think I should bypass all 3 ifs, with the file I'm uploading being a php payload that will get included and I could run code on the server.

if #1:
```if ($_FILES['fileToUpload']['size'] <= 50000)``` - I don't see a reason to mess with this, my payload is not big anyway

if #2:
```if (getimagesize ($_FILES['fileToUpload']['tmp_name']) !== false)``` - as stated on the official PHP documentation - Caution
This function expects filename to be a valid image file. If a non-image file is supplied, it may be incorrectly detected as an image and the function will return successfully, but the array may contain nonsensical values.

Also the #3 if:
```if (exif_imagetype($_FILES['fileToUpload']['tmp_name']) === IMAGETYPE_GIF)``` - Uses EXIF to determine if the file is a GIF.
Now EXIF checks the start of the file to see for a magic that the files of those types have.

So I can bypass the second and third if by adding a php script and at the start of the file add the GIF magic: GIF89a

So I did and I ran the scandir command to see what is on the server.
I then saw a file called flag.txt and I file_get_contents it to see the flag

Even though I got the flag, I saw there was an uploads dir on the server so I decided to check what there is inside as well out of curiosity.
There were a lot of files:

0f797c7639ab03e7ec2d09a618d2da35eff4144b.gif
158a110b3d675c6b1271284dda6a3c93d7054857.gif
22438e95a194164c842bc05689348969a7168db7.gif
263fd03124bd231b0535a63f799feeec37feb367.gif
2ca89136d0a1bb7b740c330e94013df16a1d4268.gif
31be8ce8ba8a5d72037009cda8ea2af6b810b9bd.gif
32354d0aeec3fc85911e8755396db9efb79bfdfe.gif
3a7e881a92a5888300c59d1ae0d168ae7e9fdeca.gif
40c3e38fe4a141ac81b9c0bd1e09e3e7a16b3d43.gif
4460d18f8b8b8b95c1f202408ca02661a8561a39.gif
45230daf8eedfdcba3e48b6b1a54348cf8532de6.gif
50d6eaa498aef366376e374bcc8b9d14c2a052a5.gif
61a8d263d92e1226502e1abb6edc94b5611812db.gif
673cd415c303b8db46a0be804289d22830aa42c3.gif
721da6cc4dd9c1e89f3e4cadf58d1fa42c202097.gif
74e1a61707b5a0791feca86fde8ac1113fbba618.gif
76b57028d98a7ef26afafebb099870802688dc4d.gif
822758391a46bd8d21957fbe9e66f45e232a0438.gif
85b2df8a9a79d59f9f61d1e09cbe2817dfe2cc61.gif
88dd9f8e8534bf12c749f40f3d28826ec6ed4179.gif
8906e7b7c876b24c1f8988a69df95e0f488efa2e.gif
948daf12d9ddaeb8f19b3cddc43d6fa8e3773b42.gif
GVARIM50K+.php
REAL.php
a.php
a2a59b81d062f91ff6bd121042300911e5074804.gif
a2e9501001485b51b14858d6f2981d59bfbf4f1e.gif
a5a111835c59cacacd9c5eeff17dc729ec239917.gif
a7fd4cf47e3c3f5908b95cd1e5ed45a05e58e0c3.gif
aa8994b19927ec10f6c2366ebe8b7acad376c9f4.gif
b5d78bc2e3e82a1f0d9c9f22c9c5f22c15bc7a74.gif
b645c16594ab8b7e5d00ac02c2d32a345a87214d.gif
baad12283a24eb6e71b10529950a23c84278d6f8.gif
bc90385ccf03e749443c1aae506df89dcddf3a44.gif
c1f409648342f0a4678be41df1cff1792361bbb8.gif
c31b1a7b36649c457cce7e36d5c5bd33f146a923.gif
c8d07c8e46c45ae82c8b0f5cbd0314fcdb5e4142.gif
c8e84bf343c8313bf01e038550512286620b9ef8.gif
c9f12d569a107f4f272f085979a068f8d150cafa.gif
d5f448b1d45447906b1518b24eb2cf2b32fb1aed.gif
dade71c621f7847a8619b4b0d42159b00e3786a4.gif
de13c96272364c6201187f279d7f81dbb3e4380f.gif
e00817759552be1cfcce5d292a25aab1a34db6cd.gif
e4a23c118cc408fb90fdf92cc400f6181f9f5e6e.gif
eb03597ab67a89c2a34eb0a8bd053f1ae76b941a.gif
eb8201792e2986dbad528f43af616378beb55a27.gif
ed7153d53f3c3e1929e77a55d31c2ecfd1ae073b.gif
eval.php
f6e01bb62b8ab82bc12f84edbf1dfd32c6009022.gif
fenzy.php
fenzyman.php
flag2.txt
gerbigever.php
gif.php
hyom.txt
kuchishell.php
lib.php
likerhamelech.php
output
output.txt
output2
output2.php
phpinfo.php
shell.php
test.gif
test.php
test.so
test.txt
test2.php
test5.php
testfile.txt
webshell.php
x.php


I printed out some of them but there were probably files other people uploaded