> 安装cmake 要求3.5
```
CMake是一个比make更高级的编译配置工具，它可以根据不同平台、不同的编译器，生成相应的Makefile或者vcproj项目。
通过编写CMakeLists.txt，可以控制生成的Makefile，从而控制编译过程。CMake自动生成的Makefile不仅可以通过make命令构建项目生成目标文件，还支持安装（make install）、测试安装的程序是否能正确执行（make test，或者ctest）、生成当前平台的安装包（make package）、生成源码包（make package_source）、产生Dashboard显示数据并上传等高级功能，只要在CMakeLists.txt中简单配置，就可以完成很多复杂的功能
CMake是一个非常强大的编译自动配置工具
```
```
// 下载3.6版本的cmake 32位执行文件
wget https://cmake.org/files/v3.6/cmake-3.6.0-Linux-i386.tar.gz
tar -zxvf cmake-3.6.0-Linux-i386.tar.gz
ln -s /usr/local/src/cmake-3.6.0-Linux-i386/bin/cmake /usr/local/bin/

```

- gcc 4.8 or later
```
参见文章centos6.8安装devtool2
devtool2中gcc版本就是4.8.2,够用
```

- Build libphpx.so
```
cd PHP-X
// cmake version 3.6.0
cmake .
make -j 4
sudo make install
// 出现，安装完成
[100%] Built target phpx
Install the project...
-- Install configuration: "Release"
Are you run command using root user?
-- Installing: /usr/local/lib/libphpx.so
-- Installing: /usr/local/include/phpx.h
-- Installing: /usr/local/include/phpx_embed.h

```

- build extension
```
cd examples/cpp_ext
make 
sudo make install
// 出现错误
cp cpp_ext.so `php-config --extension-dir`/
cp: 无法创建普通文件"/usr/local/lib/php/extensions/no-debug-non-zts-20160303/": 没有那个文件或目录

// php-x默认放到
/usr/local/lib/php/extensions/no-debug-non-zts-20160303/
// 实际情况我安装了多个版本的php，需要手动cpp_ext.so放到具体路径下
cp cpp_ext.so /usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303/

```

- Load your extension
```
Edit php.ini, add extension=cpp_ext.so
```

- issue
```
HI I tried all the options given above but couldnt able to resolve my issue.

here is the details.

[root@centos6x8-lnmp cpp_ext]# php --ini
Configuration File (php.ini) Path: /usr/local/php7/lib
Loaded Configuration File:         /usr/local/php7/lib/php.ini
Scan for additional .ini files in: (none)
Additional .ini files parsed:      (none)

[root@centos6x8-lnmp cpp_ext]# php -i | grep extension
extension_dir => /usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303 => /usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303

# vim /usr/local/php7/lib/php.ini
# add extension
extension = cpp_ext.so

[root@centos6x8-lnmp cpp_ext]# ll /usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303/cpp_ext.so 
-rwxr-xr-x 1 root root 497495 6月  20 00:55 /usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303/cpp_ext.so

[root@centos6x8-lnmp cpp_ext]# php echo.php 
PHP Warning:  PHP Startup: Unable to load dynamic library '/usr/local/php7/lib/php/extensions/no-debug-non-zts-20160303/cpp_ext.so' - libphpx.so: cannot open shared object file: No such file or directory in Unknown on line 0
```

- 解决issue
```
// 参见：https://github.com/swoole/PHP-X/issues/5
# vim /etc/ld.so.conf.d/phpx.conf
// add local lib
/usr/local/lib
# ldconfig // 刷新缓存
```
