
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
# cd /usr/local/src
# wget http://apache.mirrors.lucidnetworks.net//apr/apr-1.5.2.tar.gz
# tar -zxvf apr-1.5.2.tar.gz
# cd apr-1.5.2
# ./buildconf
# ./configure --prefix=/usr/local/apr/
# make
# make install
# whereis apr // 判断apr是否已安装
```

##### apr-util下载
```
# cd /usr/local/src
# wget http://mirror.metrocast.net/apache//apr/apr-util-1.5.4.tar.gz
# tar -zxvf apr-util-1.5.4.tar.gz
# cd apr-util-1.5.4
# ./configure --prefix=/usr/local/apr-util --with-apr=/usr/local/apr
# make
# make install
# whereis apr-util // 判断apr-util是否已安装
```

##### 安装Apache

- 地址:http://httpd.apache.org/download
- 静态编译动态编译参考文章：http://www.cnblogs.com/52php/p/5668845.html

```
# cd /usr/local/src
# wget http://apache.mirrors.lucidnetworks.net//httpd/httpd-2.4.23.tar.gz
# tar -zxvf httpd-2.4.23.tar.gz

# cd httpd-2.4.23 // 进入解压缩目录

// 检查安装平台
# ./configure --prefix=/usr/local/httpd/ \
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
--with-z \

./configure --prefix=/usr/local/httpd/ --sysconfdir=/etc/httpd/ --with-include-apr --disable-userdir --enable-so --enable-defate=shared --enable-expires-shared --enable-rewrite=shared --enable-static-support --with-apr=/usr/local/apr/ --with-apr-util=/usr/local/apr-util/ --with-ssl --with-z

# make && make install //编译 && 安装软件

// 前提需要gcc等软件

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

### 源码安装php

##### 编译安装PHP依赖包

```
# 注意：freetype在生成验证码图片需要用，所以必须要安装的
# yum -y install openssl openssl-devel  libxml2 libxml2-devel curl curl-devel zlib libevent
# yum -y install libpng libpng-devel libjpeg libjpeg-devel freetype freetype-devel gd gd-devel php-mcrypt autoconf

// 源码包安装libiconv
# cd /usr/local/src
# wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.14.tar.gz 
# tar zxvf libiconv-1.14.tar.gz
# cd libiconv-1.14/
# ./configure --prefix=/usr/local/libiconv
# make && make install

// 源码包安装libmcrypt
// libmcrypt version 2.5.6 or greater required.
// 2.5.8下载地址:https://sourceforge.net/projects/mcrypt/files/Libmcrypt/2.5.8/
# cd /usr/local/src
# tar zxvf libmcrypt-2.5.8.tar.gz
# cd libmcrypt-2.5.8/
# ./configure --prefix=/usr/local/libmcrypt/
# make
# make install

```

##### 编译安装PHP5.6

- http://php.net/downloads.php

```
# cd /usr/local/src/
# wget http://cn2.php.net/get/php-5.6.26.tar.gz/from/this/mirror
# mv mirror php-5.6.26.tar.gz
# tar -zxvf php-5.6.26.tar.gz
# cd php-5.6.26

// 成功编译-复杂版
# ./configure 
--prefix=/usr/local/php/ 
--with-apxs2=/usr/local/httpd/bin/apxs 
--with-config-file-path=/usr/local/php/etc/
--with-iconv-dir=/usr/local/libiconv
--enable-fpm 
--enable-mysqlnd 
--enable-mbstring 
--enable-bcmath
--enable-calendar
--enable-exif
--enable-ftp
--enable-gd-native-ttf
--enable-soap
--enable-sysvmsg
--enable-sysvsem
--enable-sysvshm
--enable-zip
--enable-sockets
--with-pdo-mysql=mysqlnd 
--with-mysqli=mysqlnd 
--with-mysql-sock=/var/lib/mysql/mysql.sock
--with-curl 
--with-freetype-dir
--with-gd 
--with-gettext
--with-openssl
--with-mhash 
--with-pear
--with-zlib
--with-xmlrpc

// 没有libmcry版本不高，尚未安装mysql，选用此命令
#./configure --prefix=/usr/local/php/ --with-config-file-path=/usr/local/php/etc/ --with-apxs2=/usr/local/httpd/bin/apxs --enable-fpm --with-zlib --with-libxml-dir --enable-sockets --with-curl --with-jpeg-dir --with-png-dir --with-gd --with-iconv-dir=/usr/local/libiconv --with-freetype-dir= --enable-gd-native-ttf --with-xmlrpc --with-openssl --with-mhash --with-pear --enable-mbstring --enable-sysvshm --enable-zip --disable-fileinfo

// 成功编译-简化版
# ./configure --prefix=/usr/local/php/ --with-apxs2=/usr/local/httpd/bin/apxs --enable-mbstring --with-curl --with-gd --enable-fpm --enable-mysqlnd --with-pdo-mysql=mysqlnd --with-config-file-path=/usr/local/php/etc/ --with-mysqli=mysqlnd --with-mysql-sock=/var/lib/mysql/mysql.sock

// 成功编译-复杂版-一句话
# ./configure --prefix=/usr/local/php/ --with-apxs2=/usr/local/httpd/bin/apxs --with-config-file-path=/usr/local/php/etc/ --with-iconv-dir=/usr/local/libiconv --enable-fpm --enable-mysqlnd --enable-mbstring --enable-bcmath --enable-calendar --enable-exif \
--enable-ftp --enable-gd-native-ttf --enable-soap --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-zip --enable-sockets \
--with-pdo-mysql=mysqlnd --with-mysqli=mysqlnd --with-mysql-sock=/var/lib/mysql/mysql.sock --with-curl --with-freetype-dir --with-gd --with-gettext --with-openssl --with-mhash --with-pear --with-zlib --with-xmlrpc 

# make && make install

// 注意:再次编译前，需执行
# make clean
```

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

##### 动态编译扩展

```
# vi /usr/local/php/etc/php.ini
// 修改 extension_dir
extension_dir = "/usr/local/php/lib/php/extensions/no-debug-zts-20131226/"

//  动态编译bcmath
# cd /usr/local/src/php-5.6.26/ext/bcmath/
# locate phpsize // phpsize位置
// 执行phpise生成makefile
# /usr/local/php/bin/phpize 
// 配置
#  ./configure --with-php-config=/usr/local/php/bin/php-config
// 编译安装
# make && make install
# vi /usr/local/php/etc/php.ini
// 添加so文件
extension=bcmath.so

# service httpd restart

// openssl->mysqlnd->mysql->mysqli动态编译
// 动态编译openssl
# cd /usr/local/src/php-5.6.26/ext/openssl
# mv config0.m4 config.m4
# /usr/local/php/bin/phpize
# ./configure --with-openssl --with-php-config=/usr/local/php/bin/php-config
# make && make install
# vi /usr/local/php/etc/php.ini
extension=openssl.so

// 动态编译mysqlnd
#  cd /usr/local/src/php-5.6.26/ext/mysqlnd
# cp config9.m4 config.m4
# sed -ie "s{ext/mysqlnd/php_mysqlnd_config.h{config.h{" mysqlnd_portability.h
# /usr/local/php/bin/phpize
# vi configure 
PHP_OPENSSL_DIR = "/usr/bin/openssl /usr/lib/openssl /usr/include/openssl"//新增这几个
# ./configure --with-php-config=/usr/local/php/bin/php-config
# make && make install

// mysql编译
#  cd /usr/local/src/php-5.6.26/ext/mysql

# /usr/local/php/bin/phpize

# ./configure --with-php-config=/usr/local/php/bin/php-config --with-mysql=mysqlnd

# make && make install
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
