#### mysql性能优化实践篇2-存储过程产生大量数据

##### 开启慢查询
```
SHOW VARIABLES LIKE "slow%"
SET GLOBAL slow_query_log = ON

SHOW VARIABLES LIKE "long%"
SET SESSION long_query_time = 0.01 // 慢查询时间
```

##### 创建存储器

```
// 定义变量循环
DELIMITER $$
CREATE PROCEDURE make_data_proce (IN time_foo INT(10),IN sener DECIMAL(5,2), IN rever DECIMAL(5,2))
BEGIN
	DECLARE i INT DEFAULT 0;
	WHILE i < 100 DO
		INSERT INTO sm_mes(`time`,`sener`,`rever`,`content`) VALUES (time_foo,sener,rever,RPAD('信息1',20,'hellofoo'));
		SET i = i + 1;
	END WHILE;
END$$
```

```
// 复制一份当前表数据
DELIMITER $$
CREATE PROCEDURE make_data_proce (IN time_foo INT(10),IN sener DECIMAL(5,2), IN rever DECIMAL(5,2))
BEGIN
	INSERT INTO sm_mes(`time`,`sener`,`rever`,`content`) SELECT `time`,`sener`,`rever`,`content` FROM sm_mes
END$$
```

##### 查看存储过程

```
SHOW PROCEDURE STATUS
```

##### 执行存储过程

```
CALL make_data_proce(UNIX_TIMESTAMP(),ROUND(RAND() * 1000,2),TRUNCATE(RAND() * 100,2))
```

