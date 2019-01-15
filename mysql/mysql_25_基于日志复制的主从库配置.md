- 参考文章：https://blog.csdn.net/mycwq/article/details/17136001
```
create user 'repl'@'192.168.0.%' identified by 'Caxxx@123';
grant REPLICATION SLAVE ON *.* TO 'repl'@'192.168.0.%';
show grants for 'repl'@'192.168.0.%';
```

- 备份到slave操作
```
mysqldump -uroot -h127.0.0.1 -p --single-transaction --master-data=2 --triggers --routines --all-databases > all.sql

scp all.sql root@192.168.0.118:/tmp

mysql -uroot -h127.0.0.1 -p < /tmp/all.sql 
```

- 查看同步文件和同步点
```
vim all.sql
CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.000007', MASTER_LOG_POS=779;
```

- slave操作change master命令
```
mysql> change master to master_host='192.168.0.119',
    -> master_user='repl',
    -> master_password='Caxxx@123',
    -> master_log_file='mysql-bin.000007',
    -> master_log_pos=779;

```

- 报错：ERROR 1794 (HY000): Slave is not configured or failed to initialize properly
```
从库 vim /etc/my.conf
增加一行:server-id=118
然后重新启动mysqld
```

- 查看从库状态
```
show slave status\G

Slave_IO_Running: No - io thread 没有开启
Slave_SQL_Running: No - sql thread没有工作

只有二个为YES时，主从才算健康
```

- 开启/关闭 io/sql thread
```
mysql > start slave;
mysql > stop slave;
```

- master防火墙允许
```
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT
```

- 主从相关的配置库表
```
> use performance_schema
| replication_applier_configuration                    |
| replication_applier_status                           |
| replication_applier_status_by_coordinator            |
| replication_applier_status_by_worker                 |
| replication_connection_configuration                 |
| replication_connection_status                        |
| replication_group_member_stats                       |
| replication_group_members 

mysql >select * from replication_applier_configuration;
DESIRED_DELAY 主动延迟秒数

```
