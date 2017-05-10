
##### 连接redis

```
# redis-cli -h 127.0.0.1 -p 6379
127.0.0.1:6379>
```

##### redis-cli参数
```
Usage: redis-cli [OPTIONS] [cmd [arg [arg ...]]]
// 如执行二次 redis-cli -h 192.168.204.26 -p 6379 -a 10jqka@123 -r 2 ping
  -h <hostname>      Server hostname (default: 127.0.0.1).
  -p <port>          Server port (default: 6379).
  -s <socket>        Server socket (overrides hostname and port).
  -a <password>      Password to use when connecting to the server.
  -r <repeat>        Execute specified command N times. 重复指定执行命令N次
  -i <interval>      When -r is used, waits <interval> seconds per command. 使用r时，按命令>间隔>秒。
                     It is possible to specify sub-second times like -i 0.1.
  -n <db>            Database number. // 指定数据库
  -x                 Read last argument from STDIN. //从标准输入中执行命令
  -d <delimiter>     Multi-bulk delimiter in for raw formatting (default: \n).// 命令结束符默认\n
  -c                 Enable cluster mode (follow -ASK and -MOVED redirections).
  --raw              Use raw formatting for replies (default when STDOUT is
                     not a tty).
  --no-raw           Force formatted output even when STDOUT is not a tty.
  --csv              Output in CSV format.
  --stat             Print rolling stats about server: mem, clients, ...
  --latency          Enter a special mode continuously sampling latency.
  --latency-history  Like --latency but tracking latency changes over time.
                     Default time interval is 15 sec. Change it using -i.
  --latency-dist     Shows latency as a spectrum, requires xterm 256 colors.
                     Default time interval is 1 sec. Change it using -i.
  --lru-test <keys>  Simulate a cache workload with an 80-20 distribution.
  --slave            Simulate a slave showing commands received from the master.
  --rdb <filename>   Transfer an RDB dump from remote server to local file.
  --pipe             Transfer raw Redis protocol from stdin to server.
  --pipe-timeout <n> In --pipe mode, abort with error if after sending all data.
                     no reply is received within <n> seconds.
                     Default timeout: 30. Use 0 to wait forever.
  --bigkeys          Sample Redis keys looking for big keys.
  --scan             List all keys using the SCAN command.
  --pattern <pat>    Useful with --scan to specify a SCAN pattern.
  --intrinsic-latency <sec> Run a test to measure intrinsic system latency.
                     The test will run for the specified amount of seconds.
  --eval <file>      Send an EVAL command using the Lua script at <file>.
  --ldb              Used with --eval enable the Redis Lua debugger.
  --ldb-sync-mode    Like --ldb but uses the synchronous Lua debugger, in
                     this mode the server is blocked and script changes are
                     are not rolled back from the server memory.
  --help             Output this help and exit.
  --version          Output version and exit.
```

##### 关闭连接
```
127.0.0.1:6379>quit
```
##### ping服务器
```
* ping
```

##### 验证服务器命令
```
192.168.204.26:6379> auth 10wqer23
```

#####  选择数据库
```
// 选择数据库 0~15
192.168.204.26:6379> select 1
OK
192.168.204.26:6379[1]> 
```

##### 回显字符串
```
192.168.204.26:6379[1]> echo helloredis
```

##### 关闭redis
```
127.0.0.1:6379>shutdown
```
