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

> 事务

- MySQL 通过 SET AUTOCOMMIT、START TRANSACTION、COMMIT 和 ROLLBACK 等语句支
持本地事务
```
START TRANSACTION;
SELECT @A:=SUM(salary) FROM table1 WHERE type=1;
UPDATE table2 SET summary=@A WHERE type=1;
COMMIT;
```
```
DELIMITER $$
CREATE PROCEDURE make_transaction()
BEGIN
	DECLARE is_commit INT DEFAULT 1;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET is_commit = 0;
	START TRANSACTION;
	INSERT INTO sm_mes(`time`,`sener`,`rever`,`content`) VALUES (UNIX_TIMESTAMP(),ROUND(RAND() * 1000,2),TRUNCATE(RAND() * 100,2),RPAD('信息1',20,'hellofoo'));
	SELECT * FROM sm_mes ORDER BY id DESC LIMIT 0,100;
	IF is_commit = 1 THEN
	COMMIT;
	ELSE
	ROLLBACK;
	END IF;
END$$
DELIMITER ;
```

> 分布式事务

- mysql支持分布式，暂不研究
