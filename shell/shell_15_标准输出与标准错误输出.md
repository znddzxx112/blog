- 标准错误输出
```
ls -al wwww 2>> stderr
ls -al wwww 2> stderr
```

- 标准输出
```
ls -al wwww 1> stdout 2>stderr
```

- 标准输出与标准错误输出
```
ls -al &> stdoutAndstderr
```

- shell中将标准错误输出到文件
```
./tstderr.sh 2> stderr
```
```
#! /bin/bash
# 将消息输出到标准错误
echo "this is error" >&2 
```
