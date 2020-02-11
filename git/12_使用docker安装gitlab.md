[TOC]

## 使用docker安装gitlab

> 官方文档：https://docs.gitlab.com/omnibus/docker/README.html

### 迁移gitlab数据

> 如果存在gitlab仓库数据的情况，将文件夹打包

```bash
# cd /srv
# tar -zcvf /tmp/gitlab.tar.gz gitlab
```

> 发给其他机器并解压

```bash
# scp 112@xxx:/tmp/gitlab.tar.gz /tmp
# tar -zxvf /tmp/gitlab.tar.gz -C /srv/
```

### 下载gitlab镜像

```bash
$ docker pull 3laho3y3.mirror.aliyuncs.com/gitlab/gitlab-ce
$ docker tag 3laho3y3.mirror.aliyuncs.com/gitlab/gitlab-ce:latest gitlab/gitlab-ce:latest
```

### 运行gitlab镜像

```bash
docker run -d --name gitlab \
	-p 8443:443 \
	-p 8090:8090 \
	-p 8022:22 \
	--volume /srv/gitlab/config:/etc/gitlab:Z \
    --volume /srv/gitlab/logs:/var/log/gitlab:Z \
    --volume /srv/gitlab/data:/var/opt/gitlab:Z \
	/gitlab/gitlab-ce:latest
```

> 解释下
>
> -d : 后台运行
>
> --name gitlab：容器名定为gitlab
>
> --restart always：重启容器的策略。当宿主机重启时，该容器开机启动。否则，需要人工docker start gitlab启动
>
> -p 端口映射
>
> -v 目录挂载

### 修改gitlab配置

```bash
# docker exec -it gitlab /bin/bash
```

修改/etc/gitlab/gitlab.rb,在文件末尾追加：

```
external_url 'http://192.168.1.104:8090'
gitlab_rails['gitlab_shell_ssh_port'] = 8022
```

> external_url 'http://192.168.1.114:8090' 为宿主机ip，后期访问路径
>
> gitlab_rails['gitlab_shell_ssh_port'] = 8022 为ssh push时使用

重启gitlab服务

> gitlab-ctl reconfigure
>
> gitlab-ctl restart

### 宿主机防火墙允许端口

- ubuntu18.04

```
# ufw allow 8443/tcp
# ufw allow 8090/tcp
# ufw allow 8022/tcp
# ufw reload
```

### 访问gitlab

http://192.168.1.104:8090/

输入root用户密码