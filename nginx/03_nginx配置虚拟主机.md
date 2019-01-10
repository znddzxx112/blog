
- nginx可以根据端口或者域名来访问不同的虚拟主机

- 在http块中写入二个sever即可
- include include /usr/local/nginx/conf/fastcgi_params;
- fastcgi_params 存放着fastcgi的协议参数，php可以通过$_SERVER['']来获取

```

http {
    server {
        listen       80;
        server_name  t80.caokelei.com;

        location / {
            root   html;
            index  index.html index.htm;
        }

       
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }
    }

    server {
        root /var/www/tt;
        server_name tt.caokelei.com;
        listen 80;

        location / {
                index index.php;
        }

        location ~ .php$ {
                fastcgi_index index.php;
                fastcgi_pass 127.0.0.1:9000;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include /usr/local/nginx/conf/fastcgi_params;
        }
    }
}


```
