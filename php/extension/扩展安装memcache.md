#### php扩展-memcached

- memcache的php扩展有二个：
- memcache 和 memcached（新，方法多,c语言编写）
- memcached的文档在：http://pecl.php.net/package/memcached
- memcached的方法列表在：http://www.php.net/manual/zh/book.memcached.php


##### 安装libmemcached
- 官网:https://launchpad.net/libmemcached/
```
# wget https://launchpad.net/libmemcached/1.0/1.0.18/+download/libmemcached-1.0.18.tar.gz
# tar -zxvf libmemcached-1.0.18.tar.gz 
# cd libmemcached-1.0.18
# ./configure --with-php-config=/usr/local/php/bin/php-config --with-libmemcached-dir=/usr/local/libmemcached --with-memcached
# make && make install
```

##### 安装php-memcached

- github:https://github.com/php-memcached-dev/php-memcached
```
# tar -zxvf php-memcached-2.2.0RC1.tar.gz 
# cd php-memcached-2.2.0RC1
# /usr/local/php/bin/phpize
# ./configure --enable-memcached --with-php-config=/usr/local/php/bin/php-config --disable-memcached-sasl
# make && make install
# vi /usr/local/php/etc/php.ini 
// 增加
extension=memcached.so
# php -m | grep memcached
```

##### 代码测试

```
<?php
$mem = new \Memcached();
$mem->addServer('127.0.0.1', 11211, 33);
$mem->set('key', 'This is a test!', 0, 60);
$val = $mem->get('key');
echo $val;
?>

```
