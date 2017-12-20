- 参考文章
```
http://blog.csdn.net/yasi_xi/article/details/18551745
```

```
# PHP环境变量
PHP_INCLUDE = `php-config --includes`
PHP_LIBS = `php-config --libs`
PHP_LDFLAGS = `php-config --ldflags`
PHP_INCLUDE_DIR = `php-config --include-dir`
PHP_EXTENSION_DIR = `php-config --extension-dir`

# 编译器
CC = gcc

# 编译参数
CFLAGS = -g -O0 -fPIC -I. ${PHP_INCLUDE} -I${PHP_INCLUDE_DIR}

# 链接参数
LDFLAGS = -shared -L${PHP_EXTENSION_DIR} ${PHP_LIBS} ${PHP_LDFLAGS}
```

```
-g //代表可以被编译器优化
-shared -fPIC//代表生成动态库
-O0 //代表编译器不对代码做优化
-I //代表头文件目录 -I目录1 -I目录2 -I目录3...
-L //库文件目录 -L目录1 -L目录2 -L目录3...
-l //代表库名称 -l库名称1 -l库名称2 -l库名称3...
```
