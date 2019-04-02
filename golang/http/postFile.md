- server
```
func TestHttpServer(t *testing.T) {
  // http upload file
	handle.HandleFunc("/upload", func(writer http.ResponseWriter, request *http.Request) {
		writer.WriteHeader(200)

		request.Body = http.MaxBytesReader(writer, request.Body, 2*1024*1024)
		if err := request.ParseMultipartForm(2 * 1024 * 1024); err != nil {
			writer.Write([]byte(errors.New("file too large").Error()))
			return
		}

		file, _, err := request.FormFile("file")
		if err != nil {
			writer.Write([]byte(err.Error()))
			return
		}
		defer file.Close()

		fileBytes, err := ioutil.ReadAll(file)
		if err != nil {
			writer.Write([]byte(err.Error()))
			return
		}

		filetype := http.DetectContentType(fileBytes)
		if filetype != "image/jpg" && filetype != "image/jpeg" {
			writer.Write([]byte(errors.New("ext not jpg").Error()))
			return
		}

		// save file
		uploadPath := "/var/www/goworkspace/src/formysql/static/"
		newFileName := filepath.Join(uploadPath, time.Now().Format("20060102150405")+".jpg")

		newFile, err := os.Create(newFileName)
		if err != nil {
			writer.Write([]byte(err.Error()))
			return
		}
		defer newFile.Close()

		if _, err := newFile.Write(fileBytes); err != nil {
			writer.Write([]byte(err.Error()))
			return
		}

		writer.Write([]byte(newFileName))
		return
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

// http post file
func TestPostFIle(t *testing.T) {
	path, _ := os.Getwd()
	path += "/me.jpg"
	extraParams := map[string]string{
		"title":       "My Document",
		"author":      "Matt Aimonetti",
		"description": "A document with all the Go programming language secrets",
	}
	request, err := newfileUploadRequest("http://127.0.0.1:8088/upload", extraParams, "file", path)
	if err != nil {
		log.Fatal(err)
	}
	client := &http.Client{}
	resp, err := client.Do(request)
	if err != nil {
		t.Errorf("%q", err)
	} else {
		body := &bytes.Buffer{}
		_, err := body.ReadFrom(resp.Body)
		if err != nil {
			log.Fatal(err)
		}
		resp.Body.Close()

		fmt.Println(resp.StatusCode)
		fmt.Println(resp.Header)
		fmt.Println(body)
	}

}

// Creates a new file upload http request with optional extra params
func newfileUploadRequest(uri string, params map[string]string, paramName, path string) (*http.Request, error) {
	file, err := os.Open(path)
	if err != nil {
		return nil, err
	}
	defer file.Close()

	body := &bytes.Buffer{}
	writer := multipart.NewWriter(body)
	part, err := writer.CreateFormFile(paramName, filepath.Base(path))
	if err != nil {
		return nil, err
	}
	_, err = io.Copy(part, file)

	for key, val := range params {
		_ = writer.WriteField(key, val)
	}
	err = writer.Close()
	if err != nil {
		return nil, err
	}

	req, err := http.NewRequest("POST", uri, body)
	req.Header.Set("Content-Type", writer.FormDataContentType())
	return req, err
}

```

- upload body
```
/**
--0d940a1e725445cd9192c14c5a3f3d30ea9c90f1f5fb9c08813b3fc2adee
Content-Disposition: form-data; name="file"; filename="doc.pdf"
Content-Type: application/octet-stream

%PDF-1.4
%????
4 0 obj
<</Type /Catalog
// removed for example
trailer
<</Size 18
/Root 4 0 R
>>
startxref
45054
%%EOF
--0d940a1e725445cd9192c14c5a3f3d30ea9c90f1f5fb9c08813b3fc2adee
Content-Disposition: form-data; name="title"

My Document
--0d940a1e725445cd9192c14c5a3f3d30ea9c90f1f5fb9c08813b3fc2adee
Content-Disposition: form-data; name="author"

Matt Aimonetti
--0d940a1e725445cd9192c14c5a3f3d30ea9c90f1f5fb9c08813b3fc2adee
Content-Disposition: form-data; name="description"

A document with all the Go programming language secrets
--0d940a1e725445cd9192c14c5a3f3d30ea9c90f1f5fb9c08813b3fc2adee--
*/

```
