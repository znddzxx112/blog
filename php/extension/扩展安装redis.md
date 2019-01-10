##### php扩展-phpredis

> phpredis 是c写的扩展，性能比predis好

> github地址：https://github.com/phpredis/phpredis

> 选择最新3.0.0报错，选择2.2.8就ok，可能3.0.0还不够稳定吧

```
# cd /usr/local/src
# wget  wget https://github.com/phpredis/phpredis/archive/2.2.8.tar.gz
# tar -zxvf 2.2.8.tar.gz
# cd phpredis-2.2.8/
# /usr/local/php/bin/phpize
# ./configure --with-php-config=/usr/local/php/bin/php-config
# make && make install
/usr/local/php/lib/php/extensions/no-debug-non-zts-20131226/
// 将生成redis.so复制到扩展目录

// 配置文件增加扩展
# vi /usr/local/php/etc/php.ini
最后添加 extension="redis.so"

// 重启apache或者php-fpm

// 检查是否增加扩展
# php -m | grep redis
```
