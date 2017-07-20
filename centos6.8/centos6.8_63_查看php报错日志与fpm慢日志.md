- php 报错日志查看
```
php --ini 查看配置文件
在配置文件中搜索 error_log=/data/php_errors.log
```
- fpm慢日志记录查看方法 
```
ps aux | grep fpm 查看配置文件,往往在/usr/local/php7/etc/php-fpm.d/
在配置文件搜索 slowlog=/data/logs/slow.log
```
