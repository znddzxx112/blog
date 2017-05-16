* zadd
```
// 有序集合增加元素
// zadd ch score members
192.168.204.26:6379[5]> zadd zset ch 1 one
(integer) 1
192.168.204.26:6379[5]> zadd zset ch 2 two 3 three
(integer) 2
192.168.204.26:6379[5]> type zset
zset
```

* zcard
```
// 集合中的元素
192.168.204.26:6379[5]> zcard zset
(integer) 3
```

* zrange
```
// 有序集合中返回集合范围
// withscores 带分数
192.168.204.26:6379[5]> zrange zset 0 4 withscores
1) "one"
2) "1"
3) "two"
4) "2"
5) "three"
6) "3"
192.168.204.26:6379[5]> zrange zset 0 4
1) "one"
2) "two"
3) "three"
192.168.204.26:6379[5]> zrange zset 0 3
1) "one"
2) "two"
3) "three"
192.168.204.26:6379[5]> zrange zset 0 2
1) "one"
2) "two"
3) "three"
192.168.204.26:6379[5]> zrange zset 1 2
1) "two"
2) "three"
```

* zcount
```
// 返回有序集合在某一个分数范围内的元素个数
192.168.204.26:6379[5]> zcount zset 1 2
(integer) 2
192.168.204.26:6379[5]> zcount zset 2 2
(integer) 1
192.168.204.26:6379[5]> zcount zset 2 4
(integer) 2
```

* zincrby
```
// 增加集合内一个成员的分数
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2) 1) "one"
   2) "1"
   3) "two"
   4) "2"
   5) "three"
   6) "3"
192.168.204.26:6379[5]> zincrby zset 1 one
"2"
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2) 1) "one"
   2) "2"
   3) "two"
   4) "2"
   5) "three"
   6) "3"
```

* zrem
```
// 有序集合中删除元素
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2) 1) "one"
   2) "2"
   3) "two"
   4) "2"
   5) "three"
   6) "3"
   7) "five"
   8) "5"
192.168.204.26:6379[5]> zlexcount zset one five
(error) ERR min or max not valid string range item
192.168.204.26:6379[5]> zlexcount zset 2 5
(error) ERR min or max not valid string range item
192.168.204.26:6379[5]> zrem zset one
(integer) 1
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2) 1) "two"
   2) "2"
   3) "three"
   4) "3"
   5) "five"
   6) "5"
```

* zscore
```
// 返回元素的分数
// 也可判断元素的是否存在
192.168.204.26:6379[5]> zscore zset two
"2"
192.168.204.26:6379[5]> zscore zset six
(nil)
```

* zrank
```
// 按照分数递增排序(从低到高)，返回元素的排名，从0开始
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2)  1) "foo"
    2) "1"
    3) "two"
    4) "2"
    5) "three"
    6) "3"
    7) "bar"
    8) "4"
    9) "five"
   10) "5"
192.168.204.26:6379[5]> zrank zset two
(integer) 1
192.168.204.26:6379[5]> zrank zset bar
(integer) 3
192.168.204.26:6379[5]> zrank zset foo
(integer) 0
```

* zrevrank
```
// 按照分数递减排序（从高到低）,返回元素的排名，从0开始
192.168.204.26:6379[5]> zscan zset 0
1) "0"
2)  1) "foo"
    2) "1"
    3) "two"
    4) "2"
    5) "three"
    6) "3"
    7) "bar"
    8) "4"
    9) "five"
   10) "5"
192.168.204.26:6379[5]> zrevrank zset five
(integer) 0
192.168.204.26:6379[5]> zrevrank zset foo
(integer) 4
```
