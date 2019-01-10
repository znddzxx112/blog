#### yum安装mysql

- yum在线安装会发现mariadb 已经替换mysql，需要从官网下载
- http://dev.mysql.com/downloads/file/?id=465605

##### 下载并安装mysql源

```
# cd /usr/local/src/ && \
wget http://dev.mysql.com/get/mysql57-community-release-el6-9.noarch.rpm && \
rpm -ivh mysql57-community-release-el6-9.noarch.rpm && \ 
yum update && \
yum -y install mysql-community-server mysql-community-devel mysql-community-common mysql-community-client
// 安装mysql 以及mysql开发包，客户端
```

##### 修改root密码并配置增加用户并赋予权限
- 参考文章 http://bbs.bestsdk.com/detail/762.html
```
# vi /etc/my.cnf 
[mysqld]
// 增加下面二条语句
skip-grant-tables // 屏蔽权限
explicit_defaults_for_timestamp=true // 5.7后没有这句话启动报错
// 注意:data_dir 下面不能有内容
============================
# service mysqld start

# mysql -u root
// 旧版本
# update mysql.user set password=PASSWORD("rootadmin") where user='root';（老版本修改root的密码）
// 新版本 5.7之后
# update mysql.user set authentication_string=PASSWORD("rootadmin") where user='root';（新版本修改root的密码）
// 新版本 5.7之后
# SET GLOBAL  validate_password_policy='LOW';
# ALTER USER USER() IDENTIFIED BY 'rootadmin';

# exit;
# vi /etc/my.cnf 
[mysqld]
#skip-grant-tables // 删除屏蔽权限

==============
# service mysqld restart

# mysql -u root -p

// root 只能本机登录
// 另外创建允许外网连接的用户
# GRANT ALL PRIVILEGES ON *.* TO 'bitcao'@'%' IDENTIFIED BY 'mypassword' WITH GRANT OPTION; 

//删除多余用户
# use mysql
# select Host,User from user;
# drop user 'mysql.sys'@'localhost';

# flush privileges;
# exit; 
# service mysqld restart
```

##### 配置防火墙

```
# vi /etc/sysconfig/iptables
// 增加语句
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT // 开启3306端口
// 重启防火墙
# service iptables restart
```

##### mysql启动与自启动

```
# service mysqld start
# chkconfig --level 345 mysqld on
```

