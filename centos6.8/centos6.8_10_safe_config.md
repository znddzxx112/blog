#### centos6.8服务器配置-安全配置

##### centos

```
    root不允许ssh登录，bitcao允许通过ssh登录，其他用户不允许ssh登录
    设置用户组别 www www 
```

##### vsftp

```
    www 允许上传代码，不允许登录
```

##### mysql

```
 root 只能本地连接 yib****
 www 本地连接 www****
 bitcao 远程连接 bit***
```

##### nginx 

```
 nginx 用户运行 
 
```

##### php-fpm

```
 www:www 运行php-fpm
```

##### php代码目录
```
 www:www 设置用户和用户组
 755权限
```

##### 总结

- mysql,ssh远程登录只允许bitcao，允许切换到root
- www用户允许上传代码
- www是上传代码，程序运行，目录权限归属者
