- 多窗口功能
```
vim ~/localetcpasswd
:sp /etc/passwd
ctrl + w + [j + k] 窗口切换
```

- 块操作
- 一般都进行行操作
```
crtl + v 进入块操作
```

- 多文件编辑
```
# vim /etc/passwd ~/localetcpasswd
: r ~/localetcpasswd 读入其他文件到当前内容中
编辑其他文件
:n 编辑下个文件
:N 编辑上个文件
:files 查看多个文件
```

- vim环境设置与记录 
```
~/.vimrc 个人配置文件
/etc/vimrc 全局配置文件
```

- 字符串替换
```
: s/vivian/sky/g 全局替换
: n，$s/vivian/sky/gc 替换第 n 行开始到最后一行中每一行的第一个 vivian 为 sky 
```

- dos与linux断行字符
```
: set ff=unix
```

- 语系编码转换
```
# wget http://linux.vbird.org/linux_basic/0310vi/vi.big5
# file vi.big5
# iconv -f big5 -t utf8 vi.big5 -o vi.utf8

```
