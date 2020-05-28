- 参考文章：https://gin-gonic.com/cn/
- 接收url参数,query_string方法
```

c.DefaultQuery()

```

- 接收post form参数
```
Content-Type: application/x-www-form-urlencoded 
curl -d 'foo=bar&'
c.DefaultPostForm()
```

- 接收post 上传文件
```
file, _:= c.FormFile("file")
c.SaveUploadFile(file, dst)
```
```
curl -X POST http://localhost:8080/upload \
  -F "file=@/Users/appleboy/test.zip" \
  -H "Content-Type: multipart/form-data"
```

- 接收多文件上传
```
form, _ := c.MultipartForm()
files := form.File["upload[]"]
filePathMap := make(map[string]string)
for k, file := range files {
   key := "filename" + strconv.Itoa(k)
   c.SaveUploadFile(file, dst)
}
```
- curl 提示could not open file
```
curl -X POST http://localhost:8080/upload \
  -F "upload[]=@/Users/appleboy/test1.zip" \
  -F "upload[]=@/Users/appleboy/test2.zip" \
  -H "Content-Type: multipart/form-data"
```


