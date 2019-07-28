- http请求 - Request
```
GET /gethello?foo=bar&foo2=bar2 HTTP/1.1  ===> Request.Method Request.URL Request.Proto Request.Major Request.Minor

Host: 127.0.0.1:8889
User-Agent: Go-http-client/1.1
Cookie: cfoo=cbar ==========> Request.AddCookie()
Accept-Encoding: gzip
 ==================> Request.Header
 
 Request.ContentLength
 Request.Body
 ==============>
```

- http响应 -Response
```
HTTP/1.1 200 OK    =============> Response.Proto Response.Major Response.Minor Response.Status Response.StatusCode
Set-Cookie: wfoo=wbar; HttpOnly; Secure  =======> http.SetCookie()
Date: Sun, 28 Jul 2019 10:23:34 GMT
Content-Length: 32  ========> Response.ContentLength
Content-Type: text/plain; charset=utf-8
 ====================> Response.Header 
127.0.0.1:8889Go-http-client/1.1
=====================>Response.Body
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
设置Header参数:
	header := http.Header{}
	header.Add("VH", "0_62")
	req,_ := http.NewRequest("GET",url, nil)
	req.Header = header
获取Header参数:
	req.Header.Get("VH")
设置Cookie参数:
  cok := &http.Cookie{
		Name : "cfoo",
		Value:"cbar",
	}
  req,_ := http.NewRequest("GET",url, nil)
	req.AddCookie(cok)
获取Cookie参数:
  req.Cookie("cfoo")

设置Post参数,表单提交:
	values := url2.Values{}
	values.Add("foo", "bar")
	url := fmt.Sprintf(
		"%s://%s/posthello",
		"http", net.JoinHostPort("127.0.0.1", "8890"))
	req,_ := http.NewRequest("POST", url, strings.NewReader(values.Encode()))
	req.Header.Set(http.CanonicalHeaderKey("Content-Type"), "application/x-www-form-urlencoded")
获取Post参数:
	f req.ParseForm() == nil {
		log.Println(req.PostFormValue("foo"))
	}
设置Post参数,json提交:
	type Hellojson struct {
		Id int64 `json:id`
		Name string `json:name`
	}
	hello := Hellojson{Id:12,Name:"baike"}
	MarshalStr, _ := json.Marshal(hello)

	req,_ := http.NewRequest("POST", url, bytes.NewReader(MarshalStr))
	req.Header.Set(http.CanonicalHeaderKey("Content-Type"), "application/json")
获取Post参数:
	var buflen int64 = 4096
	if req.ContentLength > 0 {
		buflen = req.ContentLength
	}
	buf := make([]byte, buflen)
	io.ReadFull(req.Body, buf)
	hellojson := &Hellojson{}
	var UnmarshalErr error
	if UnmarshalErr = json.Unmarshal(buf, hellojson);UnmarshalErr != nil {
		io.WriteString(w, "error")
		return
	}
```

- 获取Response
```

```
