- 参考文章：https://blogs.oracle.com/harry/entry/linux%E4%B8%8Bmakefile%E7%9A%84automake%E7%94%9F%E6%88%90%E5%85%A8%E6%94%BB%E7%95%A5_zz

- 目的与总结
```
生成通用符合gnu标准的MakeFile文件
configure.in 生成configure的shell脚本
makefile.am 生成makefile.in
configure和makefile.in 生成makefile
通过make && make install 安装程序
make uninstall 卸载程序
make dist 产生软件包给其他人使用
```

- 前提
```
gcc
autoconf
automake
在yum下面通过yum install命令安装
```

- 创建目录
```
# mkdir helloworld
# cd helloworld/
```

- 创建源文件
```
# vim helloworld.c
#include <stdio.h>
int main(int argv, char* argc[])
{
        printf("Hello,Linux World!\n");
        return 0;
}

```

- configure.in生成configure
```
configure是一个shell脚本，把makefile.in生成makefile文件，并可在中途指定软件安装路径
# autoscan
# mv configure.scan configure.in
# vim configure.in
```
```
-*- Autoconf -*-
# Process this file with autoconf to produce a configure script.

AC_PREREQ([2.63])
#AC_INIT([hellolinux-znddzxx112], [0.0.1], [znddzxx112@163.com]) 
AC_INIT(helloworld.c)
AM_INIT_AUTOMAKE(helloworld,1.0)
AC_CONFIG_SRCDIR([helloworld.c])
AC_CONFIG_HEADERS([config.h])

# Checks for programs.
AC_PROG_CC

# Checks for libraries.

# Checks for header files.

# Checks for typedefs, structures, and compiler characteristics.

# Checks for library functions.

AC_OUTPUT(Makefile)
```
```
# aclocal
生成了aclocal.m4
# autoconf
aclocal.m4  autom4te.cache  configure  configure.in  helloworld.c
```

- makefile.am 生成makefile.in
```
# vim Makefile.am
AUTOMAKE_OPTI 
bin_PROGRAMS=helloworld
helloworld_SOURCES=helloworld.
#touch NEWS
#touch README
#touch AUTHORS
#touch ChangeLog
# automake
```

- 生成makefile文件
```
#  makedir -p /usr/local/helloworld
# ./configure --prefix=/usr/local/helloworld
```

- 编译安装
```
# make && make install
```

- 测试安装
```
# /usr/local/helloworld/bin/helloworld
```

- 修改源文件再次编译安装
```
#vim helloworld.c
# make && make install
```

- make相关指令
```
make 
根据Makefile编译源代码，连接，生成目标文件，可执行文件。 
make clean 
清除上次的make命令所产生的object文件（后缀为“.o”的文件）及可执行文件。 
make install 
将编译成功的可执行文件安装到系统目录中，一般为/usr/local/bin目录。 
make dist 
产生发布软件包文件（即distribution package）。这个命令将会将可执行文件及相关文件打包成一个tar.gz压缩的文件用来作为发布软件的软件包。 
它会在当前目录下生成一个名字类似“PACKAGE-VERSION.tar.gz”的文件。PACKAGE和VERSION，是我们在configure.in中定义的AM_INIT_AUTOMAKE(PACKAGE, VERSION)。 
make distcheck 
生成发布软件包并对其进行测试检查，以确定发布包的正确性。这个操作将自动把压缩包文件解开，然后执行configure命令，并且执行make，来确认编译不出现错误，最后提示你软件包已经准备好，可以发布了。 
=============================================== 
helloworld-1.0.tar.gz is ready for distribution 
=============================================== 
make distclean 
类似make clean，但同时也将configure生成的文件全部删除掉，包括Makefile。 
```

- 报错重新生成configure，先删除config.status 和 configure
```
# rm config.status 
# rm configure
# autoconf
遇到分隔符报错
# vim makefile
# AUTOMAKE_OPTI :
```
