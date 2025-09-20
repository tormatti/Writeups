This level I can guess the seed because microtime puts out a float but srand takes an int so I can bruteforce it.
I then can guess the csrf_token and captcha and pass the captcha to get a recover mail.
Also the recover mail is sent based on the ```$_SERVER['HTTP_HOST']``` and that can be manipulated via the Host header in a http req.

P.S
The script works, but when I change the Host header I get a 404. this is really weird, I will come back to this to get my flag!
WEBSEC{I_will_build_a_great_password_reset_form_and_have_albinowax_pay_for_it}