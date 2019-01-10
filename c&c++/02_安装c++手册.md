- 下载c++手册
```
$ wget http://gcc.skazkaforyou.com/libstdc++/doxygen/libstdc++-api-4.5.2.man.tar.bz2
```

- 解压并放到指定目录
```
$ tar jxvf libstdc++-api-4.5.2.man.tar.bz2
$ sudo cp -R man3/. /usr/share/man/man3 // 将文件夹man3下的所有文件复制到目录中
```

- c++查询 命名空间::头文件
```
$ man std::iostream
$ man std::num_get
```
