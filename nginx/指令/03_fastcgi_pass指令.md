- 参考文章：http://blog.csdn.net/physicsdandan/article/details/45667357
- http://nginx.org/en/docs/http/ngx_http_upstream_module.html
- http://blog.codinglabs.org/articles/intro-of-nginx-module-development.html
- 安装nginx模块步骤
```
./configure --prefix=安装目录 --add-module=模块源代码文件目录
make
make install
```
- 查看nginx编译的代码（安装了哪些模块）
```
nginx -V
```
- nginx .conf
- 反向代码和负载均衡都使用upstream块。下面upstream块的结构。
```
http 块
    server 块
        location 块
    upstream 块
```
```
http {
    upstream phpbackend {
        server unix:/dev/shm/php-fpm.socket
        server 192.168.1.119
    }
    server {
        // 最具体的location转发给上游php
        location / {
            fastcgi_pass phpbackend;
            fastcgi_param script_filename $document_root$fastcgi_script_name
            fastcgi_index index.php;
            include fastcgi_params;
        }
    }
}
```

- 附上nginx.conf常用结构
```
user nobody
work_process 1
events {
    work_connection 1024
}
// 反向代理或者负载均衡
upstream phpbackend{
    server unix:/dev/shm/php-fpm.socket;
    server 127.0.0.1:9000;
}

http {
    include mime.types;
    server {
        root  www
        listen
        server_name 
        location = /static/ {

        }
        location ^~ /images/ {
            expired 3d;
        }
        location ~* .(jpg|bmp)${
            expired 3h;
            return 403;
        }
        location ~ /circle/(\d+)/\.html {
            root www/html;
            fastcgi_pass phpbackend;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root $fastcgi_script_name;
            include fastcgi_params;
        }
        location / {

        }
    }
    # 加载其他虚拟主机
    include vhost/*.conf
}
```
