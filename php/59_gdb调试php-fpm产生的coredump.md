 - 产生coredump
 ```
 1. 编译php时，加入参数--enable-debug
 2. 能够产生coredump php代码，比如由爆栈引起的coredump
 引起coredump原因: 解引用空指针, double free, 以及爆栈,触发SIGSEGV
 <?php
function recurse($num) {
      recurse(++$num);
}
recurse(0);
 3. 系统设置允许产生coredump
 echo '/tmp/core-%e.%p' > /proc/sys/kernel/core_pattern
ulimit -c unlimited core_dump文件大小不设限制
ulimit -c 10240
 ```
 
 - 使用gdb调试coredump
 ```
 gdb php-fpm core-php-fpm.26562
(gdb)bt
看到栈信息都是重复的，可以猜测由于循环调用引起
通过打印excute_data变量，可以知道由哪个文件哪行引起coredump
 ```
 
 - 更多的信息更多的调试工具
 ```
 (gdb) source /usr/local/php-7.0.1/.gdbinit
(gdb) zbacktrace //查看栈信息
zbacktrace
print_ht**系列
zmemcheck
 ```
 
 - gdb打印栈信息
 ```
 (gdb)f 0 //打印栈顶信息
 (gdb)f 1
 (gdb)p *execute_data->func->common->function_name.val@7 //打印执行的函数名称
 (gdb)p *execute_data->func.op_array->filename.val@27 //打印执行的文件名称
 
 ```
