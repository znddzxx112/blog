##### 前提

1. 有ubntu1804-phpprod.box
2. 安装vituralbox,vagrant

##### 初始化

```bash
$ vagrant.exe box add ubuntu1804-php-dataqin ubntu1804-phpprod.box
$ vagrant.exe init ubuntu1804-php-dataqin
```

##### 修改挂载目录和网络

> config.vm.network "private_network", ip: "192.168.33.10"
>
> config.vm.synced_folder "C:/Users/86188/workspace/sipc", "/vagrant_data"
>
> //取决于vagrant有没有建立
>
> config.ssh.username = "vagrant"
> config.ssh.password = "vagrant"

##### 启动虚拟机

```bash
$ vagrant.exe up
```

##### 远程登录到虚拟机中

挂载nginx配置和代码目录

```
# ln -s /vagrant_data/nginx_conf/conf.d /etc/nginx/
# /var/www/sipc.vip.php/
# ln -s /vagrant_data/sipc_vip_backend_php /var/www/sipc.vip.php/current
# mv /etc/nginx/nginx.conf /etc/nginx/nginx.conf.bak
# ln -s /vagrant_data/nginx_conf/nginx/nginx.conf /etc/nginx/nginx.conf
```

##### 创建nginx用户

```
# groupadd nginx && useradd nginx -s /sbin/nologin -g nginx -M
```

##### 安装composer

> 参考官网

```bash
$ composer update
```

可以选择更换composer源

```bash
$ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

取消配置

```
$ composer config -g --unset repos.packagist
```

##### 安装grpc的php扩展

> 需要先安装protobuf：https://github.com/protocolbuffers/protobuf/blob/master/src/README.md
>
> - protoc编译工具
> - protobuf c扩展 【可以使用composer protobuf替代】
> - gRPC命令行工具（grpc_php_plugin）
> - grpc c扩展
> - grpc php库【protoc生成的php代码】

参考文章：

> https://blog.csdn.net/weixin_39986952/article/details/81168633
>
> https://github.com/grpc/grpc/blob/master/BUILDING.md
>
> 
>
> 直接使用apt install protobuf-compiler-grpc搞定
>
> 在https://pecl.php.net/package/gRPC/1.27.0下载tgz文件
>
> pecl install grpc-1.28.0RC1.tgz
>
> 并在php.ini中写入 extension=grpc.so
>
> 在composer.json中写入
>
> ```
> "grpc/grpc": "v1.12.0",
> "google/protobuf": "^v3.3.0",
> ```

```
// zlib install
# sudo apt-get install zlib1g-dev
// grpc 
# git clone -b v1.27.0 https://gitee.com/mirrors/grpc-framework grpc
# cd grpc
# git submodule update --init  #更新第三方源码

// protobuf
# wget https://github.com/protocolbuffers/protobuf/archive/v3.11.4.tar.gz
# apt-get install autoconf automake libtool curl make g++ unzip
# ./autogen.sh
#./configure
# make
# make check
# sudo make install
# sudo ldconfig # refresh shared library cache.
// grpc
# wget https://github.com/grpc/grpc/archive/v1.12.0.tar.gz
# tar -zxvf v1.12.0.tar.gz
# cd grpc
# apt install libc-ares-devel
# make && make install

# cd ext/php/
# 
// https://pecl.php.net/package/gRPC
# wget https://pecl.php.net/get/grpc-1.27.0.tgz
```



