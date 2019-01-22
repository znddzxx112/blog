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
### docker启动,自启动

```
$ sudo service docker start
$ sudo systemctl enable docker.service
$ sudo systemctl start docker
```
### 设置docker用户组并添加用户

```
$ sudo groupadd docker
$ sudo usermod -aG docker your_username
```
### 测试docker是否安装成功
```
$ docker run hello-world
```
