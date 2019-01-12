
###### 源码编译php-7.1.0

- 可参考文章：http://www.cleey.com/blog/single/id/857.html
```
# yum -y install libmcrypt libmcrypt-devel libjpeg libjpeg-devel libpng curl-devel libxslt-devel libpng-devel freetype freetype-devel libxml2 libxml2-devel pcre-devel

# curl -sSL -o /usr/local/src/php-7.1.20.tar.gz http://cn2.php.net/get/php-7.1.20.tar.gz/from/this/mirror && \
tar -zxvf /usr/local/src/php-7.1.20.tar.gz && \
cd /usr/local/src/php-7.1.20 && \
mkdir /usr/local/php7 && \
./configure \ 
–prefix=/usr/local/php7 \ 
–with-curl \ 
–with-freetype-dir \
–with-gd \
–with-gettext \
–with-iconv-dir \
–with-kerberos \
–with-libdir=lib64 \
–with-libxml-dir \
–with-mysqli \
–with-openssl \
–with-pcre-regex \
–with-pdo-mysql \
–with-pdo-sqlite \
–with-pear \
–with-png-dir \
–with-xmlrpc \
–with-xsl \
–with-zlib \
–enable-fpm \
–enable-bcmath \
–enable-libmxl \
–enable-inline-optimization \
–enable-gd-native-ttf \
–enable-mbregex \
–enable-mbstring \
–enable-opcache \
–enable-pcntl \
–enable-shmop \
–enable-soap \
–enable-sockets \
–enable-sysvsem \
–enable-xml \
–enable-zip && \
make && make install

// copy php.ini
# cp /usr/local/src/php-7.1.0/php.ini-production /usr/local/php7/etc/php.ini

# 非守护进程启动，docker常用
# /usr/local/php7/sbin/php-fpm -F

// 配置环境变量
# echo "export PATH=$PATH:/usr/local/php7/bin:/usr/local/php7/sbin" >> /etc/profile && \
source /etc/profile

// 测试php7
# php -v

// 配置并开启php-fpm
# cd /usr/local/php7/etc/
# cp php-fpm.conf.default php-fpm.conf
# vi /usr/local/php7/etc/php-fpm.conf
// 找到pid = run/php-fpm.pid把前面的注释符号删掉。
;daemonize = yes 去掉;
# mv www.conf.default www.conf
user = www
group = www
设置 chdir = /var/www

// 配置php-fpm开机启动
# chmod r+x /etc/rc.local
# vim /etc/rc.local
# /usr/local/php7/sbin/php-fpm

// 立即启动php-fpm
# /usr/local/php7/sbin/php-fpm 

```
#### 参考文章做法
```
1、下载php7源代码

github主页 https://github.com/php/php-src 自己 wget或者 git clone吧

wget https://github.com/php/php-src/archive/master.zip  // 然后解压
或者
git clone https://github.com/php/php-src.git
解压后进入php7目录



2、依赖准备

php7依赖一些包，直接yum安装既可

yum -y install libmcrypt libmcrypt-devel libjpeg libjpeg-devel libpng curl-devel libxslt-devel libpng-devel freetype freetype-devel libxml2 libxml2-devel MySQL pcre-devel


3、配置编译参数，并进行编译安装

运行configure

./configure \
--prefix=/usr/local/php7 \
--exec-prefix=/usr/local/php7 \
--bindir=/usr/local/php7/bin \
--sbindir=/usr/local/php7/sbin \
--includedir=/usr/local/php7/include \
--libdir=/usr/local/php7/lib/php \
--mandir=/usr/local/php7/php/man \
--with-config-file-path=/usr/local/php7/etc \
--with-mysql-sock=/var/run/mysql/mysql.sock \
--with-mcrypt=/usr/include \
--with-mhash \
--with-openssl \
--with-mysql=shared,mysqlnd \
--with-mysqli=shared,mysqlnd \
--with-pdo-mysql=shared,mysqlnd \
--with-gd \
--with-iconv \
--with-zlib \
--enable-zip \
--enable-inline-optimization \
--disable-debug \
--disable-rpath \
--enable-shared \
--enable-xml \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-mbregex \
--enable-mbstring \
--enable-ftp \
--enable-gd-native-ttf \
--enable-pcntl \
--enable-sockets \
--with-xmlrpc \
--enable-soap \
--without-pear \
--with-gettext \
--enable-session \
--with-curl \
--with-jpeg-dir \
--with-freetype-dir \
--enable-opcache \
--enable-fpm \
--with-fpm-user=nginx \
--with-fpm-group=nginx \
--without-gdbm 
运行 make

make && make install


4、准备配置文件

上面指定了php安装到 /usr/local/php7下面  ，但是 还没有配置文件，如php.ini等

cp php.ini-production /usr/local/php7/etc/php.ini
cp /usr/local/php7/etc/php-fpm.conf.default /usr/local/php7/etc/php-fpm.conf
cp /usr/local/php7/etc/php-fpm.d/www.conf.default 
可以运行启动 php-fpm 了

cd /usr/local/php7
./sbin/php-fpm
然后结合 nginx 指向 9000端口即可

错误处理

/home/yaoweibo/php-src-master/ext/xmlrpc/libxmlrpc/encodings.c:74: undefined reference to `libiconv_open'
/home/yaoweibo/php-src-master/ext/xmlrpc/libxmlrpc/encodings.c:82: undefined reference to `libiconv'
/home/yaoweibo/php-src-master/ext/xmlrpc/libxmlrpc/encodings.c:102: undefined reference to `libiconv_close'
collect2: ld returned 1 exit status
make: *** [sapi/cli/php] Error 1
谷歌了一下，在安裝 PHP 到系统中时要是发生「undefined reference to libiconv_open’」之类的错误信息，那表示在「./configure 」沒抓好一些环境变数值。错误发生点在建立「-o sapi/cli/php」是出错，没給到要 link 的 iconv 函式库参数。

解决办法：

一种是编辑Makefile ，找到EXTRA_LIBS 这一行，在最后面加上 -liconv 重新make

另一种是make ZEND_EXTRA_LIBS='-liconv'

我用的是第二种方法。
```
