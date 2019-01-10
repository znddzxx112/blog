- 是否开启子进程
```
# sh xx.sh // 使用开子进程的方式
# source xx.sh // 在当前shell运行
```

- 脚本变量是否能作用于当前
```
sh xx.sh // 由于是子shell，可以使用父shell的变量,但运行结束，父shell读取不到子shell
source xx.sh // 在当前父shell中运行,所以脚本中的变量直接作用于父shell中
```

- 使用情况
```
sh xx.sh // 自定义脚本执行，不希望影响当前变量
source xx.sh // 往往是source .bashrc 或者 source .bash_profile
```
