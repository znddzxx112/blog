 - 参考文章
 ```
 http://www.laruence.com/2015/05/28/3038.html
 ```
 
 ```
 yield 相当于go的channel作用
 yield $num 往管道数据塞数据
 yield 从管道中取数据
 ```
 
 ```
 
 function gen()
 {
     
     $num = yield;
 }
 
 $gen = gen();
 此时 function gen()就是一个协程通道
 
 
 ```
