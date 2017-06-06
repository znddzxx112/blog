- yield 仅仅在函数中被使用
- 参考：http://php.net/manual/zh/class.generator.php
- 函数中 yield 值 => 返回一个生成器，可用current()获取
- yield key => val 返回一个生成器，key()和current()获取
- yield; 等待外部输入 send()就可送值
```
 3 function gen() {
  4         yield "hello";
  5         yield "bar";
  6         yield "foo" => "val";
  7         $res = yield;
  8         var_dump($res);
  9 }       
 10 
 11 
 12 $gen = gen();
 13 var_dump($gen->current());
 14 var_dump($gen->valid());
 15 var_dump($gen->next());
 16 var_dump($gen->current());
 17 var_dump($gen->valid());
 18 $gen->next();
 19 var_dump($gen->key());
 20 var_dump($gen->current());
 21 var_dump($gen->valid());
 22 $gen->next();
 23 var_dump($gen->current());
 24 var_dump($gen->valid());
 25 var_dump($gen->send("foo3"));
 ```
 
 ```
 // 迭代器放到foreach中的本质运行流程
 foreach($gen as $k => $val) {
    // $k = key()
    // $val = current()
    
    
    if ($gen->valid()) {
        $gen->next();
    }
 }
 ```
 
