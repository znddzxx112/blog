- 参考文章:http://blog.csdn.net/zhangpower1993/article/details/52184581 
- 安装vundle
 ```
 $ git clone https://github.com/VundleVim/Vundle.vim.git ~/.vim/bundle/Vundle.vim
 ```
 
 - 安装插件
```
$vim ~/.vimrc
```
```
set nu
set nocompatible              " 去除VI一致性,必须要添加
filetype off                  " 必须要添加

" 设置包括vundle和初始化相关的runtime path
 set rtp+=~/.vim/bundle/Vundle.vim
 call vundle#begin()
 " 另一种选择, 指定一个vundle安装插件的路径
 "call vundle#begin('~/some/path/here')

 " 让vundle管理插件版本,必须
 Plugin 'VundleVim/Vundle.vim'
 Plugin 'VundleVim/taglist.vim'

 " 以下范例用来支持不同格式的插件安装.
 " 请将安装插件的命令放在vundle#begin和vundle#end之间.
 " Github上的插件
 " 格式为 Plugin '用户名/插件仓库名'
 Plugin 'tpope/vim-fugitive'
 " 来自 http://vim-scripts.org/vim/scripts.html 的插件
 " Plugin '插件名称' 实际上是 Plugin 'vim-scripts/插件仓库名'
" 只是此处的用户名可以省略
 Plugin 'L9'
 " 由Git支持但不再github上的插件仓库 Plugin 'git clone 后面的地址'
 Plugin 'git://git.wincent.com/command-t.git'
 " 本地的Git仓库(例如自己的插件) Plugin 'file:///+本地插件仓库绝对路径'
 " Plugin 'file:///home/gmarik/path/to/plugin'
 Plugin 'git://github.com/scrooloose/nerdtree.git'
 " 插件在仓库的子目录中.
 " 正确指定路径用以设置runtimepath. 以下范例插件在sparkup/vim目录下
 Plugin 'rstacruz/sparkup', {'rtp': 'vim/'}
 " 安装L9，如果已经安装过这个插件，可利用以下格式避免命名冲突
" Plugin 'ascenator/L9', {'name': 'newL9'}

 " 你的所有插件需要在下面这行之前
 call vundle#end()            " 必须
 filetype plugin indent on    " 必须
 autocmd VimEnter * NERDTree
 autocmd VimEnter * TlistOpen
 " 加载vim自带和插件相应的语法和文件类型相关脚本
 " 忽视插件改变缩进,可以使用以下替代:
 filetype plugin on
 """"""""""""""""""""""""""""""
    " Tag list (ctags)
 """"""""""""""""""""""""""""""
  let Tlist_Ctags_Cmd = '/usr/bin/ctags'
  let Tlist_Show_One_File = 1
 "不同时显示多个文件的tag，只显示当前文件的
  let Tlist_Exit_OnlyWindow = 1
 "如果taglist窗口是最后一个窗口，则退出vim
  let Tlist_Use_Right_Window = 1
 "在右侧窗口中显示taglist窗口
 "
 " 常用的命令
 " :PluginList       - 列出所有已配置的插件
 " :PluginInstall     - 安装插件,追加 `!` 用以更新或使用 :PluginUpdate
 " :PluginSearch foo - 搜索 foo ; 追加 `!` 清除本地缓存
 " :PluginClean      - 清除未使用插件,需要确认; 追加 `!`
 " 自动批准移除未使用插件
 "
 " 查阅 :h vundle 获取更多细节和wiki以及FAQ
 " 将你自己对非插件片段放在这行之后

```

- vundle插件命令
```
安装插件:PlugInstall 
更新插件BundleUpdate
列出所有插件BundleList
查找插件BundleSearch
```

- 移除插件
```
编辑.vimrc文件移除的你要移除的插件所对应的plugin那一行。
保存退出当前的vim
重新打开vim，输入命令BundleClean。
```
