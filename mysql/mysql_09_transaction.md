#### mysql事务控制和锁定语句

> 表的读锁，写锁

```
LOCK TABLES
tbl_name [AS alias] {READ [LOCAL] | [LOW_PRIORITY] WRITE}
[, tbl_name [AS alias] {READ [LOCAL] | [LOW_PRIORITY] WRITE}] ...
```
```
lock table film_text read;
```
```
unlock tables;
```
- 读锁（共享锁）
- 写锁（独占锁）

> 事务实例

- MySQL 通过 SET AUTOCOMMIT、START TRANSACTION、COMMIT 和 ROLLBACK 等语句支
持本地事务

> 分布式事务

- mysql支持分布式，暂不研究
