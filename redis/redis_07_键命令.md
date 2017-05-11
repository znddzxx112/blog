
* keys
```
时间复杂度为O(N)，N为数据库里面key的数量。
例如，Redis在一个有1百万个key的数据库里面执行一次查询需要的时间是40毫秒 。
192.168.204.26:6379[5]> keys mykey[0-1]
1) "mykey1"
192.168.204.26:6379[5]> keys mykey[0-2]
1) "mykey1"
2) "mykey2"
192.168.204.26:6379[5]> keys mykey[0-9]
1) "mykey1"
2) "mykey3"
3) "mykey2"
4) "mykey4"
支持的正则表达模式：
h?llo 匹配 hello, hallo 和 hxllo
h*llo 匹配 hllo 和 heeeello
h[ae]llo 匹配 hello 和 hallo, 但是不匹配 hillo
h[^e]llo 匹配 hallo, hbllo, … 但是不匹配 hello
h[a-b]llo 匹配 hallo 和 hbllo
```

* scan
```
// 当库中的键值过多，使用scan游标的方式遍历keys
// 从完整遍历开始直到完整遍历结束期间， 一直存在于数据集内的所有元素都会被完整遍历返回； 这意味着， 如果有一个元素， 它从遍历开始直到遍历结束期间都存在于被遍历的数据集当中， 那么 SCAN 命令总会在某次迭代中将这个元素返回给用户。
同样，如果一个元素在开始遍历之前被移出集合，并且在遍历开始直到遍历结束期间都没有再加入，那么在遍历返回的元素集中就不会出现该元素。
192.168.204.26:6379[1]> scan 640
1) "576"
2)  1) "workbenchAssist_167862560"
    2) "workbenchAssist_184083092"
    3) "workbenchAssist_57543061"
    4) "workbenchAssist_80414184"
    5) "workbenchAssist_167091450"
    6) "workbenchAssist_170946106"
    7) "workbenchAssist_181173906"
    8) "workbenchAssist_185945405"
    9) "workbenchAssist_124013840"
   10) "workbenchAssist_181234007"
   11) "workbenchAssist_182581368"
192.168.204.26:6379[1]> scan 576
1) "2240"
2)  1) "workbenchAssist_176812894"
    2) "workbenchAssist_28545185"
    3) "workbenchAssist_163708222"
    4) "workbenchAssist_138143395"
    5) "workbenchAssist_7716595"
    6) "workbenchAssist_183717915"
    7) "workbenchAssist_144396669"
    8) "workbenchAssist_189889043"
    9) "workbenchAssist_182011584"
   10) "workbenchAssist_172015544"
```

* exists
```
192.168.204.26:6379[5]> exists mykey5
(integer) 0
192.168.204.26:6379[5]> exists mykey1
(integer) 1
0 不存在 1存在
```
* del
```
192.168.204.26:6379[5]> del mykey1
(integer) 1
```
* expire key 10
```
key 设置过期时间
192.168.204.26:6379[5]> expire mykey2 200
(integer) 1
192.168.204.26:6379[5]> ttl mykey2
(integer) 196
192.168.204.26:6379[5]> expire mykey2 200
(integer) 1
192.168.204.26:6379[5]> ttl mykey2
(integer) 199
可以用来刷新过期时间
```

* move key db1
```
将key移至其他db
192.168.204.26:6379[5]> move mykey2 6
(integer) 1
192.168.204.26:6379[5]> select 6
OK
192.168.204.26:6379[6]> ttl mykey2
(integer) 83
```

* ttl/pttl
```
192.168.204.26:6379[5]> ttl mykey1
(integer) -2
192.168.204.26:6379[5]> ttl mykey2
(integer) -1
192.168.204.26:6379[5]> ttl mykey3
(integer) -1
192.168.204.26:6379[5]> set mykey4 foo4 EX 100
OK
192.168.204.26:6379[5]> ttl mykey4
(integer) 95
如果key不存在或者已过期，返回 -2
如果key没有设置过期时间（永久有效），返回 -1 
单位为秒数
```

* persist
```
移除过期时间，让key键变成永久
192.168.204.26:6379[5]> persist mykey2
(integer) 1
192.168.204.26:6379[5]> get mykey2
"fobar"
192.168.204.26:6379[5]> ttl mykey2
(integer) -1
```

* randomkey
```
返回随机key
192.168.204.26:6379[5]> randomkey
"mykey"
192.168.204.26:6379[5]> randomkey
"mykey3"
```

* rename/renamenx
```
rename key newkey //重命名key
renamenx key newkey //newkey必须不存在
192.168.204.26:6379[5]> ttl mykey3
(integer) -1
192.168.204.26:6379[5]> rename mykey3 mykey30
OK
192.168.204.26:6379[5]> ttl mykey30
(integer) -1
```

* type key
```
返回值的类型
192.168.204.26:6379[5]> type mykey30
string
```

* expireat/pexpireat
```
// 某一个时间点过期
192.168.204.26:6379[5]> expireat mykey30 1494706434
(integer) 1
192.168.204.26:6379[5]> ttl mykey30
(integer) 203267
192.168.204.26:637
```
