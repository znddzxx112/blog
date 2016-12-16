#### redis配置文件

##### 基础配置

* daemonize

> yes 后台运行;

* pidfile

> pid文件位置，可以用cat查看。运行多个redis生成多个pid

* bind

> 只接受来自于该ip的请求

* port

> 默认6379

* timeout

> 客户端连接超时时间

* loglevel

> debug,verbose,notice,warning 生产环境 notice

* logfile
 
> log文件地址

* database

> 设置数据库个数

##### 备份

* save
> save 镜像备份频率

* rdbcompression
> 备份时，是否进行压缩

* dbfilename
> 镜像备份的文件名

* dir
> 数据库镜像备份的文件放置的路径
/var/redis/6379

##### 灾备

* maxmemory
> 达到最大内存，删除过时key。如以全部删除key，set请求将报错。只允许get

* appendonly
> 生产环境开启，set将被记录到*.aof文件中

##### 性能

* vm-enabled
> 支持虚拟内存，当内存不够用时，将value放到虚拟内存

* vm-max-memory
> 使用物理内存

* vm-page-size
> 虚拟内存的页大小，value比较大就设置大一点

* vm-pages
> 总page的数量，虚拟内存大小 vm-page-size * vm-pages,8page = 1 byte

* vm-max-threads
> value比较大，设置大一些，提升性能
