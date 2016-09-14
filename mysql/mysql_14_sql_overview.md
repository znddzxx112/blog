#### sql番外篇

```
INSERT INTO `b_check`(`p_id`, `title`, `class_id`, `user_id`, `exec_user`, `check_cycle`, `check_cycle_num`, `check_last_time`, `content`, `notify_type`, `notify_user`, `add_time`)  SELECT `p_id`, `title`, `class_id`, `user_id`, `exec_user`, `check_cycle`, `check_cycle_num`, `check_last_time`, `content`, `notify_type`, `notify_user`, `add_time` FROM `b_check` WHERE `id` = '17'
```

- DDL 语句
> create 增
> drop 删除
> alert 改
> show 查

- DML 语句
> insert/replace
> delete
> update
> select

- DCL 语句
> grant on ... to ...
> revoke on ... from ...

##### show语句整理

> show databases; // 显示mysql中所有数据库的名称

> show tables或show tables from database_name; // 显示当前数据库中所有表的名称

> show columns from table_name from database_name; 

>  show grants for user_name; //? 显示一个用户的权限，显示结果类似于grant 命令

> show index from table_name; // 显示表的索引

> show status; // 显示一些系统特定资源的信息

> show variables; // 显示系统变量

> show processlist; // 显示系统中正在运行的所有进程

> show privileges; // 显示服务器所支持的不同权限

> show create database database_name; // 显示create database 语句是否能够创建指定的数据库 ,

> show create table table_name; // 显示createtables 语句创建指定的表

> show engines; // 显示安装以后可用的存储引擎和默认引擎

> show innodb status; // 显示innoDB


#### 小结

- 看自带的手册

```
help contents

? create
? alter
? drop
? show

? select
? insert
? update
? delete

? grant
? revoke

account management
? set set password for 'ckl'@'localhost' = password()
? rename user rename user old_user to new_user



? use
? explain




```
