##### 日志

参考文章《深入浅出mysql》

- 错误日志、 二进制日志（ BINLOG 日志）、 查询日志和慢查询日志

- 慢日志 设置秒数 long_query_time

##### 工具

###### mysqladmin

###### mysqlbinlog（日志管理工具）

###### mysqlcheck(myisam表维护工具)

###### mysqldump(数据导出工具)

###### mysqlhotcopy(myisam表热备份工具)

###### mysqlimport(数据导入工具)

###### mysqlshow(数据库对象查看工具)

###### perror(错误代码查看工具)

##### mysqldump(数据导出工具)

- 参考文章[http://www.lihuai.net/linux/mysql/1031.html](http://www.lihuai.net/linux/mysql/1031.html)

> 数据库备份

```
mysqldump -u root -p test_db > test_db.sql
```

> 数据库还原

```
mysql -u username -p test_db < test_db.sql
```
