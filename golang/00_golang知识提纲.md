[TOC]

#### 文档

> 官方文档：https://golang.org/
> 本地文档: godoc -http=:6060
> 在线中文文档：http://docscn.studygolang.com/
> 中文git编译文章项目：https://git.oschina.net/liudiwu/pkgdoc.git

#### 标准命令

- go build

  > 编译源码文件以及依赖包.源码文件:分为命令源码文件、库源码文件
  >
  > build命令源码文件，结果生成可执行文件，-o标记参数 命名可执行文件名称
  >
  > build库源码文件，生成.a后缀的库文件
  >
  > golang二个编译器 1.gc golang自带编译器 2.gccgo gcc提供的golang编译器
  >
  > -v 标记参数打印被编译的代码包名字
  >
  > -gcflags标记参数: 将参数传给gc自带编译器。即 go tool compile
  >
  > -ldflags标记参数: 将参数传给连接器。即go tool link

- go install

  > 编译命令源码文件，并将结果放到$GOBIN目录下，如果$GOBIN未被设置值则会报错

#### 入门资料

> 无闻中文讲解：https://www.jianshu.com/p/1da03e36f382
> go example:https://gobyexample.com/

#### 学习书籍推荐

> 1. https://studygolang.com/books
> 1.1 https://studygolang.com/book/71
> 1.2 https://studygolang.com/book/70
> 1.3 https://studygolang.com/book/34
> 1.4 https://studygolang.com/book/40
> 1.5 https://studygolang.com/book/69
> 1.6 https://studygolang.com/book/66
> 1.7 https://studygolang.com/book/65
> 1.8 https://studygolang.com/book/42 - 基于select的多路复用

#### 学习型gitlab项目推荐

- ##### cache2go


> 1. 并发安全
> 2. 自定义errors
> 3. cacheTable,cacheItem struct定义
> 4. golang项目的git PR方式

- ##### godis


> 1. client与server设计类似mysql的命令行模式
> 2. 命令在server的注册
> 3. aof的实现
> 4. 多个struct组合
> 5. redis数据结构的golang实现
> 6. server响应信号
> 7. client与server的通信协议编码

- ##### groupcache


> 1. 一致性hash的应用，hash环实现
> 2. httppool的实现
> 3. probuf的使用

