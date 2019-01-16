- https://www.cnblogs.com/chenpingzhao/p/4813078.html

```

要添加：fastcgi_intercept_errors on  或者  proxy_intercept_errors

    默认: fastcgi_intercept_errors off
    添加位置: http, server, location
    默认情况下，nginx不支持自定义404错误页面，只有这个指令被设置为on，nginx才支持将404错误重定向

```
