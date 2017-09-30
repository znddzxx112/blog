- 参考文章：http://blog.csdn.net/zhuxineli/article/details/14455029


- select_type
```
2.1 simple 它表示简单的select,没有union和子查询

2.2 primary 最外面的select,在有子查询的语句中，
```

- table
```
输出的行所用的表，这个参数显而易见，容易理解
```

- type
```
性能逐渐提高
ALL 进行完整的表扫描,性能最差
index 在索引树全扫描
range 在索引树扫描，获取索引树的一部分
比如：uid有索引，下面语句使用range
explain select * from uchome_space where uid in (1,2)
ref 可以用于单表扫描或者连接,连接字段非索引
eq_ref 可以用于单表扫描或者连接，唯一索引或者主键索引
const where 后面的连接字段，主键或者唯一键
```

- possible_keys 
```
可能会使用的索引
```

- keys
```
使用的索引
```

- key_len
```
使用索引的长度
```

- ref
```
ef列显示使用哪个列或常数与key一起从表中选择行
```

- rows
```
MYSQL执行查询的行数，简单且重要，数值越大越不好
```

- Extra
```
using index 只使用索引树中的信息而不需要进一步搜索读取实际的行来检索表中的信息
using where 未建立索引
using temporary 需要创建一个临时表来容纳结果,典型情况如查询包含可以按不同情况列出列的GROUP BY和ORDER BY子句时。此时需要优化。
```

- 驱动表
```
当进行多表连接查询时， [驱动表] 的定义为：
1）指定了联接条件时，满足查询条件的记录行数少的表为[驱动表]；
2）未指定联接条件时，行数少的表为[驱动表]（Important!）。

目的：当二个表进行链接时候，一定要小结果集驱动大结果集。
比如：
left join 时候，一定要小表 left join 大表
分不清大表还是小表时候，让mysql优化器自动去判断，我们只需写select * from t1,t2 where t1.field = t2.field

```
