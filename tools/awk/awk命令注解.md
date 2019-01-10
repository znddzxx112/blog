- 参考文章
```
http://www.cnblogs.com/ggjucheng/archive/2013/01/13/2858470.html
```

- awk
```
awk是一个强大的文本分析工具，相对于grep的查找，sed的编辑，awk在其对数据分析并生成报告时，显得尤为强大。简单来说awk就是把文件逐行的读入，以空格和tab为默认分隔符将每行切片，切开的部分再进行各种分析处理。
```

- 使用方式
```
awk '{pattern + action}' {filenames}
```

- 工作流程
```
awk工作流程是这样的：读入有'\n'换行符分割的一条记录，然后将记录按指定的域分隔符划分域，填充域，
$0则表示所有域,$1表示第一个域,$n表示第n个域。默认域分隔符是"空白键" 或 "[tab]键"。
```

- 实例
```
// -F 分隔符
$ awk -F ':' '{print $1}' /etc/passwd
$ awk -F ':' '{print $1"\t"$7}' /etc/passwd
// pattern action
$ awk -F ':' '/root/{print $1"\t"$7}' /etc/passwd
```

- awk内置变量
```
ARGC               命令行参数个数
ARGV               命令行参数排列
ENVIRON            支持队列中系统环境变量的使用
FILENAME           awk浏览的文件名
FNR                浏览文件的记录数
FS                 设置输入域分隔符，等价于命令行 -F选项
NF                 浏览记录的域的个数
NR                 已读的记录数
OFS                输出域分隔符
ORS                输出记录分隔符
RS                 控制记录分隔符
```

```
// 实例
$ awk -F ':' '/root/{print $1 OFS $7}' /etc/passwd
```
