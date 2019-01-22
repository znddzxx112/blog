
- 命令行方式
```
php -f file.php
php -r "echo time();"
```

- 命令解释器方式
```
# vim test
#! /usr/local/bin/php
<?php
    echo time();
?>

# chmod 755 test
# ./test

```

- 参数解释
```
-s 显示有语法色彩的文件，可用于网页展示
-w 显示除去和空格，可用于压缩
-f 运行指定文件的php
-v 查看版本
-c 指定php.ini的目录或者php.ini文件
-a 交互运行php
-m 打印内置以及已加载的php或者zend模块
-i 执行phpinfo();
-S 启动内置web server
/usr/local/bin/php -S 0.0.0.0:80 -t /var/www
-t 指定目录
--ini 显示配置文件名，与-c对应
--rf 查看函数信息
--rc 查看类信息
--re 查看扩展信息
--rz 查看zend扩展信息
--ri 查看扩展配置
模块配置可以在php.ini设置

-e
-a
-B
-E
-H
```
