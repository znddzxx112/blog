* multi
* exec
```
// 事务让多个命令变成一个原子操作
// multi 开启一个事务
// exec执行事务
192.168.204.26:6379[5]> multi
OK
192.168.204.26:6379[5]> ping
QUEUED
192.168.204.26:6379[5]> zscan zset 0
QUEUED
192.168.204.26:6379[5]> zadd zset ch 7 seven
QUEUED
192.168.204.26:6379[5]> zscan zset 0
QUEUED
192.168.204.26:6379[5]> exec
1) PONG
2) 1) "0"
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
3) (integer) 1
4) 1) "0"
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
      11) "seven"
      12) "7"
```

* discard
```
// 放弃事务
192.168.204.26:6379[5]> multi
OK
192.168.204.26:6379[5]> ping
QUEUED
192.168.204.26:6379[5]> discard
OK
192.168.204.26:6379[5]> exec
(error) ERR EXEC without MULTI
```

* watch
```
// 执行事务前，监视某一个key
// 当事务exec前，监视的key有变动，exec会不成功
192.168.204.26:6379[5]> watch zset
OK
192.168.204.26:6379[5]> multi
OK
192.168.204.26:6379[5]> zscan zset 0
QUEUED
// 执行了操作，导致key zadd zset ch 8 eight
192.168.204.26:6379[5]> exec
(nil)
192.168.204.26:6379[5]> watch zset
OK
192.168.204.26:6379[5]> multi
OK
192.168.204.26:6379[5]> zscan zset 0
QUEUED
192.168.204.26:6379[5]> exec
1) 1) "0"
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
      11) "seven"
      12) "7"
      13) "eight"
      14) "8"
```
