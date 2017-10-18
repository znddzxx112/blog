> redis-cli 批量执行命令 

```
cat cmd.txt | reids-cli -h 主机 -p 端口 -a 密码
```

> -d 参数,指定输出的分隔符, --raw 设置输出样式
```
/usr/local/bin/redis-cli -h 主机 -p 端口 -a 密码 -x -d \; --raw
```

> --csv 输出以csv格式
```
/usr/local/bin/redis-cli -h 主机 -p 端口 -a 密码 --csv
```

> --scan 键值迭代
```
/usr/local/bin/redis-cli -h 主机 -p 端口 -a 密码 --scan
```
