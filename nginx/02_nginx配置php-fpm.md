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

或者:(理解nginx后品味一下差异，适用于什么场景)

location ^~ /foo/ {
    root           /var/www/wwwRoot;
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    set $script_name /foo/index.php;
    fastcgi_param  SCRIPT_FILENAME  $document_root$script_name;
    include        fastcgi_params;
    #fastcgi_param REQUEST_URI /fooApp/controllerName/method/
    #set $args  from=1&$args
}

# nginx -s reload
```

