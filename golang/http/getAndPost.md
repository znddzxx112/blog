- server
```
func TestHttpServer(t *testing.T) {
// parse get
	handle.HandleFunc("/main/home/index/", func(writer http.ResponseWriter, request *http.Request) {
		urlValues := request.URL.Query()
		foo := urlValues.Get("foo")
		if len(foo) > 0 {
			writer.WriteHeader(200)
			writer.Write([]byte("return" + foo))
		}
	})

	// http postForm and post
	handle.HandleFunc("/main/home/getList/", func(writer http.ResponseWriter, request *http.Request) {
		err := request.ParseForm()
		if err != nil {
			writer.WriteHeader(500)
		}
		foo1 := request.PostForm.Get("foo1")
		foo2 := request.PostForm.Get("foo2")
		foo3 := request.Form.Get("foo1")
		foo4 := request.Form.Get("foo2")
		writer.WriteHeader(200)
		writer.Write([]byte(foo1 + foo2 + foo3 + foo4))
	})

server := &http.Server{
		Addr:         ":8088",
		Handler:      handle,
		ReadTimeout:  time.Second * 2,
		WriteTimeout: time.Second * 2,
	}
	sErr := server.ListenAndServe()
	defer server.Close()
	if sErr != nil {
		t.Errorf("%q", sErr)
	}
}
```

- client get and post
```
// http Get
func TestHttpGet(t *testing.T) {
	resp, err := http.Get("http://127.0.0.1:8088/main/home/index/?foo=hello")
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()

	allBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		t.Errorf("%q", err)
	}

	t.Logf("%s", string(allBytes))
}

// client Get
func TestHttpClientGet(t *testing.T) {
	client := http.Client{}
	resp, err := client.Get("http://127.0.0.1:8088/main/home/index/?foo=hello")
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()

	allBytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		t.Errorf("%q", err)
	}

	t.Logf("%s", string(allBytes))
}

// http client do
func TestHttpClientDoGet(t *testing.T) {
	request, err := http.NewRequest(
		"GET",
		"http://127.0.0.1:8088/main/home/index/?foo=hello",
		nil)
	if err != nil {
		t.Errorf("%q", err)
	}
	client := http.Client{}
	resp, err := client.Do(request)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())
}

// http postform
func TestHttpPostform(t *testing.T) {
	data := url.Values{
		"foo1": []string{"bar1"},
		"foo2": []string{"bar2"},
	}
	resp, err := http.PostForm("http://127.0.0.1:8088/main/home/getList/", data)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())
}

// http post
func TestHttpPost(t *testing.T) {
	resp, err := http.Post("http://127.0.0.1:8088/main/home/getList/",
		"application/x-www-form-urlencoded",
		strings.NewReader("foo1=bar1&foo2=bar2"))
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())

}

// http client do post
func TestHttpClientDoPost(t *testing.T) {
	request, err := http.NewRequest("POST",
		"http://127.0.0.1:8088/main/home/getList/",
		strings.NewReader("foo1=bar1&foo2=bar2"))

	request.Header.Set("Content-Type", "application/x-www-form-urlencoded")
	request.Header.Set("Connection", "Keep-Alive")
	if err != nil {
		t.Errorf("%q", err)
	}
	client := http.Client{}
	resp, err := client.Do(request)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())
}

// dohttp Get
func TestDoHttpGet(t *testing.T) {
	data := url.Values{
		"foo":  []string{"bar"},
		"foo2": []string{"bar2"},
	}
	resp, err := doHttp("GET", "http://127.0.0.1:8088/main/home/index/", data)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())
}

// dohttp Post
func TestDoHttpPost(t *testing.T) {
	data := url.Values{
		"foo1": []string{"bar1"},
		"foo2": []string{"bar2"},
	}
	resp, err := doHttp("post", "http://127.0.0.1:8088/main/home/getList/", data)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)
	t.Logf(b.String())
}

// http get post form
func doHttp(method string, url string, values url.Values) (*http.Response, error) {
	var request *http.Request
	var err error

	method = strings.ToUpper(method)
	if method == "GET" {
		url = fmt.Sprintf("%s?%s", url, values.Encode())
		request, err = http.NewRequest("GET", url, nil)
	} else if method == "POST" {
		request, err = http.NewRequest("POST", url, strings.NewReader(values.Encode()))
		request.Header.Set("Content-Type", "application/x-www-form-urlencoded")
	} else {
		err = errors.New("method not found")
	}

	if err != nil {
		return nil, err
	}
	client := http.Client{}
	return client.Do(request)
}


```
