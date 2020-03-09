#### 前提

1. 有ubntu1804-phpprod.box
2. 安装vituralbox,vagrant

#### 初始化

```bash
$ vagrant.exe box add ubuntu1804-php-dataqin ubntu1804-phpprod.box
$ vagrant.exe init ubuntu1804-php-dataqin
```

#### 修改挂载目录和网络

> config.vm.network "private_network", ip: "192.168.33.10"
>
> config.vm.synced_folder "C:/Users/86188/workspace/sipc", "/vagrant_data"
>
> //取决于vagrant有没有建立
>
> config.ssh.username = "vagrant"
> config.ssh.password = "vagrant"

#### 启动虚拟机

```bash
$ vagrant.exe up
```

#### 创建nginx用户

```bash
# groupadd nginx && useradd nginx -s /sbin/nologin -g nginx -M
```

#### 创建php软连接

```bash
# ln -s /usr/local/php7/bin/php /usr/local/bin/
```

#### 安装composer

> 参考官网

```bash
# cd /usr/local/bin 
# php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#  php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# php composer-setup.php
# php -r "unlink('composer-setup.php');"
# 设置软连接
# ln - s /usr/local/bin/composer.phar /usr/local/bin/composer
```

可以选择更换composer源

```bash
$ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

取消配置

```
$ composer config -g --unset repos.packagist
```

#### 安装php的grpc扩展

> protoc编译工具,能根据不同proto文件结合插件，生成不同语言的代码

> 在https://pecl.php.net/package/gRPC/1.27.0下载tgz文件
>

```bash
# apt-get install -y autoconf zlib1g-dev protobuf-compiler-grpc
# /usr/local/php7/bin/pecl install /usr/local/src/grpc-1.28.0RC1.tgz
# echo "extension=grpc.so" >>  /usr/local/php7/lib/php.ini 

```

在composer.json中写入

> "grpc/grpc": "v1.12.0",
> "google/protobuf": "^v3.3.0",

#### 挂载nginx配置和代码目录

```bash
# ln -s /vagrant_data/nginx_conf/conf.d /etc/nginx/
# /var/www/sipc.vip.php/
# ln -s /vagrant_data/sipc_vip_backend_php /var/www/sipc.vip.php/current
# mv /etc/nginx/nginx.conf /etc/nginx/nginx.conf.bak
# ln -s /vagrant_data/nginx_conf/nginx/nginx.conf /etc/nginx/nginx.conf
```

