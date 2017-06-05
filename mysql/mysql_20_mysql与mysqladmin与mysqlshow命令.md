- mysqladmin
```
// 判断mysqld是否执行
#  mysqladmin -uwww -pwww ping
// 关闭mysqld
# mysqladmin -uwww -pwww shutdown
// 还可以创建库，删除库
// 数据库当前状态
 mysqladmin -uwww -pwww status
// mysql版本等信息
mysqladmin -uwww -pwww version
// mysql连接信息
mysqladmin -uwww -pwww processlist
```

- mysql直接执行命令并退出
```
# mysql -uwww -pwww -D phpdb -e "select * from article;"
```

- mysqlshow显示数据库，表，字段信息
```
# mysqlshow -uwww -pwww mysql user host
```

- mysqlimport 导入文本数据到表中
```
mysqlimport -uwww -p --local phpdb /tmp/article

```
