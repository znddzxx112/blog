### centos服务器配置-测试-wordpress安装

#### apache创建虚拟目录

```
// 2.4 开始这样配
# vi /etc/httpd/httpd.conf
去掉# Include conf/extra/httpd-vhosts.conf
Require all granted 替换 Require all denied
根据上下文修改 <Directory "/usr/local/httpd/htdocs/wordpress">
根据上下文修改     DirectoryIndex index.php index.html

# vi /etc/httpd/extra/httpd-vhosts.conf
<VirtualHost wordpress.example.com:80>
    ServerAdmin admin@xx.com
    DocumentRoot /usr/local/httpd/htdocs/wordpress  // 网页主目录
    ServerName wordpress.example.com  // 网址名称
    ServerAlias wordpress.example.com
    Errorlog logs/wordpress-err_log
    Custom logs/wordpress-access_log common
</VirtualHost>

# service httpd restart
```

#### 安装wordpress

```
wordpress-4.6.1.zip

// 解压
# upzip wordpress-4.6.1.zip -d wordpress
# cd wordpress
# mkdir /usr/local/httpd/htdocs/wordpress
#  cp -r ./wordpress /usr/local/httpd/htdocs
# chown -R www:www /usr/local/httpd/htdocs/wordpress
# chmod -R 755 /usr/local/httpd/htdocs/wordpress

```

#### mysql 创建wordpress用户和数据库

```
# mysql -u root -p
# create database wordpress;
# SET GLOBAL  validate_password_policy='LOW';
# GRANT ALL PRIVILEGES ON wordpress.* TO 'www'@'localhost' IDENTIFIED BY 'mypassword' WITH GRANT OPTION; 

# admin www passwd 0V7Yc)oxsAotKkB)Jn
```
