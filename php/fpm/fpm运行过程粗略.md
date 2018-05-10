- 概述
```
参考文章：https://github.com/pangudashu/php7-internal/blob/master/1/fpm.md
结合自己gdb调试过程
php-7.0.1
```

- fpm运行过程粗略
```
main函数进入
1. 初始化php的ini
2. 初始化php的扩展
3. 加载fpm的配置
4. master进程死循环，维护外部信号，记录worker进程的计分板
5. 产生worker进程，处理一个个请求
产生一个request结构体，获取fastcgi参数列表
知道需要执行的php文件
调用php_execute_script(需要执行的php文件句柄)
6. php_execute_script函数中,调用函数zend_execute_scripts，判断有无opcache,
调用 zend_compile_file生成opcache，
然后判断产生opcache是否要放到共享内存中cache_script_in_shared_memory,
调用函数zend_execute(op_array, retval)执行opcache
```
