[TOC]


### centos7安装docker

```
$ sudo tee /etc/yum.repos.d/docker.repo <<-'EOF'
[dockerrepo]
name=Docker Repository
baseurl=https://yum.dockerproject.org/repo/main/centos/7/
enabled=1
gpgcheck=1
gpgkey=https://yum.dockerproject.org/gpg
EOF
$ sudo yum install docker-engine
```
#### docker启动,自启动

```
$ sudo service docker start
$ sudo systemctl enable docker.service
$ sudo systemctl start docker
```
#### 设置docker用户组并添加用户

```
$ sudo groupadd docker
$ sudo usermod -aG docker your_username
```
#### 测试docker是否安装成功
```
$ docker run hello-world
```

### docker 常用命令

***

#### 容器生命周期管理
docker [run|start|stop|restart|kill|rm|pause|unpause]

eg:

214a 容器名称
```
$ sudo docker run -i -t -v /your_code_directory:/var/www/html richarvey/nginx-php-fpm 交互式运行容器
$ sudo docker run -p 80:80 -d -v /var/www:/app/html unblibraries/nginx-php 守护进程运行容器
$ sudo docker start -i 214a 重新启动容器
$ sudo docker stop 214a 停止容器
$ sudo docker restart 214a 重新启动容器
$ sudo docker kill 214a 杀死容器
$ sudo docker rm 214a 删除停止的容器
```
#### 容器操作运维
docker [ps|inspect|top|attach|events|logs|wait|export|port]

eg:
```
$ sudo docker ps -al
$ sudo docker inspect 214a
$ sudo docker top 214a
$ sudo docker attach 214a 进入守护容器
$ sudo docker logs -tf --tail
```
#### 容器rootfs命令
docker [commit|cp|diff]
#### 镜像仓库
docker [login|pull|push|search]

eg:
```
$ sudo docker login
$ sudo docker search ubuntu
$ sudo docker pull ubuntu
```
#### 本地镜像管理 
docker [images|rmi|tag|build|history|save|import]

eg:
```
$ sudo docker images
$ sudo docker build -t [name] .
```
#### 镜像导出与导入

```bash
$ docker save -o hto-gateway.tar hto-gateway:latest
$ docker load --input hto-gateway.tar
```



#### 其他命令

docker [info|version]
#### 变迁图
![](https://sfault-image.b0.upaiyun.com/404/256/404256463-545a1d114c535_articlex)

- docker
```
image:
docker tag sorurce:tag targert:tag
docker images
docker rmi images_name
docker build . -t image_name
docker run -d/-it -p -v --privired image_name --name
docker pull xxx.com/xxx/xxx:tag
docker push xxx/xxx:latest

cotainers:
docker ps -a
docker ps
docker rm -f contain_name
docker stop
docker start
docker restart
docker top container_name
docker commit container_name image_name:tag

repority:
docker login
docker logout
```

#### 问题：使用root权限登录到容器中

> docker run --user=root

### 制作镜像

准备nginx配置文件,rc.local

可参照
[https://github.com/znddzxx112/docker-centos-nginx-php](https://github.com/znddzxx112/docker-centos-nginx-php)

#### 编辑Dockerfile
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
#### 生成镜像
```
$ sudo docker  build -t docker-centos-nginx-php .
```
#### 交互式方式运行容器
```
$ sudo docker run -it -v $pwd:/app -p 80:80 docker-centos-nginx-php /etc/rc.local 
```
#### 守护式方式运行容器
```
$ sudo docker run -d -v $pwd:/app -p 80:80 docker-centos-nginx-php /etc/rc.local
```
#### 将dockerfile文件保存到github
```
$ git init
$ git add -A
$ git commit -m "dockerfile"
$ git remote add origin https://github.com/znddzxx112/docker-centos-nginx-php.git
$ git push -u origin master
```
#### 三句话部署实践
#### （一）适用于测试场景的快速部署
```
$ git clone https://github.com/znddzxx112/docker-centos-nginx-php
$ sudo docker build -t centos7-nginx-php . 
$ docker run -d -v $pwd:/app  centos7-nginx-php
```
centos7-nginx-php 为镜像名称，此种方式为代码放置容器外部，适合调试，代码经常替换
#### （二）适用于单一服务场景的快速部署
```
$ git clone https://github.com/znddzxx112/docker-centos-nginx-php
$ sudo docker build -t centos7-nginx-php. 
$ docker run -d -v $pwd:/app centos7-nginx-php
```
centos7-nginx-php 为镜像名称，此种方式为代码放置容器内部，适合单一服务

### 将代码放入镜像中

#### 拉取centos基础镜像
`$ docker pull centos`
#### 运行镜像
`$ docker run -t -i centos `
#### 安装nginx,php-fpm,php
```
$ sudo yum update
$ sudo yum -y install php lighttpd-fastcgi php-cli php-mysql php-gd php-imap php-ldap \
php-odbc php-pear php-xml php-xmlrpc php-mbstring php-mcrypt php-mssql php-snmp php-soap
$ sudo yum -y install php-tidy php-common php-devel php-fpm php-mysql
$ sudo yum install -y nginx
```
#### 准备一个干净的放置代码的目录/app
`$ sudo mkdir -p /app && rm -rf /var/www/html && ln -s /app /var/www/html `
#### 修改nginx配置文件片段
```
server_name _;
location / {  
           root   /app;  
           index  index.html index.htm index.php;  
       }  
       ...  
location ~ \.php$ {  
           root           /app;  
           fastcgi_pass   127.0.0.1:9000;  
           fastcgi_index  index.php;  
           fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;  
           include        fastcgi_params;  
       }  
```
#### 将nginx，php-fpm设置为自启动
```
$ sudo chmod +x /etc/rc.d/rc.local 
$ sudo vi /etc/rc.d/rc.local
/usr/sbin/nginx      
/usr/sbin/php-fpm 
```
#### 创建镜像
```
# exit
$ docker ps -al 查看运行（未运行）容器
$ docker commit 214a centos-nginx-php #214a为容器名称
```
#### 查看镜像
`$ docker images`
#### 运行镜像【php代码部署在容器外部/var/www】
`$ docker run -d -v /var/www:/app -p 80:80 centos-nginx-php:latest /etc/rc.local`


### 将镜像推送到仓库

#### hub.docker.com注册账号
在hub.docker.com注册账号，建立repository,名称如:znddzxx112/centos7-nginx-php

#### 本地镜像推送到hub.docker.com
本地有镜像centos-nginx-php:latest
```
$ sudo docker login
$ sudo docker tag centos-nginx-php:latest znddzxx112/centos7-nginx-php:latest
$ docker push znddzxx112/centos7-nginx-php:latest
```


### 镜像瘦身

#### 下载依赖前置利用好层缓存

```dockerfile
FROM golang:1.13.5 AS build

WORKDIR /backend_go
ENV GOPROXY https://goproxy.cn
ENV GO111MODULE on

ADD go.mod .
ADD go.sum .
RUN go mod download
COPY . .

// do something
```

#### 使用多级构建

```dockerfile
FROM alpine:latest
RUN apk --no-cache add ca-certificates
WORKDIR /app
COPY --from=build /app .
```

> COPY还可以从其他镜像中拷贝文件，比如：
>
> COPY --from=nginx:latest /etc/nginx/nginx.conf /nginx.conf

#### 命令连写减少层的个数

```dockerfile
RUN go version && go env && mkdir -p dist \
    && go build -o ./dist/gateway ./gateway/cmd/gateway
```



#### docker-composer

> 文档地址：https://docs.docker.com/compose/environment-variables/


### Docker中国官方镜像加速

- 参考网址
```
https://www.docker-cn.com/registry-mirror
```

- usage
```
$ docker pull registry.docker-cn.com/myname/myrepo:mytag
eg.
$ docker pull registry.docker-cn.com/library/ubuntu:16.04
```

- other
```
https://registry.docker-cn.com

http://hub-mirror.c.163.com

https://3laho3y3.mirror.aliyuncs.com

http://f1361db2.m.daocloud.io

https://mirror.ccs.tencentyun.com

eg. 
docker pull 3laho3y3.mirror.aliyuncs.com/library/mariadb
docker tag 3laho3y3.mirror.aliyuncs.com/library/mariadb mariadb 
```

### gitlab

#### 下载gitlab

```bash
docker pull 3laho3y3.mirror.aliyuncs.com/gitlab/gitlab-ce:latest gitlab/gitlab-ce:latest
```

#### 重命名景象名称

```
docker tag 3laho3y3.mirror.aliyuncs.com/gitlab/gitlab-ce:latest gitlab/gitlab-ce:latest gitlab/gitlab-ce:latest
```

