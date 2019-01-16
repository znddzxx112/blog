- vim 官网 - 下载
```
http://www.vim.org/download.php
```

- vim7.4.2367,vim7最后一个版本
```
$ cd ~/src
$ wget https://github.com/vim/vim/archive/v7.4.2367.tar.gz
```

- 安装
```
$ mkdir -p ~/local/vim74
$ ./configure --prefix=/home/xxx/local/vim74 -with-features=huge --enable-pythoninterp --enable-python3interp --enable-luainterp --enable-multibyte --enable-fontset --enable-pythoninterp=yes
$ make && make install
```

- 仅为当前用户增加vim7.4版本
```
$ vim ~/.zshrc
export PATH=/home/xxx/local/vim74/bin/:$PATH 
```
