- 参考文章：http://www.cnblogs.com/dong008259/archive/2011/12/08/2281214.html


- sort排序
```
sort file
-r 倒序输出
-n 数值大小排序
-o file,排序后的结果写入file文件中
-u 去重排序
-k 根据哪个区间进行排序。
-t <分隔字符>   指定排序时所用的栏位分隔字符。
-f 忽略大小写
```

- 示例
```
// 首字母排序
sed -n 'p' /etc/passwd | sort
// 首字母倒序
sed -n 'p' /etc/passwd | sort -r
// 按照用户id排序
sed -n 'p' /etc/passwd | sort -t ':' -k 3 
// 按照用户id数值排序
sed -n 'p' /etc/passwd | sort -n -t ':' -k 3
// 排序结果写入文件
sed -n 'p' /etc/passwd | sort -n -r -t ':' -k 3 -o recentUser.txt
```
