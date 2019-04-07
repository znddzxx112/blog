- 当需要fork其他人的项目时候
```
// 拉取从原项目中拉取
go get -u 原始项目
// remote fork 对标自己fork过来的github地址
git remote add fork git@github.com/znddzxx112/xxx.git
git fetch fork
git push fork master
// 查看总共有哪些remote
git remote -v
// 删除/新建 remote 
git remote remove <name>
git remote add <name> <url>
```

- 维护自己的golang github仓库
```
go get -u 自己的项目
修改remote origin 改成 git@github.com 这样每次都不用输入账号密码了
```
