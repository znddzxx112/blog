
- 用户相关
```
1. create user 'user'@'host' identified by password 'pass'
2. drop user 'user'@'host'
3. show grant for 'user'@'host'
4. grant select on db.table to 'user'@'host'
5. set password for 'user'@'' = password('')
6. mysqladmin -u -h -p password ''
7. revoke select on db.table from 'user'@'host'
8. 先验证连接权限，再验证请求权限
连接权限通过mysql中的db
请求权限依次user，db
```

- 触发器相关
```
1. 在某个实体发生事件根据先后，执行动作,触发器要做的事情放到逻辑上层
2. show triggers;
```


- 视图相关
```
1. create view vname as
2. alter view vname as
3. 创建虚表，简化操作
```


- 存储过程相关
```
1. 默认;分号作为语句结束符，delimiter可以自定义语句结束符
2. create procedure p_name (IN param INT)
Bengin
    
End
3. drop procedure p_name;
4. 存储过程通过OUT返回，函数返回return
5. show create procedure p_name
```

- 索引相关
```
1. hash索引和btree索引
2.建表时
create table t_name
{
    
    [unique] index idx_f1(f1,f2)
}
已存在表
alter table t_name add index [unique]idx_f1(f1,f2)
3. 查看索引:show indexs from t_name
4. alter table t_name drop index idx_f1
5. explain ,key与type字段
```

- sql查询相关
```
1. select * from t_name group by f1 having count(*) > 8;
2. select * from t_name group by f1 having count(*) > 8 with group
3. select * from t_name where f1 any (select f2 from t2_name)
any:其中有一个等于子查询
all:所有
exist:子查询有数据存在
>:大于所有
4. union all 不会剔除重复行
```


- 函数相关
```
1. 求绝对值，求平方根，四舍五入，向上取整，向下取整
2. 字符串合并concat()
3. unix_timestamp(),from_unixtamp()
4. if(exp,v1,v2),case exp when then
5. 查看线程运行，show full processlist
```

- 表字段相关
```
1. 默认约束，非空约束，主键约束，自增约束
2. alter table name rename newname;
3. alter table name change col newcol varchar(50)
4. alter table name add col varchar(255) not null default '' after ziduan
5. alter table name drop colname
6. alter table name engine=innodb
```

- 数据类型相关
```
1. tinyint,smallint,int,bigint,char,varchar
2. 数据库显示的长度，与类型存储空间无影响。
3. 定点(M,D)M表示总位数,D表示小数位数，浮点数四舍五入，定点截断，定点字符串存储没有精度问题。
4. 2的16次-1 6万多个
5. enum只有1个，set有多个，并且剔除重复
```

