> 重命名文件和删除文件是应使用 git mv/rm命令
> 尽量别使用rm

- git mv命令
```
git mv filename1,filename2

等同于
mv oldname newname
git add newname
git rm oldname
```

- git rm命令
```
git rm filename
```
