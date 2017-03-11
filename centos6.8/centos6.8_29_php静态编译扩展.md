##### php静态编译扩展

- 查看命令
```
php --ri curl
php -i | grep configure
php -m | grep curl
```

- 在php源代码目录重新编译
```
make clean
./configure --prefix=/usr/local/php7 -enable-fpm --with-mysqli --with-gd --with-curl --with-jpeg-dir
make && make install
```

- 注意
```
如果通过yum安装了libjpeg则dir可以不用指定
```

- 重启php-fpm，就加载最新
