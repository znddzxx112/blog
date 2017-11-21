 > http首部字段
 
```
请求报文中
Cookie: xxx=xxx; xxx=xxx;

过程：浏览器根据host把请求相同域的cookie发给服务器

响应报文

Set-Cookie: xxx=xxx; xxx=xxx;
```

> php使用函数
```
// name value expires(时间点) path domain
setcookie("foo", "bar", -1, "/", ".test.com");
setcookie("foo1", "bar1", time() + 30, "/", ".test.com")
```
