- 将日志复制方式改成事务复制方式
- 事务方式，数据更加完成
- 先决条件
```
集群中所有服务器的版本均高于5.7.6
集群中所有服务器的gtid_mode都设为on
```

> 操作步骤
```

stop slave
change master to master_auto_position=0,master_log_file='file',master_log_pos=position
start slave;

set @@global.gtid_mode=on_permissive;
set @@global.gtid_mode=off_permissive;

select @@global.gtid_owned;
set @@global.gtid_mode=off;
```
