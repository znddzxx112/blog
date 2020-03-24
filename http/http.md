[TOC]



#### http字段


- 参考文章: http://www.ietf.org/rfc/rfc2616.txt

> php对于缓存头部和mime类型操作 
```
If-Modified-Since:

HTTP/1.1 304 Not Modified
Cache-Control:max-age=600 10分钟有效
Last-Modified:

header('Content-Type: application/pdf')
header('Content-Type: text/html; charset=utf-8')
```

```
http历史 0.9 1.0 1.1 - rfc2616
请求和响应报文，请求行，首部字段，实体
请求方法
rfc2616定义:首部字段,分类：通用首部字段，请求首部字段，响应首部字段，实体首部字段
通用首部字段
Cache-Control
Date
Connection
Via
Upgrade,websocket
请求首部字段
     内容相关
Accept 【可处理类型】
Accept-Charset,Accept-Encoding,Accept-Language【服务器决定】【优先处理】
Expect
Host
if-Modified-Since
Range
User-Agent
响应首部字段
Location
Age:资源创建经过时间
实体首部字段
Content-Encoding
Content-Language
Content-Type
Content-Length
Content-MD5
Content-Range
Expires:实体过期时间
Last-Modified:资源最后修改时间
RFC4299:
Cookie
Set-Cookie
Content-Disposition

Cookie字段：无状态协议
MIME，资源类型 ，Content-Range:Range大文件分段请求 状态码206

返回报文状态码 200，301(Moved Permanently)，302，304，400，403，404，500，502 
- rfc2616,rfc4918,rfc5842,rfc6585
传输速率 gzip，降低传输量，增加cpu压力

```



#### base64编码以及在url中使用

- 参考文章
```
http://blog.xiayf.cn/2016/01/24/base64-encoding/
```

- base64编码原理
```
http://blog.xiayf.cn/2016/01/24/base64-encoding/
解决问题：中文，特殊字符，不可见字符在网络中传输会出错。
使用base64编后，转化成==结尾的字符串,比如:Zm9vPWJhcg==

使用的字符包括大小写字母各26个，加上10个数字，和加号“+”，斜杠“/”，一共64个字符，等号“=”用来作为后缀用途。
将中文编码成以==结尾的字符串
```

- url编码
```
作用: 字符串中存在=,在url传输中会出错，所以需要url编码 = 转化为 %3D
```

- 中文在网络中传输正确姿势
```
先base64_encode,在urlencode
解决中文在url的传输问题
```



#### https使用交互流程


- 参考文章
```
https://www.cnblogs.com/softidea/p/4949589.html
```

- 流程概述
```
客户端通过非对称加密方式将之后用于对称数据的密钥发给服务器。
原因：
非对称加密耗费的计算大于对称加密,每次都使用非对称加密性能影响太大，对称加密耗费资源少，但要更要考虑安全。二者结合优势互补。
```

- 交互流程
```
1. 客户端发送hello给服务器
2. 服务器发公钥给客户端
3. 客户端判断公钥是否有效
    向CA第三方认证机构判断
4. 客户端生成用于对称加密的随机数
5. 客户端用公钥加密随机数，发送给服务端
6. 服务端用私钥解密获取随机数
7. 服务端使用随机数对称加密数据返回给客户端
8. 客户端使用随机数对称解密数据，正确解密说明完成
9. 客户端开始用随机数加密业务数据
...
```

- https原理
```
在http与tcp层中间加了一个ssl层
```

- 公司使用https
```
1. 使用openssl生成公私钥
2. 结合公钥，服务器信息，生成csr文件
3. csr发给第三方CA机构，并缴费
4. 在nginx配置https
```
