- 目的
```
0. 不再使用新域名，同时解决跨域问题
```

- 设置上游服务器
```
 upstream getkey{
    server 183.131.12.159:6002 fail_timeout=30s;
}

upstream videoupload{
    server 183.131.12.159:8008 fail_timeout=30s;
}
```

- location中使用proxy_pass进行反向代理
```
 location ~* /videoupload/(.*)/(.*) {
#location ^~ /videoupload/ {
    client_max_body_size 500m;
    client_body_buffer_size 1024k;
    proxy_pass http://videoupload/$1/$2?$args;
    #proxy_pass http://videoupload/$uri?$args;
    #access_log logs/videoupload uri;
    #proxy_pass http://183.131.12.159:8008/defaultvhost/jkr_1512031219.flv?$args;
}
```
