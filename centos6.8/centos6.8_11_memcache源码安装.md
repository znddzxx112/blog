##### centos6.8服务器配置-memcache[src]

##### 资源与介绍

```
官网:http://memcached.org/
github: https://github.com/memcached/memcached
```

##### 前提-安装libevent

- libevent官网:http://libevent.org/

```
# tar -zxvf libevent-2.0.20-stable.tar.gz 
# cd libevent-2.0.20-stable
# ./configure --prefix=/usr/libevent

```

##### 下载与安装

```
# wget http://memcached.org/latest
# tar -zxvf memcached-1.4.31.tar.gz
# cd memcached-1.4.31
# ./configure --prefix=/usr/local/memcache --with-libevent=/usr/libevent
# make && make install
```

##### 启动脚本与启动与自启动
```
# cp /usr/local/src/memcached-1.4.31/scripts/memcached.sysv /etc/init.d/memcached
# vi /etc/init.d/memcached
//修改memcached位置
chown $USER /usr/local/memcache/bin/memcached  
    daemon /usr/local/memcache/bin/memcached -d -p $PORT -u $USER  -m $CACHESIZE -c $MAXCONN -P /var/run/memcached/memcached.pid $OPTIONS  

# chkconfig --add memcached
# chkconfig --level 345 memcached on
# service memcached start
```

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
