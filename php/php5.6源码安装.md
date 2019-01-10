- http://php.net/downloads.php

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
