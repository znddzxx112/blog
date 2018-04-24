```
管道是执行批量命令，一次返回返回结果，不具有原子性
事务将多个操作当成一个事务执行
```
```
<?php  
$redis = new Redis();  
$redis->connect('127.0.0.1', 6379);  
$pipe = $redis->multi(Redis::PIPELINE);  
for ($i = 0; $i < 3; $i++) {  
    $key = "key::{$i}";  
    print_r($pipe->set($key, str_pad($i, 2, '0', 0)));  
    echo PHP_EOL;  
    print_r($pipe->get($key));  
    echo PHP_EOL;  
}  
$result = $pipe->exec();  
print_r($result); 
```
```
Redis::MULTI或Redis::PIPELINE. 默认是 Redis::MULTI
Redis::MULTI：将多个操作当成一个事务执行
Redis::PIPELINE:让（多条）执行命令简单的，更加快速的发送给服务器，但是没有任何原子性的保证
```
