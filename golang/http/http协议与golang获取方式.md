- http请求 - Request
```
GET /gethello?foo=bar&foo2=bar2 HTTP/1.1
Host: 127.0.0.1:8889
User-Agent: Go-http-client/1.1
Cookie: cfoo=cbar
Accept-Encoding: gzip

```

- http响应 -Response
```
HTTP/1.1 200 OK
Set-Cookie: wfoo=wbar; HttpOnly; Secure
Date: Sun, 28 Jul 2019 10:23:34 GMT
Content-Length: 32
Content-Type: text/plain; charset=utf-8

127.0.0.1:8889Go-http-client/1.1
```

- 获取Request
```
设置Get参数:
  values := url2.Values{}
	values.Add("foo", "bar")
	values.Add("foo2", "bar2")
	url := fmt.Sprintf(
		"%s://%s/gethello?%s",
		"http", net.JoinHostPort("127.0.0.1", "8889"), values.Encode())
从Request获取Get参数:
  if req.ParseForm() == nil {
		req.FormValue("foo")
	}
设置Cookie参数:
  cok := &http.Cookie{
		Name : "cfoo",
		Value:"cbar",
	}
  req,_ := http.NewRequest("GET",url, nil)
	req.AddCookie(cok)
获取Cookie参数:
  req.Cookie("cfoo")
```

- 获取Response
```

```
