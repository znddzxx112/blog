##### redis备份和恢复

###### rdb
* 记录服务器状态（kv）
* 执行rdb有二种，1）手动命令执行 2)定期执行
* 1)手动命令 sava（阻塞） bgsave（非阻塞）
* 2）定期执行 配置文件 save 60 10 (60秒内达到10次修改)
* 执行先判断是否开启aof，开启aof，则不执行rdb

###### aof
* 线上常开启，效率比aof高
* aof记录执行命令
* aof重写命令 gbrewriteaof,减小aof文件
* 配置文件指定，执行频率 always，ererysec，no
* 三步骤aof命令缓冲区，aof文件写入，aof文件重写
