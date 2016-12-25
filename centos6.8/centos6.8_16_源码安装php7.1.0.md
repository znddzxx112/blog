
###### 源码编译php-7.1.0
```
# cd /usr/local/src
# wget http://cn2.php.net/get/php-7.1.0.tar.gz/from/this/mirror
# mv mirror php-7.1.0.tar.gz
# tar -zxvf php-7.1.0.tar.gz 
# cd php-7.1.0

# cd /usr/local/src/php7

// 配置
# mkdir /usr/local/php7
# ./configure --prefix=/usr/local/php7 -enable-fpm --with-mysqli

// 配置语句2
./configure –prefix=/usr/local/php7 –with-curl –with-freetype-dir –with-gd –with-gettext –with-iconv-dir –with-kerberos –with-libdir=lib64 –with-libxml-dir –with-mysqli –with-openssl –with-pcre-regex –with-pdo-mysql –with-pdo-sqlite –with-pear –with-png-dir –with-xmlrpc –with-xsl –with-zlib –enable-fpm –enable-bcmath –enable-libmxl –enable-inline-optimization –enable-gd-native-ttf –enable-mbregex –enable-mbstring –enable-opcache –enable-pcntl –enable-shmop –enable-soap –enable-sockets –enable-sysvsem –enable-xml –enable-zip

// 编译与安装
# make && make install

// 配置环境变量
# vim /etc/profile
# export PATH=$PATH:/usr/local/php7/bin:/usr/local/php7/sbin
# source /etc/profile

// php.ini拷贝
// 使用phpinfo()查看ini路径
Configuration File (php.ini) Path  // php.ini路径
Loaded Configuration File  // 载入的配置文件
// 从源文件拷贝php.ini
# cp /usr/local/src/php-7.1.0/php.ini-production /usr/local/php7/etc/php.ini

// 测试php7
# php -v

// 配置并开启php-fpm
# cd /usr/local/php7/etc/
# cp php-fpm.conf.default php-fpm.conf
# vi /usr/local/php7/etc/php-fpm.conf
// 找到pid = run/php-fpm.pid把前面的注释符号删掉。
;daemonize = yes 去掉;
user = www
group = www
设置 chdir = /var/www
# mv www.conf.default www.conf

// 配置php-fpm开机启动
# chmod r+x /etc/rc.local
# vim /etc/rc.local
# /usr/local/php7/sbin/php-fpm

// 立即启动php-fpm
# /usr/local/php/sbin/php-fpm 

```
