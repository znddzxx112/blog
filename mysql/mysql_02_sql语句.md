#### sql知识

参考书籍 《深入浅出mysql》

##### 分类

* DDL（Data Definition Languages）语句：数据定义语言，这些语句定义了不同的数据段、
数据库、表、列、索引等数据库对象的定义。常用的语句关键字主要包括 create、drop、alter
等。

* DML（Data Manipulation Language）语句：数据操纵语句，用于添加、删除、更新和查
询数据库记录，并检查数据完整性，常用的语句关键字主要包括 insert、delete、udpate 和
select 等

* DCL（Data Control Language）语句：数据控制语句，用于控制不同数据段直接的许可和
访问级别的语句。这些语句定义了数据库、表、字段、用户的访问权限和安全级别。主要的
语句关键字包括 grant、revoke 等


##### DDL

> 创建库，创建表，修改表结构等等语句。

> 要点:对库，表，表字段的增删改查功能


###### 链接数据库

```
    mysql -u root -p
```

###### 创建数据库
```
    create database test1;
```
###### 使用某个数据库
```
    use test1;
```
###### 删除数据库
```
    drop database test1;
```

######  查看数据库,表
```
    show databases;
    show tables;
```
###### 创建表
```
    CREATE TABLE tablename (column_name_1 column_type_1 constraints，
column_name_2 column_type_2 constraints ， ……column_name_n column_type_n
constraints）

create table tablename(
    字段名称1 字段类型1(int(10)) 约束条件1，
    字段名称1 字段类型1(int(10)) 约束条件1，
)
```

###### 查看表定义
```
desc tablename;
或者
show create table tablename;

```

###### 删除表
```
drop table tablename;
```

###### 表改名
```
ALTER TABLE tablename RENAME [TO] new_tablename

alter table emp rename emp1;
```

###### 修改表字段类型
```
ALTER TABLE tablename MODIFY [COLUMN] column_definition [FIRST | AFTER col_name]

alter table 表名称 modify 列名称 [类型]

alter table emp modify ename varchar(20);
```
###### 修改表字段名称
```
ALTER TABLE tablename CHANGE [COLUMN] old_col_name column_definition
[FIRST|AFTER col_name]

alter table emp change age age1 int(4) ;
```
###### 增加表字段
```
ALTER TABLE tablename ADD [COLUMN] column_definition [FIRST | AFTER col_name]

alter table emp add column age int(3);
```
###### 删除表字段
```
ALTER TABLE tablename DROP [COLUMN] col_name

alter table emp drop column age;
```
###### 表字段排序
```
alter table emp add birth date after ename;
```

######  注意点

-  4 个数据库，它们都是安装
MySQL 时系统自动创建的，其各自功能如下。
- information_schema：主要存储了系统中的一些数据库对象信息。比如用户表信息、列信
息、权限信息、字符集信息、分区信息等。
- cluster：存储了系统的集群信息。
- mysql：存储了系统的用户权限信息。
- test：系统自动创建的测试数据库，任何用户都可以使用。

-  每个 SQL 语句以分号或者\g 结束，按回
车键执行




##### DML
> 修改表内部数据，不涉及表结构，创建，库创建。

> 表记录的修改。开发人员熟练掌握

###### 增加记录
```
INSERT INTO tablename (field1,field2,……fieldn) VALUES(value1,value2,……valuesn);
空字段，非空但是有默认值，自增字段可以不包含。

insert into dept values(5,'dept5'),(6,'dept6');
```

###### 更新表记录
```
UPDATE tablename SET field1=value1，field2.=value2，……fieldn=valuen [WHERE CONDITION]
```
###### 删除表记录
```
DELETE FROM tablename [WHERE CONDITION]
```
###### 查询表记录
```
SELECT * FROM tablename [WHERE CONDITION]
```

> 查询不重复记录
```
select distinct deptno from emp;
```

###### 注意

- ‘=’
比较，除了‘=’外，还可以使用>、<、>=、<=、!=等比较运算符

> 排序和限制
```
SELECT * FROM tablename [WHERE CONDITION] [ORDER BY field1 [DESC|ASC] ， field2
[DESC|ASC]，……fieldn [DESC|ASC]] [LIMIT offset_start,row_count]
```

> 聚合
- 很多情况下，我们需要进行一些汇总操作，比如统计整个公司的人数或者统计每个部门的人数
```
SELECT [field1,field2,……fieldn] fun_name
FROM tablename
[WHERE where_contition]
[GROUP BY field1,field2,……fieldn
[WITH ROLLUP]]
[HAVING where_contition]
```
- fun_name 表示要做的聚合操作，也就是聚合函数，常用的有 sum（求和）、count(*)（记
录数）、max（最大值）、min（最小值）。
- GROUP BY 关键字表示要进行分类聚合的字段，比如要按照部门分类统计员工数量，部门
就应该写在 group by 后面。
- having 和 where 的区别在于 having 是对聚合后的结果进行条件的过滤，而 where 是在
合前就对记录进行过滤，如果逻辑允许，我们尽可能用 where 先过滤记录，这样因为结
集减小，将对聚合的效率大大提高，最后再根据逻辑看是否用 having 进行再过滤。
```
select deptno,count(1) from emp group by deptno having count(1)>1;
```

> 表连接

- left join左连接：包含所有的左边表中的记录甚至是右边表中没有和它匹配的记录
- right join右连接：包含所有的右边表中的记录甚至是左边表中没有和它匹配的记录
- inner join全连接：二张表的记录必须同时存在，才会显示记录

- 左连接，右连接可以相互转化

> 子查询
- 某些情况下，当我们查询的时候，需要的条件是另外一个 select 语句的结果，这个时候，就
要用到子查询。
- 用于子查询的关键字主要包括 in、not in、=、!=、exists、not exists 等。

```
select * from emp where deptno in(select deptno from dept);
```
- MySQL 4.1 以前的版本不支持子查询，需要用表连接来实现子查询的功能
- 表连接在很多情况下用于优化子查询

> 记录联合
- 将两个表的数据按照一定的查询条件查询出来后，将结果合并
到一起显示出来，这个时候，就需要用 union 和 union all 关键字来实现这样的功能
```
SELECT * FROM t1
UNION|UNION ALL
SELECT * FROM t2
……
UNION|UNION ALL
SELECT * FROM tn;
```

##### DCL

> DCL 语句主要是 DBA 用来管理系统中的对象权限时所使用

> 用于授权和访问控制

###### 创建一个数据库用户 z1，具有对 sakila 数据库中所有表的 SELECT/INSERT 权限：

```
grant select,insert on sakila.* to 'z1'@'localhost' identified by '123';
``` 

###### 由于权限变更，需要将 z1 的权限变更，收回 INSERT，只能对数据进行 SELECT 操作：

```
revoke insert on sakila.* from 'z1'@'localhost';
```
