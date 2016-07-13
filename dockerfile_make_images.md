
准备nginx配置文件,rc.local

可参照
[https://github.com/znddzxx112/docker-centos-nginx-php](https://github.com/znddzxx112/docker-centos-nginx-php)

### 编辑Dockerfile
```
$ vi Dockerfile
```
```
FROM centos:latest
MAINTAINER znddzxx112 <znddzxx112@163.com>
# add nginx rep
ADD nginx.repo /etc/yum.repos.d/
# install php php-fpm
RUN yum update -y \
    && yum -y install gcc gcc-c++ kernel-develpcre pcre-devel zlib zlib-devel openssl openssl-devel \
    && yum -y install php lighttpd-fastcgi php-cli php-mysql php-gd php-imap php-ldap  \
    && yum -y install php-odbc php-pear php-xml php-xmlrpc php-mbstring  \
    && yum -y install php-mcrypt php-mssql php-snmp php-soap  \
    && yum -y install php-tidy php-common php-devel php-fpm

# install nginx
RUN yum -y install nginx

# cp nginx file
# RUN rm -v /etc/nginx/conf.d/defaul.conf
ADD default.conf /etc/nginx/conf.d/

# make code dir
RUN mkdir -p /app && rm -rf /var/www/html && ln -s /app /var/www/html

# cp src /app

# expose ports
EXPOSE 80

# nginx php-fpm self start
RUN rm -v /etc/rc.d/rc.local
ADD rc.local /etc/rc.d/

# rc.local +x
RUN chmod +x /etc/rc.d/rc.local

# run scripts
# ENTRYPOINT ["/opt/bin/start.sh"]
```
### 生成镜像
```
$ sudo docker  build -t docker-centos-nginx-php .
```
### 交互式方式运行容器
```
$ sudo docker run -it -v $pwd:/app -p 80:80 docker-centos-nginx-php /etc/rc.local 
```
### 守护式方式运行容器
```
$ sudo docker run -d -v $pwd:/app -p 80:80 docker-centos-nginx-php /etc/rc.local
```
### 将dockerfile文件保存到github
```
$ git init
$ git add -A
$ git commit -m "dockerfile"
$ git remote add origin https://github.com/znddzxx112/docker-centos-nginx-php.git
$ git push -u origin master
```
### 三句话部署实践
### （一）适用于测试场景的快速部署
```
$ git clone https://github.com/znddzxx112/docker-centos-nginx-php
$ sudo docker build -t centos7-nginx-php . 
$ docker run -d -v $pwd:/app  centos7-nginx-php
```
centos7-nginx-php 为镜像名称，此种方式为代码放置容器外部，适合调试，代码经常替换
### （二）适用于单一服务场景的快速部署
```
$ git clone https://github.com/znddzxx112/docker-centos-nginx-php
$ sudo docker build -t centos7-nginx-php. 
$ docker run -d -v $pwd:/app centos7-nginx-php
```
centos7-nginx-php 为镜像名称，此种方式为代码放置容器内部，适合单一服务
