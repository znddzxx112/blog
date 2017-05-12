* lpush
```
// 从列表头部插入,插入成功返回list总个数
192.168.204.26:6379[5]> lpush mylist foo
(integer) 2
192.168.204.26:6379[5]> lpush mylist bar
(integer) 3
192.168.204.26:6379[5]> lpush mylist foo2 foo3
(integer) 5
```

- lpushx
```
// 当队列存在的时候，推入元素
```

* llen
```
// 返回list长度
192.168.204.26:6379[5]> llen mylist
(integer) 3
```

* lindex
```
// lpush最新一个元素，永远是lindex为0
192.168.204.26:6379[5]> lindex mylist 1
"foo2"
192.168.204.26:6379[5]> lindex mylist 2
"bar"
192.168.204.26:6379[5]> lindex mylist 3
"foo"
192.168.204.26:6379[5]> lindex mylist 4
"hellolist"
192.168.204.26:6379[5]> lindex mylist 5
(nil)
192.168.204.26:6379[5]> lindex mylist 0
"foo3"
```

* lrange
```
// 返回队列一定范围的元素
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "foo3"
2) "foo2"
3) "bar"
4) "foo"
5) "hellolist"
192.168.204.26:6379[5]> lrange mylist 0 -2
1) "foo3"
2) "foo2"
3) "bar"
4) "foo"
```

* lset
```
// 修改队列中指定位置的元素
192.168.204.26:6379[5]> lrange mylist 0 -2
1) "foo3"
2) "foo2"
3) "bar"
4) "foo"
192.168.204.26:6379[5]> lset mylist 0 foo0
OK
192.168.204.26:6379[5]> lrange mylist 0 -2
1) "foo0"
2) "foo2"
3) "bar"
4) "foo"
```

* lrem
```
// lrem key count value
count > 0: 从头往尾移除值为 value 的元素。
count < 0: 从尾往头移除值为 value 的元素。
count = 0: 移除所有值为 value 的元素
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "foo0"
2) "foo2"
3) "bar"
4) "foo"
5) "hellolist"
192.168.204.26:6379[5]> lrem mylist 0 foo
(integer) 1
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "foo0"
2) "foo2"
3) "bar"
4) "hellolist"
192.168.204.26:6379[5]> 
```

* ltrim
```
// ltrim list start stop
// 保留list从start到stop的元素
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "foo0"
2) "foo2"
3) "bar"
4) "hellolist"
192.168.204.26:6379[5]> ltrim mylist 2 3
OK
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "bar"
2) "hellolist"
```

* lpop / rpop
```
// lpop从头部出一个元素
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "bar"
2) "hellolist"
192.168.204.26:6379[5]> lpop mylist
"bar"
192.168.204.26:6379[5]> lrange mylist 0 -1
1) "hellolist"
```

* blpop / brpop
```
// 阻塞的方式从list中获取元素
192.168.204.26:6379[5]> blpop mylist 100
1) "mylist"
2) "foo1"
(5.92s)
192.168.204.26:6379[5]> blpop mylist 1
(nil)
```
