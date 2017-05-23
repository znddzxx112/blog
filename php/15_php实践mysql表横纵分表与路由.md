- 参考文章：http://blog.csdn.net/nuli888/article/details/52143065
- 表长字段过多纵向切分，表数据过多水平分表
```
从横纵切分的数据表中获取数据过程
1. 先从mongo缓存中获取
2. 没有获取到，从 user_info表，user_profile表中各自获取数据，然后array_merray()一把 user_info表，user_profile表为二张纵向切分的表
2.1. 获取到数据，打入队列中，队列读取数据，入mongo缓存
2.2. 没有获取到数据，从认证中心，获取用户数据，事务的方式，往分表中添加数据-此时进行的是水平分表增加数据。
3. 水平分表添加数据是注意
根据userid，进行表路由
userid = 266233518
$index = ceil(abs($userid)/10000000)
每一张表的最小userid ($index - 1) *  10000000 +1
每一张表的最小userid $index *  10000000
```
