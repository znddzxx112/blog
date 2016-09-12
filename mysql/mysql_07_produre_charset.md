#### 存储过程和函数

参考文章《深入浅出mysql》

- 存储过程和函数是事先经过编译并存储在数据库中的一段 SQL 语句的集合，调用存储过程
和函数可以简化应用开发人员的很多工作，减少数据在数据库和应用服务器之间的传输，对
于提高数据处理的效率是有好处的。


- 在对存储过程或函数进行操作时，需要首先确认用户是否具有相应的权限

> 创建存储过程

```
CREATE PROCEDURE sp_name ([proc_parameter[,...]])
[characteristic ...] routine_body
```

> 创建函数

```
CREATE FUNCTION sp_name ([func_parameter[,...]])
RETURNS type
[characteristic ...] routine_body
```

```
DELIMITER $$
mysql>
mysql> CREATE PROCEDURE film_in_stock(IN p_film_id INT, IN p_store_id INT, OUT p_film_count
INT)
-> READS SQL DATA
-> BEGIN
-> SELECT inventory_id
-> FROM inventory
-> WHERE film_id = p_film_id
-> AND store_id = p_store_id
-> AND inventory_in_stock(inventory_id);
->
-> SELECT FOUND_ROWS() INTO p_film_count;
-> END $$
```

> 调用过程

```
CALL sp_name([parameter[,...]])
```

> 删除存储过程和函数

```
DROP {PROCEDURE | FUNCTION} [IF EXISTS] sp_name
```

```
DROP PROCEDURE film_in_stock;
```

> 查看存储过程和函数

```
SHOW CREATE {PROCEDURE | FUNCTION} sp_name
```

```
show create procedure film_in_stock \G
```

> 通过查看 information_schema. Routines 了解存储过程和函数的信息


```
select * from routines where ROUTINE_NAME = 'film_in_stock' \G
```

##### 变量定义
```
DECLARE var_name[,...] type [DEFAULT value]
```

```
DECLARE last_month_start DATE;
```

##### 变量赋值

```
SET var_name = expr [, var_name = expr] ...
```
- 通过查询

```
SELECT col_name[,...] INTO var_name[,...] table_expr
```
##### 定义条件

```
DECLARE handler_type HANDLER FOR condition_value[,...] sp_statement
```
