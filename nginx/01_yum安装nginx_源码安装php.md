#### centos6.8服务器配置-Nginx[yum]-php[src]

##### 前提

```
yum -y install wget make gcc gcc-c++ pcre openssl openssl-devel zlib unzip cmake ncurses-devel libjpeg libjpeg-devel libpng libpng-devel libxml2 libxml2-devel curl-devel libtool libtool-ltdl libtool-ltdl-devel libevent libevent-devel zlib-static zlib-devel autoconf pcre-devel gd perl freetype freetype-devel lynx
```

##### nginx导读

- 读懂官网这段话地址：http://nginx.org/en/linux_packages.html#stable

```
To set up the yum repository for RHEL/CentOS, create the file named /etc/yum.repos.d/nginx.repo with the following contents:
[nginx]
name=nginx repo
baseurl=http://nginx.org/packages/OS/OSRELEASE/$basearch/
gpgcheck=0
enabled=1
Replace “OS” with “rhel” or “centos”, depending on the distribution used, and “OSRELEASE” with “5”, “6”, or “7”, for 5.x, 6.x, or 7.x versions, respectively.
```

##### 是否安装nginx

```
# rpm -qa | grep nginx
```

##### 新建新建源

```
# vi /etc/yum.repos.d/nginx.repo
写入并保存
[nginx]
name=nginx repo
baseurl=http://nginx.org/packages/centos/6/$basearch/
gpgcheck=0
enabled=1

执行命令  
# yum update
```

##### 安装nginx

```
# yum install -y nginx
```

##### 查看nginx版本

```
# nginx -v
```

##### 设置为自启动

```
# chkconfig --list nginx
# chkconfig --level 345 nginx on
```

##### 配置防火墙

```
# vi /etc/sysconfig/iptables
// 开启80端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
// 重启防火墙
# service iptables restart
```

##### 启动与关闭

```
# service nginx start
# service nginx stop
```

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

// 成功编译-复杂版-一句话
# ./configure --prefix=/usr/local/php/ --with-config-file-path=/usr/local/php/etc/ --with-iconv-dir=/usr/local/libiconv --enable-fpm --enable-mysqlnd --enable-mbstring --enable-bcmath --enable-calendar --enable-exif \
--enable-ftp --enable-gd-native-ttf --enable-soap --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-zip --enable-sockets \
--with-pdo-mysql=mysqlnd --with-mysqli=mysqlnd --with-mysql-sock=/var/lib/mysql/mysql.sock --with-curl --with-freetype-dir --with-gd --with-gettext --with-openssl --with-mhash --with-pear --with-zlib --with-xmlrpc 

# make && make install

// 注意:再次编译前，需执行
# make clean
```

##### php命令作为环境变量

```
# vi /etc/profile
// 添加语句，保存退出
export PATH=$PATH:/usr/local/php/bin
// 立即生效
source /etc/profile
```

##### 配置并开启php-fpm

```
# cd /usr/local/php/etc/
# cp php-fpm.conf.default php-fpm.conf
# vi /usr/local/php/etc/php-fpm.conf
// 找到pid = run/php-fpm.pid把前面的注释符号删掉。
// ;daemonize = yes 去掉;
// user = www group www
# /usr/local/php/sbin/php-fpm 
// 设置 chdir = /usr/share/nginx/html
```

##### php-fpm 启动重启关闭与开机启动脚本

```
// 编译后会生成
# cp /usr/local/src/php-5.6.26/sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm

# chmod 755 /etc/init.d/php-fpm
# chkconfig --add php-fpm
# chkconfig --level 345 php-fpm on
# chkconfig --list php-fpm

php-fpm 启动：
/usr/local/php/sbin/php-fpm
php-fpm 关闭：
kill -INT `cat /usr/local/php/var/run/php-fpm.pid`
php-fpm 重启：
kill -USR2 `cat /usr/local/php/var/run/php-fpm.pid`
```

##### 配置文件-nginx支持php

```
# vi /etc/nginx/conf.d/default.conf 

# 增加索引文件
location / {
        root   /usr/share/nginx/html;
        index  index.php index.html index.htm;
    }

# 打开注释，支持php-fpm
# root 修改为 /usr/share/nginx/html
    location ~ \.php$ {
        root           /usr/share/nginx/html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        # fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

# chown -R nginx:nginx /usr/share/nginx/html

# chmod -R 755 /usr/share/nginx/html/
```

##### php.ini拷贝

```
// 注意phpinfo()
Configuration File (php.ini) Path  // php.ini路径
Loaded Configuration File  // 载入的配置文件
// 从源文件拷贝php.ini
# cp /usr/local/src/php-5.6.26/php.ini-production /usr/local/php/etc/php.ini
# kill -USR2 `cat /usr/local/php/var/run/php-fpm.pid //重启php-fpm
```

##### 测试

```
# echo "<?php echo phpinfo();?>" > /usr/share/nginx/html/index.php
```



