### hub.docker.com注册账号
在hub.docker.com注册账号，建立repository,名称如:znddzxx112/centos7-nginx-php
### 本地镜像推送到hub.docker.com
本地有镜像centos-nginx-php:latest
```
$ sudo docker login
$ sudo docker tag centos-nginx-php:latest znddzxx112/centos7-nginx-php:latest
$ docker push znddzxx112/centos7-nginx-php:latest
```
