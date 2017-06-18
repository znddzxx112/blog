- 将日志复制方式改成事务复制方式
- 事务方式，数据更加完成
- 先决条件
```
集群中所有服务器的版本均高于5.7.6
集群中所有服务器的gtid_mode都设为off
```

> 查看先决条件
```
show variables like '%version%';
show variables like 'gtid_mode';
```

> 处理步骤 9步
```
set @@global.enforce_gtid_consistency=warn;
set @@global.enforce_gtid_consistency=on;
set @@global.gtid_mode=off_permissive;
set @@global.gtid_model=on_permissive;
show status like 'ongoing_anonymous_transaction_count'；
set @@global.gtid_mode=on;
stop slave;
change master to master_auto_position = 1;// 切换复制方式
start slave;
```
