 - pstree简介
 ```
 显示一个进程的子进程，父进程
 显示一个用户启动的进程
 ```
 
 - 参数
 ```
 pstree -h // 当前用户的父进程
 pstree -aH 进程号 显示一个进程的父进程
 pstree -p 进程号 显示一个进程的子进程
 ```
 
 - pidof简介
 ```
 找出正在运行程序的进程PID
 ```
 
 ```
 pidof php-fpm // 找出所有program为php-fpm的进程号
 ```
 
 
