- 参考文章：http://www.ha97.com/5095.html

- 系统吞吐度
```
系统吞吐量几个重要参数：QPS（TPS）、并发数、响应时间
QPS（TPS）：每秒钟request/事务 数量

并发数： 系统同时处理的request/事务数

响应时间：  一般取平均响应时间

QPS（TPS）= 并发数/平均响应时间

```

- 并发理解
```
 并发含义：每秒需要承受多少业务，多少个独立用户访问
```

```
一个系统吞吐量通常由QPS（TPS）、并发数两个因素决定，每套系统这两个值都有一个相对极限值，在应用场景访问压力下，只要某一项达到系统最高值，系统的吞吐量就上不去了，如果压力继续增大，系统的吞吐量反而会下降，原因是系统超负荷工作，上下文切换、内存等等其它消耗导致系统性能下降。
```

- 系统吞吐量评估
```
而通常境况下，我们面对需求，我们评估出来的出来QPS、并发数之外，还有另外一个维度：日PV。

通过观察系统的访问日志发现，在用户量很大的情况下，各个时间周期内的同一时间段的访问流量几乎一样。比如工作日的每天早上。只要能拿到日流量图和QPS我们就可以推算日流量。

通常的技术方法：
 1. 找出系统的最高TPS和日PV，这两个要素有相对比较稳定的关系（除了放假、季节性因素影响之外）

        2. 通过压力测试或者经验预估，得出最高TPS，然后跟进1的关系，计算出系统最高的日吞吐量。B2B中文和淘宝面对的客户群不一样，这两个客户群的网络行为不应用，他们之间的TPS和PV关系比例也不一样。
```

- 一次优化实例
- ab压测实例
```
Server Software:        nginx/1.0.2
Server Port:            80

Document Path:          
Document Length:        2933 bytes

Concurrency Level:      1000
Time taken for tests:   20.772584 seconds
Complete requests:      2000
Failed requests:        0
Write errors:           0
Total transferred:      6460000 bytes
HTML transferred:       5866000 bytes
Requests per second:    96.28 [#/sec] (mean)
Time per request:       10386.292 [ms] (mean)
Time per request:       10.386 [ms] (mean, across all concurrent requests)
Transfer rate:          303.67 [Kbytes/sec] received
```
- 结果分析
```
非常慢，并发只有100，远远达不到业务方要求。
```
- 优化之后压测结果
```
Server Software:        nginx/1.0.2
Server Port:            80

Document Path:          
Document Length:        2917 bytes

Concurrency Level:      1000
Time taken for tests:   2.516259 seconds
Complete requests:      2000
Failed requests:        4
   (Connect: 0, Length: 4, Exceptions: 0)
Write errors:           0
Total transferred:      6416716 bytes
HTML transferred:       5822716 bytes
Requests per second:    794.83 [#/sec] (mean)
Time per request:       1258.130 [ms] (mean)
Time per request:       1.258 [ms] (mean, across all concurrent requests)
Transfer rate:          2490.20 [Kbytes/sec] received
```
- 结果分析
```
优化结果非常明显，结合xhprof的分析，瓶颈在io操作
操作频繁，通过代码业务逻辑的调整，降低io操作。
总结：想要明显的性能提升，瓶颈往往在io，解决io瓶颈往往需要对业务代码的调整，收益最明显。
```



