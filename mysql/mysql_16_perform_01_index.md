#### mysql性能优化实践篇1-索引

##### 前期准备

- 产生大数据

```
INSERT INTO `b_log`(`remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent`) (SELECT `remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent` FROM `b_log` WHERE `id` <= 400000 AND `id` >= 300000)
```

- 开启慢日志设置

```
SHOW VARIABLES LIKE "long%";
SHOW VARIABLES LIKE "slow%";

5.6版本的设置方式：
#开启慢查询 slow_query_log值为1或on表示开启，为0或off为关闭
slow_query_log=on 
#设置慢查询日志放在哪里
slow_query_log_file=mysql-slow 
#设置sql执行时间多长为慢查询
long_query_time=2
#表示没有使用索引的sql查询也会记录下来
log-queries-not-using-indexes

eg:
// 开启慢查询
SET GLOBAL slow_query_log = ON

// 设置超时时间
my.conf 
[mysqlnd]
slow_query_log = on
long_query_time = 2
slow_query_log_file d:\wamp\bin\mysql\mysql5.6.17\data\all_slow.log

// 插入30万条数据
INSERT INTO `b_log`(`remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent`) (SELECT `remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent` FROM `b_log` WHERE `id` <= 300000)

// 耗时17s

// 日志记录在
slow_query_log_file d:\wamp\bin\mysql\mysql5.6.17\data\caokl-slow.log


```

- 查看警告错误日志

```
log_warning /xx/xx
log_error   d:\wamp\bin\mysql\mysql5.6.17\data\caokl.err
```

- 开启索引日志

```
SET GLOBAL log_queries_not_using_indexes = ON
```

- 查看是否执行情况

```
show processlist
```

- 统计select,insert,delete,update情况

```
SHOW STATUS LIKE 'com_%'

Com_select： 执行 select 操作的次数， 一次查询只累加 1
Com_insert： 执行 INSERT 操作的次数， 对于批量插入的 INSERT 操作， 只累加一次
Com_update： 执行 UPDATE 操作的次数
Com_delete： 执行 DELETE 操作的次数
Connections： 试图连接 MySQL 服务器的次数
Uptime： 服务器工作时间
Slow_queries： 慢查询的次数
```

- 查看索引使用情况

```
show status like 'Handler_read%';
```

##### 开始测试

###### 索引

- 索引前

```
# Time: 160914 17:36:50
# User@Host: root[root] @ localhost [::1]  Id:     1
# Query_time: 21.175121  Lock_time: 0.001001 Rows_sent: 2474  Rows_examined: 2746344
SET timestamp=1473845810;
SELECT * FROM `b_log` WHERE `dateline` = '1458700068' limit 0,1000000000000;
```

- 增加索引执行

```
ALTER TABLE `b_log` ADD INDEX ind_dateline (dateline)
```

```
# Time: 160914 17:41:11
# User@Host: root[root] @ localhost [::1]  Id:     1
# Query_time: 6.780814  Lock_time: 0.000000 Rows_sent: 1237  Rows_examined: 1237
SET timestamp=1473846071;
SELECT * FROM `b_log` WHERE `dateline` = '1458800432' limit 0,1000000000000;
```

- 删除索引执行

```
ALTER TABLE `b_log` DROP INDEX ind_dateline
```

```
# Time: 160914 17:05:55
# User@Host: root[root] @ localhost [::1]  Id:     1
# Query_time: 4.242019  Lock_time: 0.001000 Rows_sent: 1000  Rows_examined: 1107782
SET timestamp=1473843955;
select * from `b_log` where `dateline` = '1458700068'
 LIMIT 0, 1000;
```

- 结果

增加索引后，首次执行时间变长,但再次，多次执行相同语句明显加快，结论：能加快查询速度

不加索引，首次，再次，多次执行相同语句速度变化不明显。

> 是否合适建索引

- 较频繁地作为查询条件的字段
- 唯一性太差的字段不适合建立索引
- 更新太频繁地字段不适合创建索引
- 不会出现在where条件中的字段不该建立索引


#### 小结
查看统计信息，慢日志。
优化表，加索引，加中间表。
语句优化，or，order by ，group by，是否强制使用 use index
