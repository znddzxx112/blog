- server
```
func TestHttpServer(t *testing.T) {

	handle := http.NewServeMux()

	// write protobuf
	handle.HandleFunc("/", func(writer http.ResponseWriter, request *http.Request) {
		writer.WriteHeader(200)
		contactBook := buildContractBook()
		body, _ := proto.Marshal(contactBook)
		writer.Write(body)
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

- client
```
// client protobuf
func TestHttpClientPb(t *testing.T) {
	client := &http.Client{}
	req, rErr := http.NewRequest("GET", "http://127.0.0.1:8088/main/home/index", nil)
	if rErr != nil {
		t.Errorf("%q", rErr)
	}
	resp, respErr := client.Do(req)
	if respErr != nil {
		t.Errorf("%q", respErr)
	}
	defer resp.Body.Close()
	b := &bytes.Buffer{}
	io.Copy(b, resp.Body)

	contactBook := new(formysqlpb.ContactBook)
	proto.Unmarshal(b.Bytes(), contactBook)

	for _, person := range contactBook.Persons {
		t.Logf("persion name: %q", person.Name)
		for _, phone := range person.Phones {
			t.Logf("phone: %q", phone.Number)
		}
	}

}

```
