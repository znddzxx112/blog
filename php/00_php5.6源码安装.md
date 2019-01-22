- http://php.net/downloads.php

源码安装php5.6
##### 编译安装PHP依赖包

```
# 注意：freetype在生成验证码图片需要用，所以必须要安装的
# yum -y install openssl openssl-devel libxml2 libxml2-devel curl curl-devel zlib libevent
# yum -y install libpng libpng-devel libjpeg libjpeg-devel freetype freetype-devel gd gd-devel php-mcrypt autoconf

// 源码包安装libiconv
# cd /usr/local/src && \
wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.14.tar.gz && \
tar zxvf libiconv-1.14.tar.gz && \
cd libiconv-1.14/ && \
./configure --prefix=/usr/local/libiconv && \
make && make install

// 源码包安装libmcrypt
// libmcrypt version 2.5.6 or greater required.
// 2.5.8下载地址:https://sourceforge.net/projects/mcrypt/files/Libmcrypt/2.5.8/
# cd /usr/local/src && \
tar zxvf libmcrypt-2.5.8.tar.gz && \
cd libmcrypt-2.5.8/ && \
./configure --prefix=/usr/local/libmcrypt/ && \
make && make install

```

```
# cd /usr/local/src/ && \
mkdir -p /usr/local/php56 && \
wget http://cn2.php.net/get/php-5.6.26.tar.gz/from/this/mirror && \
mv mirror php-5.6.26.tar.gz && \
tar -zxvf php-5.6.26.tar.gz && \
cd php-5.6.26 && \
./configure \
--prefix=/usr/local/php56/ \
--with-apxs2=/usr/local/httpd/bin/apxs \ apache才使用
--with-config-file-path=/usr/local/php56/etc/ \
--with-iconv-dir=/usr/local/libiconv \
--enable-fpm \
--enable-mysqlnd \
--enable-mbstring \ 
--enable-bcmath \
--enable-calendar \
--enable-exif \
--enable-ftp \
--enable-gd-native-ttf \
--enable-soap \
--enable-sysvmsg \
--enable-sysvsem \
--enable-sysvshm \
--enable-zip \
--enable-sockets \
--with-pdo-mysql=mysqlnd \
--with-mysqli=mysqlnd \
--with-mysql-sock=/var/lib/mysql/mysql.sock \
--with-curl \
--with-freetype-dir \
--with-gd \
--with-gettext \
--with-openssl \
--with-mhash \
--with-pear \
--with-zlib \
--with-xmlrpc && \
make && make install
