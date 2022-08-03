# Control panel for Yandex 360 (ex Connect) api 
[![GitHub issues](https://img.shields.io/github/issues/TSUKER/yaapi)](https://github.com/TSUKER/yaapi/issues)
[![GitHub forks](https://img.shields.io/github/forks/TSUKER/yaapi)](https://github.com/TSUKER/yaapi/network)
[![GitHub stars](https://img.shields.io/github/stars/TSUKER/yaapi)](https://github.com/TSUKER/yaapi/stargazers)
[![GitHub license](https://img.shields.io/github/license/TSUKER/yaapi)](https://github.com/TSUKER/yaapi)
![visitors](https://visitor-badge.glitch.me/badge?page_id=TSUKER.yaapi)

## Requirements

Supported distributions:

- Ubuntu
- Debian 
- Fedora
- CentOS
- Arch Linux
- Oracle Linux
- Windows

- PHP 7+

## Usage

Download and copy to web directory. go web-browser
Register yandex api https://yandex.ru/dev/id/doc/dg/oauth/tasks/register-client.html(https://yandex.ru/dev/id/doc/dg/oauth/tasks/register-client.html)
Config in config.php :
    `` $token = 'AQAAAAAumXvwAAbP2epoV3UIx0-VvrxoixRtmbw'; // Token YANDEX API https://oauth.yandex.ru/ ``
    `` $APP_ID = '015685e8229e4df0b6620e5c2a453b37'; // ID app yandex https://oauth.yandex.ru/ ``
    `` $APP_PWD =  '255cff3005c540fb977683956ccbf133'; // Password app yandex https://oauth.yandex.ru/ ``

For security use: 

#in .htaccess file in the folder you're trying to protect
AuthType Basic
AuthName "This Area is Password Protected"
AuthUserFile /full/path/to/.htpasswd
Require valid-user

#put in a .htpasswd file in a  non-public facing directory
#you can generate a password here: http://www.htaccesstools.com/htpasswd-generator/
trueadmin:$apr1$O/BJv...$vIHV9Q7ySPkw6Mv6Kd/ZE/

## Providers

I recommend these cheap cloud providers for your VPN server:
- [Hetzner](https://hetzner.cloud/?ref=Txj9RI7g08TN): Germany and Finland and USA , IPv6, 20 TB of traffic, starting at €3/month
- [Digital Ocean](https://m.do.co/c/1a7411d7a9a1): Worldwide locations, IPv6 support, starting at \$5/month
- [Vultr](https://www.vultr.com/?ref=8813484): Worldwide locations, IPv6 support, starting at \$3.50/month
