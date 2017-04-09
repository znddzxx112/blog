- kill -l
```
kill 的所有信号，常用
kill -1 SIGHUP
kill -9 
kill -15
```

- kill -9 1833
```
向进程1833发送信号，关闭程序
```

- kill -usr2 pid
```
重启
```

- 进程
```
用户触发的命令，进程权限就是用户的权限
每一次访问nginx
nginx用户www，所以进程权限等于www
```

- 服务
```
常驻内存的程序
```
