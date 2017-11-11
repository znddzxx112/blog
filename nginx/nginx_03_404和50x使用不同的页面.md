```
vim conf/nginx
# 当/时产生的404 走404.html
location / { 
    access_log logs/default_access.log main;
    root   html;
    index  index.html index.htm;
    error_page 404 /404.html;
}

error_page   500 502 503 504  /50x.html;
location = /50x.html {
    root   html;
}  
```
