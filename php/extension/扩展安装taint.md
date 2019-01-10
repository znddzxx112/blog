- 作用：用于安装php扩展
- 这些扩展基本上由c语言编写
- 关于php扩展安装
```
1. 静态编译 
# --enable-mbstring --with-jpeg-dir 可以指定路径或者搜索默认
2. 源码编译 
# php-config phpize make make install
3. pecl
# 通过pear打包系统来安装扩展
# 使用该命令可以自己生成扩展
```

- pecl命令位置
```
# php安装以后位置在
# /usr/local/php/bin/pecl
# 建立软连接
# ln -s /usr/local/php/bin/pecl /usr/local/bin/
```

- pecl参数介绍
```
# pecl help  //帮助
# pecl -V //pecl 版本
# pecl list -a //显示所有channel下的已安装的package包
# pecl search taint //查找软件
# pecl install  pecl install chanel://pecl.php.net/taint-2.0.2
# pecl install taint-2.0.2
//安装软件，默认从pecl.php.net网站下载
# 默认下载最新软件包，稳定的版本
# 在php.ini增加
[taint]
extension=taint.so
taint.enable=1
taint.error_level=E_WARNING
# 判断是否已经添加
# php -i | grep taint
taint
taint support => enabled
taint.enable => On => On
taint.error_level => 2 => 2
```

- 对以下情况产生warning
```
1. 输出函数/语句系列
    echo
    print
    printf
    file_put_contents
2. 文件系统函数
    fopen
    opendir
    basename
    dirname
    file
    pathinfo
3. 数据库系列函数/方法
    mysql_query
    mysqli_query
    sqlite_query
    sqlite_single_query
    oci_parse
    Mysqli::query
    SqliteDataBase::query
    SqliteDataBase::SingleQuery
    PDO::query
    PDO::prepare
4. 命令行系列
    system
    exec
    proc_open
    passthru
    shell_exec
5. 语法结构
    eval
    include(_once)
    require(_once)
```
