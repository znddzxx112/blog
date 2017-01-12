- 参考文章：http://blog.csdn.net/physicsdandan/article/details/45667357
- http://nginx.org/en/docs/http/ngx_http_upstream_module.html
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
