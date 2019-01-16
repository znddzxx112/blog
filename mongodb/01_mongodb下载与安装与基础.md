##### 资源
```
官网:http://www.mongodb.com/
下载:https://www.mongodb.com/download-center#community
中文社区:http://www.mongoing.com/
https://www.mongodb.com/download-center#community
32位下载
https://www.mongodb.org/dl/linux/i686
64位下载
https://www.mongodb.org/dl/linux/x86_64-rhel62?_ga=1.189767787.1942959245.1488025205
```

##### 安装
```
# wegt http://downloadxxx
// 解压到程序存放目录
# tar /usr/local/mongodb/
// 建立存放数据文件存放目录
# mkdir  -p /data/db
// 运行程序
# mongod --dbpath = /data/db
// 日志文件
# /data/logs/mongodb.log
// 制作开机启动
# vim /etc/rc.local
# mongod --dbpath=/data/db --logpath=/data/logs/mongodb.log
```

##### 参数文件
```
dbpath:
数据文件存放路径，每个数据库会在其中创建一个子目录，用于防止同一个实例多次运
行的mongod.lock 也保存在此目录中。
logpath
错误日志文件
logappend
错误日志采用追加模式（默认是覆写模式）
bind_ip
对外服务的绑定ip，一般设置为空，及绑定在本机所有可用ip 上，如有需要可以单独
指定
port
对外服务端口。Web 管理端口在这个port 的基础上+1000
fork
以后台Daemon 形式运行服务
journal
开启日志功能，通过保存操作日志来降低单机故障的恢复时间，在1.8 版本后正式加入，
取代在1.7.5 版本中的dur 参数。
syncdelay
系统同步刷新磁盘的时间，单位为秒，默认是60 秒。
directoryperdb
每个db 存放在单独的目录中，建议设置该参数。与MySQL 的独立表空间类似
maxConns
最大连接数
repairpath
执行repair
```

##### 逻辑结构
```
数据库，集合，文档
```

##### 基本信息
```
// 端口 27017
// 数据存储 /data/db
// 指定配置文件运行
# ./mongod -f /etc/mongodb.cnf
// 后台运行
# ./mongod -f /etc/mongodb.cnf --logpath=/data/logs/mongod.logs --fork
```

##### 工具集
```
 bsondump: 将bson 格式的文件转储为json 格式的数据
 mongo: 客户端命令行工具，其实也是一个js 解释器，支持js 语法
 mongod: 数据库服务端，每个实例启动一个进程，可以fork 为后台运行
 mongodump/ mongorestore: 数据库备份和恢复工具
 mongoexport/ mongoimport: 数据导出和导入工具
 mongofiles: GridFS 管理工具，可实现二制文件的存取
 mongos: 分片路由，如果使用了sharding 功能，则应用程序连接的是mongos 而不是
mongod
 mongosniff: 这一工具的作用类似于tcpdump，不同的是他只监控MongoDB 相关的包请
求，并且是以指定的可读性的形式输出
 mongostat: 实时性能监控工具
```

##### GUI客户端
```
robomongo
https://robomongo.org/
```


##### mongodb强势
* mysql读每秒上万没问题，写每秒上万有问题
* 读写性能高mysql一个量级（读写，都借助内存）

##### mongodb弱势
* 事务
* 一致性，实时性（写完，就读不一定有）
* 连表查询

参照：
- http://blog.csdn.net/clh604/article/details/19608869
- http://www.cnblogs.com/crazylights/archive/2013/05/08/3066056.html
