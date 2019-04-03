- server
```
// http post json
  handle := http.NewServeMux()
	handle.HandleFunc("/postList/", func(writer http.ResponseWriter, request *http.Request) {
		err := request.ParseForm()
		if err != nil {
			writer.WriteHeader(500)
		}
		foo1 := request.PostForm.Get("foo1")

		postList := []Post{
			{
				Id:     1,
				Title:  foo1,
				Userid: 173408538,
				Desc:   "first desc",
			},
			{
				Id:     2,
				Title:  "second post",
				Userid: 173408539,
				Desc:   "second desc",
			},
		}
		result := Result{
			Code: 0,
			Msg:  "success",
		}
		postListResult := PostListResult{
			result,
			postList,
		}
		writer.WriteHeader(200)
		bytes, err := json.Marshal(postListResult)
		if err != nil {
			writer.Header().Set("Content-Type", "text/plain")
			writer.Write([]byte(err.Error()))
			return
		}
		writer.Header().Set("Content-Type", "application/json")
		writer.Write(bytes)
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
```

- client 
```
// http post json
func TestHttpPostJson(t *testing.T) {
	data := url.Values{
		"foo1": []string{"bar1"},
		"foo2": []string{"bar2"},
	}
	resp, err := doHttp("post", "http://127.0.0.1:8088/postList/", data)
	if err != nil {
		t.Errorf("%q", err)
	}
	defer resp.Body.Close()
	//allbytes, _ := httputil.DumpResponse(resp, true)
	//t.Logf("%s", string(allbytes))
	bytes, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		t.Errorf("%q", err)
	}
	postListResult := new(PostListResult)
	json.Unmarshal(bytes, postListResult)
	if postListResult.Code == 0 {
		t.Logf("%s", postListResult.Msg)
		for _, post := range postListResult.Data {
			t.Logf("%v", post)
		}
	} else {
		t.Errorf("%q", postListResult)
	}
}
```
