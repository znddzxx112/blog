### centos7��װdocker

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
### docker����,������

```
$ sudo service docker start
$ sudo systemctl enable docker.service
$ sudo systemctl start docker
```
### ����docker�û��鲢����û�

```
$ sudo groupadd docker
$ sudo usermod -aG docker your_username
```
### ����docker�Ƿ�װ�ɹ�
```
$ docker run hello-world
```
