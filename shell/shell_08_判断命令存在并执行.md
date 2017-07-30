- 判断命名是否可执行，并将命令执行的内容放到变量中
```
if [ -x /usr/bin/id ]; then
        uname="`id -un`"
        echo ${uname}
fi
```
