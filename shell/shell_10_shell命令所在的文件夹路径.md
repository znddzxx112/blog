- shell命令所在的当前路径
```
#！/bin/sh
echo `realpath $0`
```

- shell命令所在的文件夹路径
```
#！/bin/sh
echo $(dirname `realpath $0`)
echo $(dirname $(dirname `realpath $0`))
```

