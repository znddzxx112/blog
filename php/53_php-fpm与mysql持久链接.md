- 参考文章
```
https://segmentfault.com/q/1010000003958136/a-1020000003958367
https://github.com/pangudashu/php7-internal/blob/master/1/base_process.md
```

- fpm执行流程
```
新建一个工作进程（子进程）
1. 模块初始化
while(1) {
  2. 请求初始化
  3. 执行请求
  4. 请求关闭
}
5. 模块关闭

当出现持久化链接时，工作进程会维护一个全局持久化符号表
```

```
如果是短连接：则是一个请求对应一个连接
如果是持久连接：一个工作进程对应一个mysql持久连接，使用前要判断持久链接是否存在
```

- 注意点
```
数据库mysql最大连接数：show variables like 'max_conn%'
 max_connections    | 151
php-fpm 的 pm.max_children = 10 不能超过mysql:max_connections
```

