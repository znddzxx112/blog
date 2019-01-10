##### mysql修改root密码并增加用户并赋予权限
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
// 新版本 5.7之后推荐使用
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
