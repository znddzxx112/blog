
- 参考：http://php.net/manual/zh/book.opcache.php
- 参考文章：https://www.phpsong.com/1806.html

- opcache php7默认就存在ext中
```
# cd /usr/local/src/php-7.1.0/ext/opcache
# /usr/local/php7/bin/phpize 
#  ./configure --with-php-config=/usr/local/php7/bin/php-config 
# make && make install
# vim /usr/local/php7/lib/php.ini
```

- php.ini配置，php7 php.ini中已经存在
```
zend_extension = opcache.so

opcache.enable=1
opcache.revalidate_freq=20 #缓存20s
opcache.blacklist_filename=/var/www/tt/index.php
opcache.blacklist_filename=/var/www/xhgui

```

