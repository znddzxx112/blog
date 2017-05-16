* sadd
```
// 集合中增加元素,相同的元素只有一个
192.168.204.26:6379[5]> sadd myset foo
(integer) 1
192.168.204.26:6379[5]> sadd myset foo1 foo
(integer) 1
192.168.204.26:6379[5]> scard myset
(integer) 2
```

* scard
```
// 计算集合中元素个数
192.168.204.26:6379[5]> sadd myset foo
(integer) 1
192.168.204.26:6379[5]> sadd myset foo1 foo
(integer) 1
192.168.204.26:6379[5]> scard myset
(integer) 2
```

* smembers
```
// 获取集合中所有的元素
192.168.204.26:6379[5]> smembers myset
1) "foo"
2) "foo1"
```

* sismember
```
// 判断集合中是否存在该元素
// 如果member元素是集合key的成员，则返回1
/ 如果member元素不是key的成员，或者集合key不存在，则返回0
举例
192.168.204.26:6379[5]> SMEMBERS myset
1) "foo"
2) "foo1"
192.168.204.26:6379[5]> sismember myset foo
(integer) 1
192.168.204.26:6379[5]> sismember myset foo2
(integer) 0
192.168.204.26:6379[5]> 
```

* sscan
```
// 迭代集合中的元素，并且可以指定每次迭代的次数
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo"
   2) "foo1"
192.168.204.26:6379[5]> sscan myset 0 count 1
1) "2"
2) 1) "foo"
192.168.204.26:6379[5]> sscan myset 2 count 1
1) "3"
2) 1) "foo1"
192.168.204.26:6379[5]> sscan myset 3 count 1
1) "0"
2) (empty list or set)
```

* srem
```
// 集合中删除元素
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo"
   2) "foo1"
192.168.204.26:6379[5]> srem myset foo
(integer) 1
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
```

* spop
```
// 从集合中获取元素并删除该元素
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
192.168.204.26:6379[5]> spop myset
"foo1"
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) (empty list or set)
```

* srandmember
```
// 从集合中随机返回元素
192.168.204.26:6379[5]> sadd myset foo1 foo2 foo3 foo4 foo5
(integer) 5
192.168.204.26:6379[5]> srandmember myset
"foo3"
192.168.204.26:6379[5]> srandmember myset
"foo2"
192.168.204.26:6379[5]> srandmember myset
"foo1"
192.168.204.26:6379[5]> srandmember myset
"foo4"
192.168.204.26:6379[5]> srandmember myset
"foo4"
192.168.204.26:6379[5]> srandmember myset
"foo2"
```

* smove
```
// 把一个集合的元素移动到另一个集合中
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo2"
   2) "foo1"
   3) "foo4"
   4) "foo3"
   5) "foo5"
192.168.204.26:6379[5]> sscan myset1 0
1) "0"
2) 1) "foo1"
192.168.204.26:6379[5]> smove myset myset1 foo2
(integer) 1
192.168.204.26:6379[5]> sscan myset1 0
1) "0"
2) 1) "foo2"
   2) "foo1"
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
   2) "foo4"
   3) "foo3"
   4) "foo5"
```

* sinter / sinterstore(结果存入新值)
```
// 二个集合的交集
192.168.204.26:6379[5]> sscan myset1 0
1) "0"
2) 1) "foo2"
   2) "foo1"
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
   2) "foo4"
   3) "foo3"
   4) "foo5"
192.168.204.26:6379[5]> sinter myset myset1
1) "foo1"
```

* sdiff / sdiffstore
```
// 集合的差集，一个集合减去另一个集合剩下的元素
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
   2) "foo4"
   3) "foo3"
   4) "foo5"
192.168.204.26:6379[5]> sinter myset myset1
1) "foo1"
192.168.204.26:6379[5]> sdiff myset myset1
1) "foo4"
2) "foo5"
3) "foo3"
192.168.204.26:6379[5]> sdiff myset1 myset
1) "foo2"
```

* sunion / sunionstore
```
// 多个集合的并集
192.168.204.26:6379[5]> sscan myset 0
1) "0"
2) 1) "foo1"
   2) "foo4"
   3) "foo3"
   4) "foo5"
192.168.204.26:6379[5]> sscan myset1 0
1) "0"
2) 1) "foo2"
   2) "foo1"
192.168.204.26:6379[5]> sunion myset myset1
1) "foo5"
2) "foo3"
3) "foo2"
4) "foo1"
5) "foo4"
```
