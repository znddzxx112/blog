### redis命令

#### 启动与关闭命令

##### 启动守护进程

```
# vi 6379.conf
// 修改daemonize yes
# redis-server 6379.conf
```

##### 连接redis

```
# redis-cli -h 127.0.0.1 -p 6379
127.0.0.1:6379>
```

##### 关闭redis
```
127.0.0.1:6379>shutdown
```

##### 关闭连接
```
127.0.0.1:6379>quit
```
#### 服务器相关
* ping
* echo 
* select
```
select 7 选择数据库 0~15
```
* quit
```
退出数量
```
* dbsize
```
key数量
```
* info
```
获取服务器的信息和统计
```
* config get
```
//获取配置文件中配置信息
config get port
```
* flushdb
```
删除当前数据库中的所有key
```
* flushall
```
删除所有数据库中所有key
```



#### string结构

* set
* setnx
```
不存在key则设置
```
* setex
```
127.0.0.1:6379>setex color 10 res // 10秒后过期
```
* mset
* msetnx

* get
* getset
```
getset key value//设置并返回
```
* incr
* incrby
```
incrby age 5 // 加上5
```
* decr
* decrby
* strlen
* append

* keys
* exists
```
0 不存在 1存在
```
* del
* expire key 10
```
key 设置过期时间
```
* move key db1
```
将key移至其他db
```
* ttl
```
显示过期时间
```
* persist
```
移除过期时间
```
* randomkey
```
返回随机key
```
* rename key newkey
```
重命名key
```
* type key
```
返回值的类型
```
