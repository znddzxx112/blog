
# master

## create repl user && grant priviledge
```
create user 'repl'@'%' identified by 'Caxxx@123';
grant REPLICATION SLAVE ON *.* TO 'repl'@'%';
show grants for 'repl'@'%';
```
## change /etc/mysql/my.cnf
```
// log_bin
server_id =1
log_bin			= /var/log/mysql/mariadb-bin
log_bin_index		= /var/log/mysql/mariadb-bin.index

// relay_log
relay_log		= /var/log/mysql/relay-bin
relay_log_index	= /var/log/mysql/relay-bin.index
relay_log_info_file	= /var/log/mysql/relay-bin.info
log_slave_updates
```

## docker run mariadb
```
docker run --name mariadb3306 -v /data2/mariadb3306/lib/:/var/lib/mysql -v /data2/mariadb3306/etc/my.cnf:/etc/mysql/my.cnf -e MYSQL_ROOT_PASSWORD=mariadb3306 -p 3306:3306 -d mariadb
```

## backup data && 查看同步文件和同步点
```
mysqldump -uroot -h127.0.0.1 -p --single-transaction --master-data=2 --triggers --routines --all-databases > all.sql
scp all.sql root@192.168.0.118:/tmp
mysql -uroot -h127.0.0.1 -p < /tmp/all.sql 

show master status;
```


# slave
## change /etc/mysql/my.cnf
```
// log_bin
server_id =2
log_bin			= /var/log/mysql/mariadb-bin
log_bin_index	= /var/log/mysql/mariadb-bin.index
// relay_log
relay_log		= /var/log/mysql/relay-bin
relay_log_index	= /var/log/mysql/relay-bin.index
relay_log_info_file	= /var/log/mysql/relay-bin.info
log_slave_updates
```

# change master to server_id =1
```
mysql> change master to master_host='192.168.0.119',
    -> master_user='repl',
    -> master_password='Caxxx@123',
    -> master_log_file='mysql-bin.000007',
    -> master_log_pos=779;
或者
CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.000007', MASTER_LOG_POS=779;
```
## docker run mariadb
```
docker run --name mariadb3307 -v /data2/mariadb3307/lib/:/var/lib/mysql -v /data2/mariadb3307/etc/my.cnf:/etc/mysql/my.cnf -e MYSQL_ROOT_PASSWORD=mariadb3307 -p 3307:3306 -d mariadb
```

# test data
```
// id gen
CREATE TABLE `id_gen` (`id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,PRIMARY KEY (`id`)) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

// mysql build data
CREATE TABLE `post_1` ( `id` bigint(11) UNSIGNED NOT NULL, `userid` int(10) NOT NULL default 0 COMMENT 'userid',
	`title` VARCHAR(255) NOT NULL DEFAULT '', 
	`content` VARCHAR(255) NOT NULL COMMENT 'content',  
	`ctime` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间', PRIMARY KEY (`id`) ) ENGINE=INNODB DEFAULT CHARSET=utf8;


mysql -h127.0.0.1 -uroot -P3306 -pmariadb3306 -e 'insert into formysql.post_1(`userid`, `title`, `content`, `ctime`)values();'
```


# add slave node 3308, master is 3307
## mariadb 3307
```
create user 'repl'@'%' identified by 'mariadb3307';
grant REPLICATION SLAVE ON *.* TO 'repl'@'%';
show grants for 'repl'@'%';
use formysq;
flush tables with read lock;
show master status;
mysqldump -h127.0.0.1 -uroot -P3307 -pmariadb3307 --databases formysql > formysql.sql;
unlock tables;
```

## mariadb 3308
# set server_id and slave
```
docker run --name mariadb3308 -v /data2/mariadb3308/lib/:/var/lib/mysql -v /data2/mariadb3308/etc/my.cnf:/etc/mysql/my.cnf -e MYSQL_ROOT_PASSWORD=mariadb3308 -p 3308:3306 -d mariadb
mysql -h127.0.0.1 -uroot -P3308 -pmariadb3308 -e 'create database formysql';
mysql -h127.0.0.1 -uroot -P3308 -pmariadb3308 < formysql.sql
mysql> change master to master_host='192.168.0.119',
    -> master_user='repl',
    -> master_password='mariadb3307',
    -> master_log_file='mysql-bin.000007',
    -> master_log_pos=779;
start slave;
show slave status;
show processlist;
```
