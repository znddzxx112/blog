- xagrs
```
允许管道参数传递给命令
```

- 实例
```
// 当前普通文件复制
// -I 替代文件名称
find . ! -name "." -type d -prune -o -type f -print | xargs -I {} cp {} ./xdir
// 查找所有的jpg 文件，并且压缩它们
find . -type f -name "*.jpg" -print | xargs tar -czvf images.tar.gz
// 下载文件中的url
cat url-list.txt | xargs wget -c
```
