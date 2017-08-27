 - find命令常用形式
 ```
 find [path...] [expression]
 find 路径 表达式
 ```
 
 - 常用实例
 ```
 // 根据文件名查找文件
 $ find ~ -name "src"
 // 按照文件权限来查找文件
 find ~ -perm 664 
 // 按照文件属主来查找文件
 find -user username
 // 按照文件所属的组来查找文件
 find -group www
 // 按照文件的更改时间来查找文件, - n表示文件更改时间距现在n天以内，+ n表示文件更改时间距现在n天以前
 find -mtime -5
// 查找某一类型的文件，诸如： 
// b - 块设备文件。 
// d - 目录。 
// c - 字符设备文件。 
// p - 管道文件。 
// l - 符号链接文件。 
// f - 普通文件。 
 find -type f -mtime -5
// 模糊查询
find -name "*um*" -type f -mtime -5 
 ```

 
 
