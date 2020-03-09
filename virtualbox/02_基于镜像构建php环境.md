#### 将box镜像加入到vagrant列表中

在box所在文件夹打开git bash

```bash
$ vagrant.exe box add ubuntu1804-phpprod ubntu1804.box
```

> ubuntu1804-phpprod 名字随意取

##### 生成vagrant配置文件

```bash
vagrant.exe init ubuntu1804-phpprod
```

编辑vagrantfile文件

打开以下二行

> config.vm.network "private_network", ip: "192.168.33.10"
>
> config.vm.synced_folder "C:/Users/86188/workspace/sipc/sipc_vip_backend_php", "/vagrant_data"

#### 启动虚拟机

```bash
$ vagrant.exe up
```

#### 更换软件源

> 使用阿里源
>
> https://developer.aliyun.com/mirror/ubuntu?spm=a2c6h.13651102.0.0.3e221b11lUlYox

#### 下载php源文件

> php.net 下载

#### php依赖解决

```bash
# apt-get install -y make gcc g++
# apt-get install -y build-essential libexpat1-dev libgeoip-dev libpng-dev libpcre3-dev libssl-dev libxml2-dev rcs zlib1g-dev libmcrypt-dev libcurl4-openssl-dev libjpeg-dev libpng-dev libwebp-dev pkg-config
# apt-get install -y libcurl4-openssl-dev libgd-dev libwebp-dev libpng++-dev libfreetype6-dev libghc-zlib-dev libmcrypt-dev libxml++2.6-dev libssl-dev libbz2-dev libxslt1-dev libxml2-dev libfreetype6-dev libxslt1-dev
```

> apt install libcurl4-openssl-dev #安装curl开发套件
> apt install libgd-dev #安装gd开发套件
> apt install libwebp-dev #安装webp开发套件
> apt install libjpeg-dev #安装jpeg开发套件
> apt install libpng++-dev #安装png开发套件
> apt install libfreetype6-dev #安装libfreetype6-dev开发套件
> apt install libghc-zlib-dev #安装zlib开发套件
> apt install libmcrypt-dev #安装libmcrypt开发套件
> apt install libxml++2.6-dev #安装libxml开发套件
> apt install libssl-dev #安装ssl开发套件
> apt install libbz2-dev #安装bzip2开发套件
>
> apt install libxslt1-dev #安装xslt

#### php安装

```bash
# groupadd fpm && useradd fpm -s /sbin/nologin -g fpm -M && \
tar -zxvf /usr/local/src/php-7.2.28.tar.gz -C /usr/local/src/ && \
cd /usr/local/src/php-7.2.28 && \
mkdir /usr/local/php7 && \
./configure \
-prefix=/usr/local/php7 \
-with-curl \
--with-fpm-user=fpm \
--with-fpm-group=fpm \
--with-freetype-dir \
--with-gd \
--with-gettext \
--with-iconv-dir \
--with-kerberos \
--with-libdir=lib64 \
--with-libxml-dir \
--with-mysqli \
--with-openssl \
--with-pcre-regex \
--with-pdo-mysql \
--with-pdo-sqlite \
--with-pear \
--with-png-dir \
--with-xmlrpc \
--with-xsl \
--with-zlib \
--enable-fpm \
--enable-bcmath \
--enable-libmxl \
--enable-inline-optimization \
--enable-gd-native-ttf \
--enable-mbregex \
--enable-mbstring \
--enable-opcache \
--enable-pcntl \
--enable-shmop \
--enable-soap \
--enable-sockets \
--enable-sysvsem \
--enable-xml \
--enable-zip \
--disable-fileinfo && make && make install

cp /usr/local/src/php-7.2.28/php.ini-production /usr/local/php7/lib/php.ini
cp /usr/local/php7/etc/php-fpm.conf.default /usr/local/php7/etc/php-fpm.conf
cp /usr/local/php7/etc/php-fpm.d/www.conf.default /usr/local/php7/etc/php-fpm.d/www.conf
```

#### 导出box镜像文件用于分享

> vagrant.exe package --base ubuntu1804_default_1582437622933_96160 --output ubntu1804-phpprod.box

