##### memcache源码安装

##### 资源与介绍

```
官网:http://memcached.org/
github: https://github.com/memcached/memcached
```

##### 前提-安装libevent

- libevent官网:http://libevent.org/

```
# tar -zxvf libevent-2.0.20-stable.tar.gz && \
cd libevent-2.0.20-stable && \
./configure --prefix=/usr/libevent

```

##### 下载与安装

```
# wget http://memcached.org/latest && \
tar -zxvf memcached-1.4.31.tar.gz && \
cd memcached-1.4.31 && \
./configure --prefix=/usr/local/memcache --with-libevent=/usr/libevent && \
make && make install
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
