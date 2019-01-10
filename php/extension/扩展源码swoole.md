- swoole使用c语言编写的扩展
- pecl
```
# pecl search swoole
# pecl install swoole
# pecl install swoole-2.0.7
```

- 源码安装
```
# http://pecl.php.net/package/swoole
# wget http://pecl.php.net/get/swoole-2.0.7.tgz
# tar -zxvf swoole-2.0.7.tgz
# cd swoole-2.0.7
# /usr/local/php7/bin/phpize 
# ./configure --help
#  ./configure --with-php-config=/usr/local/php7/bin/php-config --enable-swoole-debug
# make && make install
```

- php.ini 写入swoole.so
```
extension = swoole.so
```
