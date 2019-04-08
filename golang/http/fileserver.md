```
func TestFileServer1(t *testing.T) {

	handle := http.NewServeMux()
	handle.Handle("/static/", http.StripPrefix("/static/", http.FileServer(http.Dir("./"))))
	t.Log(http.ListenAndServe(":8088", handle))
}

func TestFileServer2(t *testing.T) {

	// http cache
	// https://blog.csdn.net/u012375924/article/details/82806617
	// https://www.cnblogs.com/straybirds/p/9413937.html
	handle := http.NewServeMux()
	handle.HandleFunc("/static/", func(writer http.ResponseWriter, request *http.Request) {
		u, err := url.Parse("http://www.mydump.com" + request.RequestURI)
		if err != nil {
			writer.WriteHeader(404)
			return
		}

		fmt.Println(u)
		fmt.Println(u.RequestURI())
		frags := strings.Split(strings.TrimLeft(u.RequestURI(), "/"), "/")
		if len(frags) < 2 {
			writer.WriteHeader(404)
			return
		}
		filepath := strings.Join([]string{"./", frags[1]}, "/")

		fileinfo, err := os.Stat(filepath)
		if err != nil {
			writer.WriteHeader(404)
			return
		}
		//mt := fileinfo.ModTime()
		h := md5.New()
		h.Write([]byte(fileinfo.Name()))
		//etag := h.Sum(nil)

		fp, err := os.Open(filepath)
		defer fp.Close()
		if err != nil {
			writer.WriteHeader(404)
			return
		}
		bytes, err := ioutil.ReadAll(fp)
		if err != nil {
			writer.WriteHeader(404)
			return
		}
		writer.Header().Set("Content-Type", "image/png")
		//writer.Header().Set("Cache-Control", "no-store")
		//writer.Header().Set("Cache-Control", "no-cache")

		//writer.Header().Set("Cache-Control", "max-age=60")
		//writer.Header().Set("Last-Modified", mt.In(time.FixedZone("CST", 8*3600)).Format("Mon, 02 Jan 2006 15:04:05 GMT"))
		//writer.Header().Set("Etag", hex.EncodeToString(etag))
		//writer.Header().Set("Date", time.Now().In(time.FixedZone("CST", 8*3600)).Format("Mon, 02 Jan 2006 15:04:05 GMT"))

		// timeZone so eeee....
		writer.WriteHeader(200)
		writer.Write(bytes)
		return
	})
	t.Log(http.ListenAndServe(":8088", handle))
}
```
