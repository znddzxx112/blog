#### mysql存储引擎

参考书籍《深入浅出mysql》

- MySQL 5.0 支持的存储引擎包括 MyISAM、 InnoDB、 BDB、 MEMORY、 MERGE、 EXAMPLE、
NDB Cluster、ARCHIVE、CSV、BLACKHOLE、FEDERATED 等，

> 查看当前的默认存储引擎

```
 show variables like 'table_type';
```

> 当前数据库支持的存储引擎

```
SHOW ENGINES;
SHOW VARIABLES LIKE 'have%';
```

>设置新建表的存储引擎

```
CREATE TABLE ai (
i bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (i)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
```

> 修改表的存储引擎

```
alter table ai engine = innodb;
```

> 常用存储引擎的对比

 特点 | MyISAM | InnoDB
---|---|---
事务安全|      | 支持
锁机制  | 表锁 | 行锁
支持外键|      | 支持


 MyISAM InnoDB
事务安全    支持
锁机制 表锁 行锁

##### MyISAM
- MyISAM 是 MySQL 的默认存储引擎。MyISAM 不支持事务、也不支持外键，其优势是访
问的速度快，对事务完整性没有要求或者以 SELECT、INSERT 为主的应用基本上都可以使用
这个引擎来创建表。

##### Innodb
- InnoDB 存储引擎提供了具有提交、回滚和崩溃恢复能力的事务安全。但是对比 MyISAM
存储引擎，InnoDB 写的处理效率差一些并且会占用更多的磁盘空间以保留数据和索引。
- MySQL 支持外键的存储引擎只有 InnoDB，在创建外键的时候，要求父表必须有对应的
索引，子表在创建外键的时候也会自动创建对应的索引。

> 如何选择合适的存储引擎

- MyISAM：默认的 MySQL 插件式存储引擎。如果应用是以读操作和插入操作为主，
Linux公社 www.linuxidc.com
122
只有很少的更新和删除操作，并且对事务的完整性、并发性要求不是很高，那么选择这个存
储引擎是非常适合的。MyISAM 是在 Web、数据仓储和其他应用环境下最常使用的存储引擎
之一。

- InnoDB：用于事务处理应用程序，支持外键。如果应用对事务的完整性有比较高的
要求， 在并发条件下要求数据的一致性， 数据操作除了插入和查询以外， 还包括很多的更新、
删除操作，那么 InnoDB 存储引擎应该是比较合适的选择。InnoDB 存储引擎除了有效地降低
由于删除和更新导致的锁定，还可以确保事务的完整提交（Commit）和回滚（Rollback），
对于类似计费系统或者财务系统等对数据准确性要求比较高的系统，InnoDB 都是合适的选
择。

- MEMORY：将所有数据保存在 RAM 中，在需要快速定位记录和其他类似数据的环境
下，可提供极快的访问。MEMORY 的缺陷是对表的大小有限制，太大的表无法 CACHE 在内
存中，其次是要确保表的数据可以恢复，数据库异常终止后表中的数据是可以恢复的。
MEMORY 表通常用于更新不太频繁的小表，用以快速得到访问结果。

#### 字符集

- MySQL 的字符集和校对规则有 4 个级别的默认设置：服务器级、数据库级、表级和字
段级。

######  服务器级别

- 可以在 my.cnf 中设置：
[mysqld]
default-character-set=gbk
或者在启动选项中指定：
mysqld --default-character-set=gbk
或者在编译的时候指定：
./configure --with-charset=gbk

> 查看当前字符集与校对规则

```
show variables like 'character_set_server'

show variables like ' collation_database '
```
