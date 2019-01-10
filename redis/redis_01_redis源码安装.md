#### centos6.8服务器配置-redis[src]

##### 资源与介绍

```
官网：http://redis.io/
手册: http://redis.io/documentation

几十个命令，常用十几个
偶数版本(2.4,2.6)为稳定版本
奇数版本(2.5,2.7)为非稳定版本

windows有一个特别的分支支持redis，但更新缓慢仅仅直到2.4，linux已经3.2


``` 

文件名 | 说明
--- |---
redis-server |  redis服务器
redis-cli | redis命令行客户端
redis-benchmark |   redis性能测试工具
redis-check-aof |   aof文件修复
redis-check-dump | rdb文件检查工具

##### 前提

```
# yum -y install tcl
# yum -y install gcc-c++

```

##### 编译安装

```
# cd /usr/local/src/ && \
tar zxvf redis-3.2.3.tar.gz && \
cd redis-3.2.3 && \
make && \
mkdir /usr/local/redis && \
cp ./src/redis-server /usr/local/redis/ && \
cp ./src/redis-cli /usr/local/redis/ && \
cp ./redis.conf /usr/local/redis/6379.conf && \

```

##### 修改配置文件

```
# mkdir /var/redis
# mkdir /var/redis/run
# mkdir /var/redis/log
# mkdir /var/redis/6379
# cd /usr/local/redis/
# vi 6379.conf

daemonize yes

pidfile /var/redis/run/redis_6379.pid

logfile /var/redis/log/redis_6379.log

dir /var/redis/6379
```

##### 运行与停止redis

```
// 启动
# /usr/local/redis/redis-server /usr/local/redis/6379.conf 

// 停止
# /usr/local/redis/redis-cli SHUTDOWN

```

##### 测试redis

```
# /usr/local/redis/redis-cli 
127.0.0.1:6379> set foo bar
127.0.0.1:6379> get foo

```

##### 启动脚本

```
// 源码/utils自带启动脚本
# cp /usr/local/src/redis-3.2.3/utils/redis_init_script /etc/init.d/redisd
# vi /etc/init.d/redisd
#!/bin/sh
# chkconfig:   2345 90 10
# description:  Redis is a persistent key-value database

EXEC=/usr/local/redis/redis-server
CLIEXEC=/usr/local/redis/redis-cli

PIDFILE=/var/redis/run/redis_${REDISPORT}.pid
CONF="/usr/local/redis/${REDISPORT}.conf"

// 开机启动
# chkconfig --add redisd 
# chkconfig --level 345 redisd on 
//启动redis
# service redisd start
//关闭redis
# service redisd stop
```


