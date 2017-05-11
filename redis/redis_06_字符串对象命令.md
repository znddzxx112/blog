
#### string结构

* set
```
set mykey foo
set mykey foo EX 100 // 100秒过期
set mykey foo PX 100 // 100毫秒过期
```

* setnx
```
setnx mykey foo //不存在key则设置
```

* setex
```
setex mykey 100 bar //mykey 100秒有效时间
```

* mset
```
mset mykey1 foo1 mykey2 foo2 // 增加多个key
```

* msetnx
```
msetnx mykey3 foo3 mykey1 bar1 // key不存在时设置
```

* get
```
get mykey1
```

* getset
```
getset key value//设置值并返回设置前的值
```

* incr
```
incr mykey4 //key不存在为0，再执行原子操作加1
// 结合超时时间，实现一段时间内最高限制
// lua script
FUNCTION LIMIT_API_CALL(ip)
ts = CURRENT_UNIX_TIME()
keyname = ip+":"+ts
current = GET(keyname)
IF current != NULL AND current > 10 THEN
    ERROR "too many requests per second"
ELSE
    MULTI
        INCR(keyname,1)
        EXPIRE(keyname,10)
    EXEC
    PERFORM_API_CALL()
END
```

* incrby
```
incrby age 5 // 加上5,自定递增
```

* decr
```
decr mykey4 // 减1，可以为负数
```

* decrby
```
decrby mykey4 2 // 减2，递减
```

* strlen
```
strlen mykey1 //字节长度
set mykey1 我要
get mykey1 
\xe6\x88\x91\xe8\xa6\x81
strlen mykey1
6 //中文存储的字节数为3个
```

* append
```
append mykey1 hello//在原有字符串增加字符串hello
```

* setbit
```
192.168.204.26:6379[5]> setbit mykey 0 1
(integer) 0
192.168.204.26:6379[5]> get mykey
"\x80"
192.168.204.26:6379[5]> setbit mykey 1 1
(integer) 0
192.168.204.26:6379[5]> get mykey
"\xc0"
192.168.204.26:6379[5]> setbit mykey 2 1
(integer) 0
192.168.204.26:6379[5]> get mykey
"\xe0"
```

* getbit
```
// 取某一位的值
192.168.204.26:6379[5]> getbit mykey 11
(integer) 0
192.168.204.26:6379[5]> getbit mykey 1
(integer) 1
192.168.204.26:6379[5]> getbit mykey 0
```

* bitcount
```
// 实现一个用户登陆统计
192.168.204.26:6379[5]> setbit mykey 1 1
(integer) 0
192.168.204.26:6379[5]> bitcount mykey
(integer) 1
192.168.204.26:6379[5]> setbit mykey 2 1
(integer) 0
192.168.204.26:6379[5]> bitcount mykey
(integer) 2
192.168.204.26:6379[5]> setbit mykey 5 1
(integer) 0
192.168.204.26:6379[5]> bitcount mykey
(integer) 3
192.168.204.26:6379[5]> setbit mykey 9 1
(integer) 0
192.168.204.26:6379[5]> bitcount mykey
(integer) 4
```

* setrange
```
// 覆盖字符串一部分的内容
192.168.204.26:6379[5]> get mykey2
"foo2"
192.168.204.26:6379[5]> setrange mykey2 2 bar
(integer) 5
192.168.204.26:6379[5]> get mykey2
"fobar"
```

