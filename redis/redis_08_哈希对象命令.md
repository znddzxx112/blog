* hset
```
hset key field value
192.168.204.26:6379[1]> HSET myhash foo1 bar1
(integer) 1
192.168.204.26:6379[1]> hget myhash foo1
"bar1"
```

* hget
```
hget key field
192.168.204.26:6379[1]> hget myhash foo1
"bar1"
```

* hmset
```
hmset key field value ...
192.168.204.26:6379[1]> hmset myhash foo2 bar2 foo3 bar3
OK
192.168.204.26:6379[1]> hmget myhash foo1 foo2 foo3
1) "bar1"
2) "bar2"
3) "bar3"
```

* hmget
```
// 批量获取key的多个字段对应的value值
hmget key field1 field2 ...
192.168.204.26:6379[1]> hmset myhash foo2 bar2 foo3 bar3
OK
192.168.204.26:6379[1]> hmget myhash foo1 foo2 foo3
1) "bar1"
2) "bar2"
3) "bar3"
```

* hgetall
```
返回 key 指定的哈希集中所有的字段和值
192.168.204.26:6379[1]> hgetall myhash
1) "foo1"
2) "bar1"
3) "foo2"
4) "bar2"
5) "foo3"
6) "bar3"
```

* hkeys
```
返回hash集中所有的字段
192.168.204.26:6379[1]> hkeys myhash
1) "foo1"
2) "foo2"
3) "foo3"
```

* hexists
```
返回hash里面key是否存在的标志
1 哈希集中含有该字段。
0 哈希集中不含有该存在字段，或者key不存在。
192.168.204.26:6379[1]> hexists myhash foo1
(integer) 1
192.168.204.26:6379[1]> hexists myhash foo4
(integer) 0
```

* hincrby
```
// 增加 key 指定的哈希集中指定字段的数值
// 字段不存在时，先置为0
192.168.204.26:6379[1]> hincrby myhash age 1
(integer) 1
192.168.204.26:6379[1]> hincrby myhash age 1
(integer) 2
192.168.204.26:6379[1]> hincrby myhash age 1
(integer) 3
192.168.204.26:6379[1]> hget myhash age
"3"
```

* hincrbyfloat
```
// 递增浮点数
192.168.204.26:6379[1]> hincrbyfloat myhash age 0.1
"3.1"
```

* hlen
```
// hash集中的字段数量
192.168.204.26:6379[1]> hlen myhash
(integer) 4
```

* hvals
```
// 返回hash集中所有的value值
192.168.204.26:6379[1]> hvals myhash
1) "bar1"
2) "bar2"
3) "bar3"
4) "3.1"
```

* hscan
```
// 迭代hash集
192.168.204.26:6379[1]> hscan myhash 0
1) "0"
2) 1) "foo1"
   2) "bar1"
   3) "foo2"
   4) "bar2"
   5) "foo3"
   6) "bar3"
   7) "age"
   8) "3.1"
```
