[TOC]

### 文档

> 官方文档：https://golang.org/
> 本地文档: godoc -http=:6060
> 在线中文文档：http://docscn.studygolang.com/
> 中文git编译文章项目：https://git.oschina.net/liudiwu/pkgdoc.git

### 标准命令

#### go build

> 编译源码文件以及依赖包.源码文件:分为命令源码文件、库源码文件
>
> build命令源码文件，结果生成可执行文件，-o标记参数 命名可执行文件名称
>
> build库源码文件，生成.a后缀的库文件

> golang二个编译器 1.gc golang自带编译器 2.gccgo gcc提供的golang编译器
>
> -v 标记参数打印被编译的代码包名字

##### 环境变量CGO_CFLAGS

> 等效-gcflags标记参数: 将参数传给gc自带编译器。即 go tool compile

##### 环境变量CGO_LDFLAGS

> 等效-ldflags标记参数: 将参数传给连接器。即go tool link

```bash
$ go build -work -v
WORK=/tmp/go-build253900926
github.com/google/gops/signal
github.com/go-playground/locales/currency
github.com/tidwall/match
sipc_vip_backend_go/gateway/common
golang.org/x/sys/unix
github.com/urfave/cli
github.com/dgrijalva/jwt-go
github.com/dchest/captcha
```

> -work 编译目录
>
> -v 打印依赖的包名称

**交叉编译**

> ```bash
> $ CGO_ENABLED=0 GOOS=darwin GOARCH=amd64 go build ``test``.go
> $ CGO_ENABLED=0 GOOS=windows GOARCH=amd64 go build ``test``.go
> ```

#### go install

> 等价于先执行 go build，再将命令放到$GOBIN目录下
>
> 如果$GOBIN未被设置值则会报错
>
> 标准包的库源码文件放在$GOPATH/pkg下

#### go get 

> 等价于 git clone + go install
>
> 最终将命令放到$GOBIN目录下

#### go mod

##### 环境变量**GO111MODULE**

> GO111MODULE=off   // 不用module功能，GOPATH模式寻找依赖包
> GO111MODULE=on   // module模式，build时找module下的vendor，GOPATH承担下载依赖包到GOPATH/pkg/mod
> GO111MODULE=auto  // 根据当前目录是否包含go.mod来判断

##### 环境变量GOPROXY

> go env -w GOPROXY=http://goproxy.cn,direct
>
> 制定go mod 代码下载代理

> go mod download       // 下载依赖到本地缓存，查看GOCACHE缓存地址
> go mod graph          //把模块之间的依赖图显示出来
> go mod init [模块名]      // 当前目录初始化和创建`go.mod`文件,最好是项目名
> go mod tidy -v          // 添加确实模块和移除不必要的模块
> go mod vendor -v       // 当前目录下生产vendor目录，包含所有依赖包
> go mod verify          // 检查当前模块的依赖是否已经存储在本地下载的源代码缓存中
> go build -mod=vendor   // 依赖module下的vendor生成可执行文件

#### go env

> go env -w 设定的变量值，存放在GOENV="~/.config/go/env"下

#### go bug

> 打开github/golang/go issue页面准备提交bug，会把当前系统信息携带到issue

#### go clean

> 可以去除源码包依赖的包go mod tidy执行后下载的源码

#### go fmt

> go fmt main.go
>
> 格式化main.go

### 项目源码分析工具

#### go-callvis

> go get -u github.com/ofabry/go-callvis

比如

> go-callvis -group pkg,type -focus github.com/apache/rocketmq-client-go/v2/internal ./examples/producer/simple

### 入门资料

> 无闻中文讲解：https://www.jianshu.com/p/1da03e36f382
> go example:https://gobyexample.com/

### 学习书籍推荐

> 1. https://studygolang.com/books
> 1.1 https://studygolang.com/book/71
> 1.2 https://studygolang.com/book/70
> 1.3 https://studygolang.com/book/34
> 1.4 https://studygolang.com/book/40
> 1.5 https://studygolang.com/book/69
> 1.6 https://studygolang.com/book/66
> 1.7 https://studygolang.com/book/65
> 1.8 https://studygolang.com/book/42 - 基于select的多路复用

### 学习型gitlab项目推荐

#### cache2go


> 1. 并发安全
> 2. 自定义errors
> 3. cacheTable,cacheItem struct定义
> 4. golang项目的git PR方式

#### godis


> 1. client与server设计类似mysql的命令行模式
> 2. 命令在server的注册
> 3. aof的实现
> 4. 多个struct组合
> 5. redis数据结构的golang实现
> 6. server响应信号
> 7. client与server的通信协议编码

#### groupcache


> 1. 一致性hash的应用，hash环实现
> 2. httppool的实现
> 3. probuf的使用

