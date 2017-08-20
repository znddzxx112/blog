- 要求autoconf高版本
- autoconf下载地址
```
http://ftp.gnu.org/gnu/autoconf/
$ sudo wget http://ftp.gnu.org/gnu/autoconf/autoconf-2.65.tar.gz
```

- 解压安装
```
# tar zxvf autoconf-2.65.tar.gz
# cd autoconf-2.65
# mkdir /usr/local/autoconf2.65
# ./configure
# make && make install
```

- 替换现有autoconf2.64为2.65版本
```
# which autoconf
# mv /usr/bin/autoconf /usr/bin/autoconf2.64
# ln -s /usr/local/autoconf2.65/bin/autoconf /usr/bin/
# autoconf --version
```

- 安装automake
```
# wget http://ftp.gnu.org/gnu/automake/automake-1.15.1.tar.gz
# tar zxvf automake-1.15.1.tar.gz
# cd automake-1.15.1
# mkdir /usr/local/automake1.15
# ./configure
# make && make install
# /usr/local/automake1.15/bin/automake --version
```

- 替换现有automake1.11为1.15.1版本
```
# mv /usr/bin/automake /usr/bin/automake1.11
# ln -s /usr/local/automake1.15/bin/automake /usr/bin/
```
