## docker 常用命令

***

### 容器生命周期管理
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
### 容器操作运维
docker [ps|inspect|top|attach|events|logs|wait|export|port]

eg:
```
$ sudo docker ps -al
$ sudo docker inspect 214a
$ sudo docker top 214a
$ sudo docker attach 214a 进入守护容器
$ sudo docker logs -tf --tail
```
### 容器rootfs命令
docker [commit|cp|diff]
### 镜像仓库
docker [login|pull|push|search]

eg:
```
$ sudo docker login
$ sudo docker search ubuntu
$ sudo docker pull ubuntu
```
### 本地镜像管理 
docker [images|rmi|tag|build|history|save|import]

eg:
```
$ sudo docker images
$ sudo docker build -t [name] .
```
### 其他命令
docker [info|version]
### 变迁图
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
