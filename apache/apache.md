[TOC]



##### yum安装Apache软件

###### 语句
```
# yum install httpd -y
```

###### 配置防火墙

```
# vi /etc/sysconfig/iptables
// 开启80端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
// 重启防火墙
# service iptables restart
```

###### apache服务启动与自启动

```
# service httpd start
# chkconfig --level 345 httpd on
```

###### 配置Apache服务
```
# vi /etc/httpd/conf/httpd.conf
```

###### 设置连接时间

```
Timeout 60
```

###### 配置字符集

```
AddDefaultCharset UTF-8
```

###### 配置索引页面

```
DirectoryIndex index.php index.htm index.html index.html.var
```

###### 配置网页主目录

```
// 网页存放的主目录
DocumentRoot "/var/www/html"
```

###### 配置连接端口

```
Listen 80 // 监听端口
```

###### 配置ServerName

```
ServerName www.example.com:80
```

###### 配置KeepAlive传输请求

```
KeepAlive on
```

###### 配置MaxKeepAliveRequests连接数

```
MaxKeepAliveRequests 100
```

##### Apache支持SSL

###### 安装mod_ssl模块

```
# rpm -qa | grep mod_ssl
```

###### 配置SSL

```
# vi /etc/httpd/conf.d/ssl.conf

LoadModule ssl_module modules/mod_ssl.so

Listen 443
```

###### 配置防火墙

```
-A INPUT -m state --state NEW -m tcp -p tcp --dport 443 -j ACCEPT 
```


###### 数字管理中心
```
http://www.bjca.org.cn/
```


##### 配置Apache虚拟目录

###### 创建网站目录

```
# mkdir /var/www/html/blog
# mkdir /var/www/html/media
# echo "hello blog" > /var/www/html/blog/index.html
```

###### 配置虚拟目录

```
# vi /etc/httpd/conf/httpd.conf
```

```
<VirtualHost *:80>
    ServerAdmin admin@xx.com
    DocumentRoot /var/www/html/blog  // 网页主目录
    ServerName blog.xx.com  // 网址名称
    Errorlog logs/err_log
    Custom logs/access_log common
</VirtualHost>
```

##### PHP程序

###### 检查php程序是否安装

```
# rpm -qa | grep php
```

###### yum安装php

```
# yum install php php-gd -y
```

###### 开启register_globals

```
# vi /etc/php.ini

register_global=on
```

###### apache支持php

```
# vi /usr/local/apache2/conf/httpd.conf

// 找到 AddType application/x-gzip .gz .tgz 在其下添加如下内容
AddType application/x-httpd-php .php 
AddType application/x-httpd-php-source .phps 
```

#### 总结:apache php 通过yum安装，apache配置虚拟目录，apache 配置支持php


##### 卸载apache，php

```
方法一: - 卸载不干净
# yum -y remove httpd php php-gd
# php -v // 验证卸载

方法二
# rpm -qa|grep php
# rpm -e php-mysql-5.1.6-27.el5_5.3 
# rpm -e php-pdo-5.1.6-27.el5_5.3 
# rpm -e php-xml-5.1.6-27.el5_5.3 
# rpm -e php-cli-5.1.6-27.el5_5.3 
# rpm -e php-gd-5.1.6-27.el5_5.3 
# rpm -e php-common-5.1.6-27.el5_5.3
...
# php -v //验证结果

// apache同样道理
```



### 源码编译apache

##### 知识前提

- configure,make,make install  参考文章: http://www.linuxidc.com/Linux/2011-02/32211.htm

##### 前提

```
yum -y install wget make gcc gcc-c++ pcre openssl openssl-devel zlib unzip cmake ncurses-devel libjpeg libjpeg-devel libpng libpng-devel libxml2 libxml2-devel curl-devel libtool libtool-ltdl libtool-ltdl-devel libevent libevent-devel zlib-static zlib-devel autoconf pcre-devel gd perl freetype freetype-devel lynx
```

##### apr下载

- https://apr.apache.org/download.cgi

```
# cd /usr/local/src && \
wget http://apache.mirrors.lucidnetworks.net//apr/apr-1.5.2.tar.gz && \
tar -zxvf apr-1.5.2.tar.gz && \
cd apr-1.5.2 &&  \
./buildconf &&  \
./configure --prefix=/usr/local/apr/ && \
make && \
make install
```

##### apr-util下载
```
# cd /usr/local/src && \
wget http://mirror.metrocast.net/apache//apr/apr-util-1.5.4.tar.gz && \
tar -zxvf apr-util-1.5.4.tar.gz && \
cd apr-util-1.5.4 && \
./configure --prefix=/usr/local/apr-util --with-apr=/usr/local/apr && \
make && \
make install && \
```

##### 安装Apache

- 地址:http://httpd.apache.org/download
- 静态编译动态编译参考文章：http://www.cnblogs.com/52php/p/5668845.html

```
# cd /usr/local/src && \
wget http://apache.mirrors.lucidnetworks.net//httpd/httpd-2.4.23.tar.gz && \
tar -zxvf httpd-2.4.23.tar.gz && \
cd httpd-2.4.23 && \
./configure --prefix=/usr/local/httpd/ \
--sysconfdir=/etc/httpd/ \
--with-include-apr \
--disable-userdir \
--enable-so \
--enable-defate=shared \
--enable-expires-shared \
--enable-rewrite=shared \
--enable-static-support \
--with-apr=/usr/local/apr/ \
--with-apr-util=/usr/local/apr-util/bin \
--with-ssl \
--with-z && \
make && make install
```

##### 配置Apache httpd.conf[yum配置一样]

```
# 打开配置文件
vi /etc/httpd/httpd.conf

# 修改
#ServerName www.example.com:80 改 ServerName locahost:80

// 修改用户和用户组
// 把user daemon group daemon 改成 user www group www (与文件目录匹配)

# groupadd www
# useradd -M -s /sbin/nologin -g www www

// 运行对象设置
# chown -R www:www /usr/local/httpd/htdocs/
# chmod -R 755 /usr/local/httpd/htdocs/
```

##### 增加apache环境变量

```
# vi /etc/profile
// 在文件里增加以下内容（$PATH后面是apache安装路径）
export PATH=$PATH:/usr/local/httpd/bin/
// 立即生效
source /etc/profile
```

##### 配置Apache启动与自启动

```
# cp /usr/local/httpd/bin/apachectl /etc/init.d/httpd
# vi /etc/init.d/httpd 
// 在开始处#!/bin/bash之后的行后插入
# chkconfig: 345 61 61
# description:Apache httpd

// 启动服务
# chmod +x /etc/init.d/httpd
# service httpd start

// 增加自启动
# chkconfig --add httpd
# chkconfig --level 345 httpd on

启动        /usr/local/httpd/bin/apachectl -f /usr/local/httpd/conf/httpd.conf
暴力停止     /usr/local/httpd/bin/apachectl -k stop
优雅停止     /usr/local/httpd/bin/apachectl -k graceful-stop
优雅的重启     /usr/local/httpd/bin/apachectl -k graceful
暴力重启     /usr/local/httpd/bin/apachectl -k restart
```

##### 配置防火墙开放80

```
# vi /etc/sysconfig/iptables
// 开启80端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
// 重启防火墙
# service iptables restart

```

###### 目录说明


目录路劲 | 目录说明
---|---
/usr/local/httpd | Apache2主目录
/usr/local/httpd/htdocs | Apache2网页存放默认目录
/usr/local/httpd/logs | Apache2日志记录文件目录
/usr/local/httpd/conf | Apache2配置目录

### 源码安装php5.6 参考本博客php部分

##### php.ini拷贝

```
// 注意phpinfo()
Configuration File (php.ini) Path  // php.ini路径
Loaded Configuration File  // 载入的配置文件
// 从源文件拷贝php.ini
# cp /usr/local/src/php-5.6.26/php.ini-production /usr/local/php/etc/php.ini
# service httpd restart //重启apache
```

##### php命令作为环境变量

```
# vi /etc/profile
// 添加语句，保存退出
export PATH=$PATH:/usr/local/php/bin
// 立即生效
source /etc/profile
```

##### 设置Apache支持php-修改apache配置文件
```
# 编辑Apache配置文件
vi /etc/httpd/httpd.conf
# 确保php5_module加载
LoadModule php5_module modules/libphp5.so
# 添加php支持
AddType application/x-httpd-php .php .phtml
AddType application/x-httpd-php-source .phps
# 添加默认索引页面index.php，再找到“DirectoryIndex”，在index.html后面加上“ index.php”
DirectoryIndex index.html index.php
# 不显示目录结构，找到“Options Indexes FollowSymLinks”，修改为
Options FollowSymLinks
# 开启Apache支持伪静态，找到“AllowOverride None”，修改为
AllowOverride All
// 保存httpd.conf配置，然后再执行以下两行命令
# chown -R www:www . /usr/local/httpd/htdocs/
# chmod -R 755 /usr/local/httpd/htdocs/

// 支持service后使用此命令
# service httpd restart

// 生成index.php文件用于测试
# echo "<?php echo phpinfo();?>" > /usr/local/httpd/htdocs/index.php
```

##### 测试

```
# cd /usr/local/httpd/htdocs/
# echo "<?php echo 'hello apache i am php';?>" > index.php

```

#### 卸载-让世界安静

```
// 卸载php编译前提
yum -y remove make gcc gcc-c++ pcre openssl openssl-devel zlib unzip cmake ncurses-devel libjpeg libjpeg-devel libpng libpng-devel libxml2 libxml2-devel curl-devel libtool libtool-ltdl libtool-ltdl-devel libevent libevent-devel zlib-static zlib-devel autoconf pcre-devel gd perl freetype freetype-devel

// 卸载httpd
# rm -rf /usr/local/httpd //卸载安装目录
# rm -f /etc/init.d/httpd //卸载命令
# rm -rf /etc/httpd //删除配置命令
# vi /etc/profile // 删除环境变量
# source /etc/profile
# whereis httpd // 测试

// 卸载php5.6
# rm -rf /usr/local/php //卸载安装目录
# vi /etc/profile // 删除环境变量
# source /etc/profile
# whereis php // 测试
```
