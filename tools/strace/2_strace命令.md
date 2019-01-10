- 简介
```
strace可以跟踪到一个进程产生的系统调用,包括参数，返回值，执行消耗的时间。
内核调用，接受到的信号
```

- 参数
```
-p +进程id 跟踪进程
-f 跟踪的进程产生的子进程
-F 跟踪进程产生的子进程
-T 显示每一调用所耗的时间
-tt 在输出中的每一行前加上时间信息,微秒级
-o filename
将strace的输出写入文件filename
-p pid
跟踪指定的进程pid.
-e trace=all
只跟踪指定的系统 调用.例如:-e trace=open,close,rean,write表示只跟踪这四个系统调用.默认的为set=all.
-e trace=file
只跟踪有关文件操作的系统调用.
-e trace=process
只跟踪有关进程控制的系统调用.
-e trace=network
跟踪与网络有关的所有系统调用.
-e strace=signal
跟踪所有与系统信号有关的 系统调用
-e trace=ipc
跟踪所有与进程通讯有关的系统调用
```
- 比如
```
// 跟踪fpm,worker
strace -f -F -T -tt -p 12955 -o /tmp/12955.out
```
