参考文章《深入浅出mysql》

- 视图（View）是一种虚拟存在的表，对于使用视图的用户来说基本上是透明的。视图并
不在数据库中实际存在，行和列数据来自定义视图的查询中使用的表，并且是在使用视图时
动态生成的。

- 简单： 使用视图的用户完全不需要关心后面对应的表的结构、 关联条件和筛选条件，
对用户来说已经是过滤好的复合条件的结果集。

- 安全
- 数据独立

> 查看视图
```
 show table status from db;
```

> 创建或者修改视图

```
CREATE [OR REPLACE] [ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}]
VIEW view_name [(column_list)]
AS select_statement
[WITH [CASCADED | LOCAL] CHECK OPTION]
```

```
CREATE OR REPLACE VIEW staff_list_view AS
-> SELECT s.staff_id,s.first_name,s.last_name,a.address
-> FROM staff AS s,address AS a
-> where s.address_id = a.address_id ;
```

```
ALTER [ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}]
VIEW view_name [(column_list)]
AS select_statement
[WITH [CASCADED | LOCAL] CHECK OPTION]
```

> 删除视图

```
drop view staff_list;
```
