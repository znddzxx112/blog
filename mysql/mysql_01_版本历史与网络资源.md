### mysql版本历史

参考书籍 《深入浅出mysql》

* 2000年4月，MySQL对旧的存储引擎ISAM进行了整理，将其命名为MyISAM。

* 2001年，存储引擎InnoDB，这个引擎同样支持事务处理，还支持行级锁

* 2003年12月，mysql5.0 提供了视图、存储过程等功能

* 2008年，被sun公司收购

* 2008年12月，mysql5.1

* 2009年4月，Oracle公司以74亿美元收购Sun公司，自此MySQL数据库进入Oracle时代，而其第三方的存储引擎InnoDB早在2005年就被Oracle公司收购。

* 2010年12月，MySQL 5.5发布，其主要新特性包括半同步的复制及对SIGNAL/RESIGNAL的异常处理功能的支持，最重要的是InnoDB存储引擎终于变为当前MySQL的默认存储引擎。

* MariaDB是由MySQL创始人之一Monty分支的一个版本。在MySQL数据库被Oracle公司收购后，Monty担心MySQL数据库发展的未来，从而分支出一个版本。这个版本和其他分支有很大的不同，其默认使用崭新的Maria存储引擎，是原MyISAM存储引擎的升级版本。此外，其增加了对Hash Join的支持和对Semi Join的优化，使MariaDB在复杂的分析型SQL语句中较原版本的MySQL性能提高很多。另外，除了包含原有的一些存储引擎，如InnoDB、Memory，还整合了PBXT、FederatedX存储引擎。不得不承认，MariaDB数据库是目前MySQL分支版本中非常值得使用的一个版本，尤其是在OLAP的应用中，对Hash Join的支持和对Semi Join的优化可以大大提高MySQL数据库在这方面的查询性能。MariaDB的官方网站为http://mariadb.org/

### mysql版本
参考文章 http://www.jb51.net/article/39148.htm

- mysql 5.0  procedures、Views、Cursors、Triggers、XA transactions的支持
- mysql 5.1  增加了Event scheduler，Partitioning，Pluggable storage engine API ，Row-based replication、Global级别动态修改general query log和slow query log的支持
- mysql 5.2
- mysql 5.3
- mysql 5.4
- mysql 5.5
- mysql 5.6
- mysql 5.7
- mysql 7.0

### 网络资源

- http://dev.mysql.com/downloads/ 是MySQL 的官方网站，可以下载到各个版本的 MySQL 以及
相关客户端开发工具等。

- http://dev.mysql.com/doc/ 提供了目前最权威的 MySQL 数据库及工具的在线手册。
- http://www.mysql.com/news-and-events/newsletter/ 通常会发布各种关于 MySQL 的最新消息。
