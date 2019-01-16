- 多窗口功能
```
vim ~/localetcpasswd
:sp /etc/passwd
ctrl + w + [j + k] 窗口切换
```
- 分屏操作
```
在一个已经打开的界面中
: sp newfile
使用ctrl + w +j/w 来进行屏幕切换
```

- 标签页新开页面
```
:tabe filename	edit file in new tab
gt	next tab
gT	previous tab
:tabr	first tab
:tabl	last tab
:tabm n	move current tab after tab n
```

- 列操作
```
删除列
1.光标定位到要操作的地方。
2.CTRL+v 进入“可视 块”模式，选取这一列操作多少行。
3.d 删除。
 
插入列
插入操作的话知识稍有区别。例如我们在每一行前都插入"() "：
1.光标定位到要操作的地方。
2.CTRL+v 进入“可视 块”模式，选取这一列操作多少行。
3.SHIFT+i(I) 输入要插入的内容。
4.ESC 按两次，会在每行的选定的区域出现插入的内容。
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
