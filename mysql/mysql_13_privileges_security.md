##### mysql权限与安全

参考文章《深入浅出mysql》

- MySQL 是通过 IP 地址和用户名联合进行确认的

- MySQL 的权限表在数据库启动的时候就载入内存， 当用户通过身份认证后， 就在内存中进
行相应权限的存取， 这样， 此用户就可以在数据库中做权限范围内的各种操作了

- 其中， 通常用得最多的是用户列和权限列， 其中权限列有分为普通权限和管理权限。 普通权
限主要用于数据库的操作， 比如 select_priv、 create_priv 等； 而管理权限主要用来对数据库
进行管理的操作， 比如 process_priv、 super_priv 等。

- 当用户进行连接的时候， 权限表的存取过程有以下两个阶段。
- 先从 user 表中的 host、 user 和 password 这 3 个字段中判断连接的 IP、 用户名和密码是
否存在于表中， 如果存在， 则通过身份验证， 否则拒绝连接。
- 如 果 通 过 身 份 验 证 ， 则 按 照 以 下 权 限 表 的 顺 序 得 到 数 据 库 权 限 ：
userdbtables_privcolumns_priv。

##### 有哪些权限

- Select_priv
- Insert_priv
- Update_priv
- Delete_priv
- Index_priv
- Alter_priv
- Create_priv
- Drop_priv
- Grant_priv
- Create_view_priv
- Show_view_priv
- Create_routine_priv
- Alter_routine_priv
- References_priv
- Reload_priv
- Shutdown_priv
- Process_priv
- File_priv
- Show_db_priv
- Super_priv
- Create_tmp_table_priv
- Lock_tables_priv
- Execute_priv
- Repl_slave_priv
- Repl_client_priv

> 安全列

- ssl_type
- ssl_cipher

> 资源列

- max_questions
- max_updates
- max_connections
- max_user_connections

##### 创建账号

```
GRANT priv_type [(column_list)] [, priv_type [(column_list)]] ...
 ON [object_type] {tbl_name | * | *.* | db_name.*}
 TO user [IDENTIFIED BY [PASSWORD] 'password']
 [, user [IDENTIFIED BY [PASSWORD] 'password']] ...
[WITH GRANT OPTION]
```

```
grant all privileges on *.* to z1@localhost;
```

> 授予所有权限并给予密码

```
grant all privileges on *.* to z1@localhost identified by '123' 
```

##### ip限制

- IP 限制为所有 IP 都可以连接， 因此设置为“ *”， mysql 数据库中是通过 user 表的
host 字段来进行控制， host 可以是以下类型的赋值

- Host 值可以是主机名或 IP 号， 或“ localhost” 指出本地主机。
- 可以在 Host 列值使用通配符字符“ %” 和“_” 。
- 可以在 Host 列值使用通配符字符“ %” 和“_” 。
- Host 值“ %” 匹配任何主机名 ， 空 Host 值等价于“ %”。 它们的含义与 LIKE 操作符
的模式匹配操作相同。 例如，“ %” 的 Host 值与所有主机名匹配， 而“ %.mysql.com”
匹配 mysql.com 域的所有主机。

#####  查看权限

```
show grants for user@host;
```

```
 select * from SCHEMA_PRIVILEGES where grantee="'z1'@'localhost'";
 ```
 
#####  更改权限
```
revoke select,insert on *.* from z2@localhost;
```

##### 修改密码
```
SET PASSWORD FOR 'jeffrey'@'%' = PASSWORD('biscuit');
```

##### 删除用户
```
DROP USER user [, user] ...

需要重新启动mysql

```

#### 安全建议

- 删除空账号

```
 drop user ''@'localhost';
Q
```

- root设置密码

```
set password=password(' newpassword');
```

- 只授予账号必须的权限

```
Grant select,insert,update,delete on tablename to ‘ username’ @’ hostname’ ;
```

- 除 root 外， 任何用户不应有 mysql 库 user 表的存取权限

- 不要把 FILE、 PROCESS 或 SUPER 权限授予管理员以外的
账号

##### 操作

```
CREATE USER 'cklzjbook'@'127.0.0.1' IDENTIFIED BY 'hellozjbook'
GRANT SELECT,INSERT,UPDATE,DELETE ON zjbook.* TO 'cklzjbook'@'localhost' IDENTIFIED BY 'hellozjbook'
GRANT ALL PRIVILEGES ON zjbook.* TO 'cklzjbook'@'127.0.0.1'
SHOW GRANTS FOR 'cklzjbook'@'localhost'
REVOKE ALL PRIVILEGES ON zjbook.* FROM 'cklzjbook'@'127.0.0.1'
```

待续:mysql复制与clurse
