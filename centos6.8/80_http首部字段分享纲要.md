
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
