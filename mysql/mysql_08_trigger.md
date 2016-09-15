##### 触发器

参考文章《深入浅出mysql》

###### 作用与目的
- 触发器是与表有关的数据库对象，在满足定义
条件时触发，并执行触发器中定义的语句集合。触发器的这种特性可以协助应用在数据库端
确保数据的完整性。

- mysql里面的钩子程序

> 创建触发器

```
CREATE TRIGGER trigger_name trigger_time trigger_event
ON tbl_name FOR EACH ROW trigger_stmt
```
**触发器只能创建在永久表（Permanent Table）上，不能对临时表（Temporary Table）创建
触发器。**

```
DELIMITER $$
CREATE TRIGGER ins_film
AFTER INSERT ON film FOR EACH ROW BEGIN
INSERT INTO film_text (film_id, title, description)
VALUES (new.film_id, new.title, new.description);
END;
$$
delimiter ;
```

> 删除触发器

```
DROP TRIGGER [schema_name.]trigger_name
```

```
drop trigger ins_film;
```

> 查看触发器

```
show triggers 
```

###### 测试 - bak插入数据

- 创建触发器

```
DELIMITER $$
CREATE TRIGGER insert_tri AFTER  INSERT ON sm_mes FOR EACH ROW 
BEGIN
	INSERT INTO sm_mes_bak(`time`,`sener`,`rever`,`content`) VALUES(new.time, new.sener, new.rever, new.content);
END$$
DELIMITER ;
```

- 查看创建的触发器

```
SHOW TRIGGERS 
```

- 插入数据，查看结果

```
INSERT INTO sm_mes(`time`,`sener`,`rever`,`content`) VALUES (UNIX_TIMESTAMP(),ROUND(RAND() * 1000,2),TRUNCATE(RAND() * 100,2),RPAD('信息1',20,'hellofoo'));
```

