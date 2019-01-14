##### nginx配置php-fpm

```
# vim /usr/local/nginx/conf/nginx.conf
user www
location ~ \.php$ {
    root           /var/www/;
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    include        fastcgi_params;
}

location /foo {
    if (!-e $request_filename) {
        rewrite ^/foo/(.*)$ /foo/index.php last;
    }
}

或者:(理解nginx后品味一下差异，适用于什么场景)

location ^~ /foo/ {
    root           /var/www/wwwRoot;
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    set $script_name /foo/index.php;
    fastcgi_param  SCRIPT_FILENAME  $document_root$script_name;
    include        fastcgi_params;
    # fastcgi_param REQUEST_URI /fooApp/controllerName/method/
    # set $args  from=1&$args
}

# nginx -s reload
```

- 变量解释
```
log_format 'client address: $remote_addr - client port: $remote_port - method:$request_method - host:$host - port:$server_port - request: $request - request_filename:$request_filename - uri:$uri - request_uri:$request_uri - args:$args - document_root:$document_root,remenber http_, arg_, cookie_ ' dumpRequest
```
