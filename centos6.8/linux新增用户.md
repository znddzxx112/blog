```
# groupadd www
// 设置不可切换
// 建议只允许www为上传代码，apache设置user,group为www
# useradd www -d /usr/local/src/bitcao -s /sbin/nologin -g www
# passwd www //设置登录密码
# chown -R bitcao:www /usr/local/src/bitcao

# groupadd www
# useradd -M -s /sbin/nologin -g www www
```
