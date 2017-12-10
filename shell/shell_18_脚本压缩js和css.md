- 参考文章
```
https://www.verynull.com/2015/05/07/%E5%86%99%E4%B8%AA%E8%84%9A%E6%9C%AC%E5%8E%8B%E7%BC%A9JS-CSS/
```

- 下载最新版的yuicompressor.jar
```
https://github.com/yui/yuicompressor/releases

```


- 遍历目录，压缩JS、CSS
```
#!/bin/bash
for i in `find path -name "*.css"`;
do
    echo "compress $i"
    java -jar yuicompressor-2.4.8.jar --charset=utf8 -o $i $i --nomunge
done
```
