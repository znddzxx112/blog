#### mysql索引

参考书籍《深入浅出mysql》

- 索引是数据库中用来提高性能的最常用工具。本章主要介绍了 MySQL 5.0 支持的索引类型，
并简单介绍了索引的设计原则

- 根据存储引擎可以定义每个表的最大索引数和最大索引长度， 每种存储引擎 （如 MyISAM、
InnoDB、BDB、MEMORY 等）对每个表至少支持 16 个索引，总索引长度至少为 256 字节。

- MyISAM 和 InnoDB 存储引擎的表默认创建的都是 BTREE 索引
- PRIMARY KEY、UNIQUE、INDEX 和 FULLTEXT

> 创建索引

```
CREATE [UNIQUE|FULLTEXT|SPATIAL] INDEX index_name
[USING index_type]
ON tbl_name (index_col_name,...)
index_col_name:
col_name [(length)] [ASC | DESC]

create index cityname on city (city(10));
```

> 索引的删除

```
DROP INDEX index_name ON tbl_name
```

- 搜索的索引列， 不一定是所要选择的列.最适合索引的列是出现在 WHERE
子句中的列，或连接子句中指定的列，

- InnoDB 存储引擎的表， 记录默认会按照一定的顺序保存， 如果有明确定义的主
键，则按照主键顺序保存。如果没有主键，但是有唯一索引，那么就是按照唯一索引的顺序
保存。如果既没有主键又没有唯一索引，那么表中会自动生成一个内部列，按照这个列的顺
序保存。按照主键或者内部列进行的访问是最快的，所以 InnoDB 表尽量自己指定主键，当
表中同时有几个列都是唯一的，都可以作为主键的时候，要选择最常作为访问条件的列作为
主键，提高查询的效率。另外，还需要注意，InnoDB 表的普通索引都会保存主键的键值，
所以主键要尽可能选择较短的数据类型，可以有效地减少索引的磁盘占用，提高索引的缓存
效果。
