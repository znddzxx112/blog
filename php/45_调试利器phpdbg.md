- 执行命令
```
/usr/local/php7/bin/phpdbg
```

- help 命令
```
prompt > help
prompt > h
prompt > help list
prompt > help info
```

- debug某一个文件
```
prompt > exec /var/www/xxxx.php // 推荐使用这种方式 绝对路径
```

- 打断点
```
prompt > b 100 //文件内的行数
```

- 取消打的断点
```
prompt > b del breakNum // 断点名称
```

- 尝试运行文件,运行到第一个断点
```
prompt > r // run
```

- 运行到下个断点
```
prompt > c // continue
```

- 单步运行
```
prompt > s //step
```

- 查看变量的值
```
prompt > i v
```

- 查看包含的文件
```
prompt > i F
```

- 查看包含的类
```
prompt > i c
```

- 查看定义的常量
```
prompt > i d
```

- 高级使用
```
prompt > print // 查看opcode
prompt > p o // 显示当前准备运行的
```
