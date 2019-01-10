```
新建game01
groupadd game01
useradd game01 -M -s /sbin/nologin -g game01

fpm使用game01运行
fpm.conf:
listen.owner = game01
listen.group = game01
user=game01
group=game01

nginx使用www运行:
usermod -aG game01 www

文件夹权限和所有权,fpm有所有权限，www只有读的权限即可:
chmod 750 -R game01
cd /home/wwwroot/
chown game01.game01 -R game01

vsftp使用game01用户，vsftp是允许禁止登录的用户进行ftp上传
参考：http://blog.51cto.com/cuimk/1306637
```
