- 变量读取
```
 read -p '提示语' -t 30 var 
```

- 数组与变量定义
```
declare 
-a 数组
-i 数字
-x 环境变量 +x 取消环境变量
declare -a arr
arr[1]=hello
echo ${arr[1]}
建议使用{}来输出数组
```
