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
