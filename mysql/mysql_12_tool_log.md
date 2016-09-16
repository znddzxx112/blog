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
// 导出整个数据库
mysqldump -u root -p test_db > test_db.sql

// 导出一个表
mysqldump -u 用户名 -p 数据库名 表名> 导出的文件名
mysqldump -u wcnc -p smgp_apps_wcnc users> wcnc_users.sql

// 导出一个数据库结构
mysqldump -u wcnc -p -d --add-drop-table smgp_apps_wcnc >d:\wcnc_db.sql
#-d 不导出数据只导出结构 --add-drop-table 在每个create语句之前增加一个drop table 
```

> 数据库还原

```
// 进入mysql数据库控制台，
mysql -u root -p 
mysql>use 数据库
mysql>set names utf8; // （先确认编码，如果不设置可能会出现乱码，注意不是UTF-8） 

// 然后使用source命令，后面参数为脚本文件（如这里用到的.sql）
mysql>source d:\wcnc_db.sql
```

#### perror(错误代码查看工具)

- 参考文章:http://www.phpchina.com/thread-170217-1-1.html

```
// 错误日志里一般都会发现这样的错误编号。这时我们就可以利用这个命令分析到底是哪里出问题了。
perror 135
```

#### mysqlshow(数据库对象查看工具)

- 参考文章:http://man.linuxde.net/mysqlshow

```
mysqlshow -u root -p --count
```
