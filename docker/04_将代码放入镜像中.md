### 拉取centos基础镜像
`$ docker pull centos`
### 运行镜像
`$ docker run -t -i centos `
### 安装nginx,php-fpm,php
```
$ sudo yum update
$ sudo yum -y install php lighttpd-fastcgi php-cli php-mysql php-gd php-imap php-ldap \
php-odbc php-pear php-xml php-xmlrpc php-mbstring php-mcrypt php-mssql php-snmp php-soap
$ sudo yum -y install php-tidy php-common php-devel php-fpm php-mysql
$ sudo yum install -y nginx
```
### 准备一个干净的放置代码的目录/app
`$ sudo mkdir -p /app && rm -rf /var/www/html && ln -s /app /var/www/html `
### 修改nginx配置文件片段
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
### 将nginx，php-fpm设置为自启动
```
$ sudo chmod +x /etc/rc.d/rc.local 
$ sudo vi /etc/rc.d/rc.local
/usr/sbin/nginx      
/usr/sbin/php-fpm 
```
### 创建镜像
```
# exit
$ docker ps -al 查看运行（未运行）容器
$ docker commit 214a centos-nginx-php #214a为容器名称
```
### 查看镜像
`$ docker images`
### 运行镜像【php代码部署在容器外部/var/www】
`$ docker run -d -v /var/www:/app -p 80:80 centos-nginx-php:latest /etc/rc.local`
