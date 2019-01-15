#### sql优化

参考文章《深入浅出mysql》

###### 通过 show status 命令了解各种 SQL 的执行频率

- show [session|global]status 

```
show status like 'Com_%';
```

- 可以知道以插入更新为主还是以查询
操作为主，以及各种类型的 SQL 大致的执行比例是多少。

###### 定位执行效率较低的 SQL 语句

- 通过慢查询日志定位那些执行效率较低的 SQL 语句，用--log-slow-queries[=file_name]选
项启动时，mysqld 写一个包含所有执行时间超过 long_query_time 秒的 SQL 语句的日志
文件

- 使用 show processlist 命令查看当前 MySQL 在进行的线程，
包括线程的状态、是否锁表等，可以实时地查看 SQL 的执行情况，同时对一些锁表操
作进行优化

- 通过 EXPLAIN 分析低效 SQL 的执行计划

- 查看索引使用情况

```
show status like 'Handler_read%';
```

###### 二个使用的优化方法

- 定期分析表和检查表

```
ANALYZE [LOCAL | NO_WRITE_TO_BINLOG] TABLE tbl_name [, tbl_name] ...
```

```
check table sales_view3;
```
- 定期优化表
- 
```
OPTIMIZE [LOCAL | NO_WRITE_TO_BINLOG] TABLE tbl_name [, tbl_name] ...
```

- 导出大批量数据时，先关闭索引，关闭唯一性校验，关闭自动提交

###### insert语句优化

###### group by 语句优化

###### 优化嵌套子查询

###### OR条件优化

#### 表结构数据类型优化

- 使用函数 PROCEDURE ANALYSE()对当前应用的表进行分析

```
SELECT * FROM tbl_name PROCEDURE ANALYSE();
```



> 减少连接，来提高效率

- 适当的逆规范化
- 增加冗余列
- 增加派生列
- 重新组表
- 分割表
- 垂直和水平拆分

##### 中间表
- 要统计的数据到中间表,然后在中间表上进行统计， 得出想要的结果
- 中间表复制源表部分数据， 并且与源表相“ 隔离”， 在中间表上做统计查询不
会对在线应用产生负面影响。
- 中间表上可以灵活的添加索引或增加临时用的新字段, 从而达到提高统计查询
效率和辅助统计查询作用。
