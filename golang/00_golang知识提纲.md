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
> $ CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build ``test``.go
> // mac
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


### golang调试
- 参考文章
```
https://www.flysnow.org/2017/06/07/go-in-action-go-debug.html
```

- 推荐使用goland ide调试
```
goland本质也是使用delve调试
Delve是一个专门为调试Go程序而生的调试工具，它比GDB更强大，尤其时调试多goroutine高并发的Go程序。Delve的项目地址为https://github.com/derekparker/delve，它业绩大部分Go开发IDE选用的调试工具，比如Goland，后面我们再介绍。
```
```
调试配置：
run -> edit configurations
run kind:directory
directory:src/projectname
working directory:src/projectname
program arguments:-f config_dev/conf.yaml
```

- 命令行gdb，delve调试


- 打印调试，日志调试
```
多个go程使用该种方法，替换golang ide调试
```

### golang第三方库汇总

- 参考文章
```
https://studygolang.com/topics/7444
```

### golang单元测试


- 必读文章
```
https://testerhome.com/topics/6374
https://medium.com/@rosaniline/unit-testing-gorm-with-go-sqlmock-in-go-93cbce1f6b5b
```

- 概要
```
1. 使用gotests命令，来完成表单形式、testify的suite形式，这二种方式都推荐，testify更推荐
2. http的单元测试库使用httpexcept
3. sql的单元测试库使用go-sqlmock
4. golang官方mock库使用gomock，除了http和mysql场景的测试之外使用
```

- 单元测试释义
```
不依赖外部，需要隔离外部依赖，对函数或者方法单独做测试。
外部包含：
1. 数据库
2. 一个app服务器（或者任何类型的服务器）
3. 文件/网络 I/O或者文件系统
4. 另外的应用
5. 控制台（System.out,system.err等等）
6. 日志
7. 大多数其他类
```

- 单元测试建议
```
1. 越重要的代码，越要写单元测试；
2. 代码做不到单元测试，多思考如何改进，而不是放弃；
3. 边写业务代码，边写单元测试，而不是完成整个新功能后再写；
4. 多思考如何改进、简化测试代码。
```

- 什么样的代码不能做单元测试？
```
函数，方法依赖其他类，但没有做好对其他类的隔离。比如：直接在方法中new一个依赖类出来，正确的方式，依赖类的接口通过方法的一个参数。
```

- 与系统测试比较
```
应用系统，数据库系统等多系统联合起来做测试。比如观测系统某个外部接口返回是否符合预期。
形如swagger工具：https://petstore.swagger.io/?_ga=2.181287012.2138967229.1548914867-1298560747.1548914867
```

- 表单驱动工具gotests
```
go get -u github.com/cweill/gotests/...
常用命令方法:
gotests -all -w texttoaudio_test.go texttoaudio.go // 为源码texttoaudio.go所有方法都生成测试
gotests -only "GetAudioPath" texttoaudio.go // 仅为GetAudioPath方法生成测试
```

- 官方mock工具gomock, 推荐使用 testify (https://github.com/stretchr/testify)
```
文档：https://godoc.org/github.com/golang/mock/gomock
常用命令：
mocgen -destination=textTask_mock.go texttoaudio/server/models TextTaskInf //为texttoaudio/server/models下的接口TextTaskInf 生成mock类
mock出stuct的InfoTextTaskKeyStatus方法
func TextTexttoaudio_GetAudioPath(t *testing.T) {
   mockCtrl := gomock.NewController(t)
   defer mockCtrl.Finish()

   textTaskStuct := mock_models.NewMockTextTaskInf(mockCtrl)
   textTaskStuct.EXPECT().InfoTextTaskKeyStatus(gomock.Any(),gomock.Any).Return(nil)
}
```

- 数据库mock库go-sqlmock
```
文档：https://godoc.org/gopkg.in/DATA-DOG/go-sqlmock.v1
mock出数据库
func TestTextWorker_CreateTextWorker(t *testing.T) {
  db, mock, _ := sqlmock.New()
  gormDb, _ := gorm.Open("mysql", db)
}
对select进行mock
func TestNewMtlProductWithId(t *testing.T) {
	db, mock, _ := sqlmock.New()
	gormDb, _ := gorm.Open("mysql", db)
	t.Run("success", func(t *testing.T) {
		columns := []string{"id", "name", "asset"}
		rows := sqlmock.NewRows(columns).AddRow(1, "mtl", "SIPC")
		mock.ExpectQuery("^SELECT (.+) FROM `mtl_product`").WithArgs(1).WillReturnRows(rows)
		got := NewMtlProductWithId(gormDb.Debug(), 1)

		if got.ID != 1 || got.Name != "mtl" || got.Asset != "SIPC" {
			t.Error("NewMtlProductWithId")
		}
		t.Log(got.ID, got.Name, got.Asset)
	})
}
func TestMtlLockPositionsList_ListMtlLockPositionsWithExpireTime(t *testing.T) {
	db, mock, _ := sqlmock.New()
	gormDb, _ := gorm.Open("mysql", db)
	t.Run("listSuccess", func(t *testing.T) {
		now := time.Now()
		yesterday := now.Add(-time.Hour * 24)
		columns := []string{"created_at","updated_at", "user_id", "product_id", "asset", "amount", "expire_time", "remark", "status"}
		rows := sqlmock.NewRows(columns).
			AddRow(yesterday, yesterday, 12345, 2, "SIPC", "100", now.Add(-time.Hour * 18), "remark1", 0).
			AddRow(yesterday, yesterday, 12346, 2, "SIPC", "100", now.Add(-time.Hour * 18), "remark2", 1)
		mock.ExpectQuery("^SELECT (.+) FROM `mtl_lock_positions`").WillReturnRows(rows)
		list, err := ListMtlLockPositionsWithExpireTime(gormDb.Debug(), 0, time.Now(), 10, 0)
		if err != nil {
			t.Error("ListMtlLockPositionsWithExpireTime, err", err)
		}
		t.Log(*list)
		if len(*list) != 1 {
			t.Error("ListMtlLockPositionsWithExpireTime")
		} else {
			t.Log(*list)
		}
	})
}
对update进行Mock
func TestMtlProduct_UpdateIncResAssetAmountWithId(t *testing.T) {
	db, mock, _ := sqlmock.New()
	gormDb, _ := gorm.Open("mysql", db)
	t.Run("UpdateSuccess", func(t *testing.T) {
		mock.ExpectBegin()
		mock.ExpectExec("UPDATE `mtl_product` SET `res_asset_amount`").WillReturnResult(sqlmock.NewResult(0, 2))
		mock.ExpectCommit()
		this := &MtlProduct{
			ID:1,
		}
		if err := this.UpdateIncResAssetAmountWithId(gormDb.Debug(), 100); err != nil {
			t.Error("UpdateIncResAssetAmountWithId")
		}
	})
	t.Run("UpdateFail", func(t *testing.T) {
		mock.ExpectBegin()
		mock.ExpectExec("UPDATE `mtl_product` SET `res_asset_amount`").WillReturnError(fmt.Errorf("%s", "db lost"))
		mock.ExpectCommit()
		this := &MtlProduct{
			ID:1,
		}
		if err := this.UpdateIncResAssetAmountWithId(gormDb.Debug(), 100); err == nil {
			t.Error("UpdateIncResAssetAmountWithId")
		}
	})
}
对insert进行mock
func TestMtlInvestLog_Create(t *testing.T) {
	db, mock, _ := sqlmock.New()
	gormDb, _ := gorm.Open("mysql", db)
	t.Run("createSuccess", func(t *testing.T) {
		mock.ExpectBegin()
		mock.ExpectExec("INSERT INTO `mtl_invest_log`").WillReturnResult(sqlmock.NewResult(10001, 0))
		mock.ExpectCommit()
		investLog := NewMtlInvestLog()
		investLog.UId = 109780
		investLog.ProductID = 2
		investLog.SiteID = 1
		investLog.DepositTime = time.Now()
		investLog.Asset = "SIPC"
		investLog.Amount = 100.01
		investLog.ExpectedYearEarning = 1.02
		investLog.PayoutAccount = 1
		investLog.PayoutType = 1
		investLog.UnlockTime = time.Now().Add(time.Hour * 24 * 360)
		investLog.NowEarning = 100
		investLog.Type = 1
		investLog.PayoutTime = time.Now().Add(time.Hour * 24)
		investLog.OrderNumber = "111"
		if err := investLog.Create(gormDb.Debug()); err != nil {
			t.Fatal("investLog.Create error", err)
		} else {
			t.Log(investLog.ID)
		}
	})
	t.Run("createFail", func(t *testing.T) {
		mock.ExpectBegin()
		mock.ExpectExec("INSERT INTO `mtl_invest_log`").WillReturnError(fmt.Errorf("%s", "db lost"))
		mock.ExpectCommit()
		investLog := NewMtlInvestLog()
		investLog.UId = 109780
		investLog.ProductID = 2
		investLog.SiteID = 1
		investLog.DepositTime = time.Now()
		investLog.Asset = "SIPC"
		investLog.Amount = 100.01
		investLog.ExpectedYearEarning = 1.02
		investLog.PayoutAccount = 1
		investLog.PayoutType = 1
		investLog.UnlockTime = time.Now().Add(time.Hour * 24 * 360)
		investLog.NowEarning = 100
		investLog.Type = 1
		investLog.PayoutTime = time.Now().Add(time.Hour * 24)
		investLog.OrderNumber = "111"
		if err := investLog.Create(gormDb.Debug()); err == nil {
			t.Fatal("investLog.Create error", err)
		} else {
			t.Log(investLog.ID)
		}
	})
}
```

- 推荐使用testify构建单元测试 (https://github.com/stretchr/testify)
```
1. 提供suite, 可以做初始化工作
2. 提供assert断言功能，可以少写许多断言类代码
3. 提供mock功能，前提是你写的代码能够被mock（依赖接口）
- 示例，suite/doc.go文件也提供了一个示例
type MtlLockPositionsListSuite struct {
	suite.Suite
	
	gormDb *gorm.DB
}
func (m *MtlLockPositionsListSuite)SetupTest()  {
	var err error
	db, mock, _ := sqlmock.New()
	m.gormDb, err = gorm.Open("mysql", db)
	if err != nil {
		m.Suite.Fail("gorm Open")
	}
	m.gormDb = m.gormDb.Debug()

	now := time.Now()
	yesterday := now.Add(-time.Hour * 24)
	columns := []string{"created_at","updated_at", "user_id", "product_id", "asset", "amount", "expire_time", "remark", "status"}
	rows := sqlmock.NewRows(columns).
		AddRow(yesterday, yesterday, 12345, 2, "SIPC", "100", now.Add(-time.Hour * 18), "remark1", 0).
		AddRow(yesterday, yesterday, 12346, 2, "SIPC", "100", now.Add(-time.Hour * 18), "remark2", 1)
	mock.ExpectQuery("^SELECT (.+) FROM `mtl_lock_positions`").WillReturnRows(rows)
}
func (m *MtlLockPositionsListSuite)TestListMtlLockPositionsWithExpireTime() {
	m.T().Run("listSuccess", func(t *testing.T) {
		list, err := ListMtlLockPositionsWithExpireTime(m.gormDb, 0, time.Now(), 10, 0)
		assert.Equal(m.T(), nil, err, "ListMtlLockPositionsWithExpireTime Error")
		assert.Equal(m.T(), 2, len(*list), "ListMtlLockPositionsWithExpireTime")
	})
}
func TestMtlLockPositionsListSuite(t *testing.T)  {
	suite.Run(t, new(MtlLockPositionsListSuite))
}
```

- 执行单元测试
```
go test -v . 	运行当前目录下所有测试文件的测试函数，必须当前路径下有测试文件，子文件夹里的测试文件不会检测到
go test -v ./… 	遍历运行当前目录下所有子文件夹内的测试函数
go test -v filename_test.go 	运行当前目录下某个测试文件里的所有测试函数

-v: 显示通过的详细测试信息，默认只显示错误信息以及通过的概要
```


### golang正则

- 参考文章
```
1. https://studygolang.com/articles/10722
2. https://juejin.im/post/58db5f9ab123db199f54e1e5
```


- 参考文章
```
1. https://www.cnblogs.com/golove/p/3269099.html
2. https://www.cnblogs.com/golove/p/3270918.html
```

- 正则二种形式使用
```
形式1：使用函数：
// 判断在 b（s、r）中能否找到 pattern 所匹配的字符串
func Match(pattern string, b []byte) (matched bool, err error)
func MatchString(pattern string, s string) (matched bool, err error)
func MatchReader(pattern string, r io.RuneReader) (matched bool, err error)

形式2：使用编译：- 推荐使用
func MustCompile(expr string) (*Regexp, error)
func MustCompilePOSIX(expr string) (*Regexp, error)
```

- 注意
```
// POSIX 语法不支持 Perl 的语法格式：\d、\D、\s、\S、\w、\W
// POSIX 最长匹配
```
```
package regexpt

import (
	"regexp"
	"testing"
)

func TestMatchString(t *testing.T)  {
	t.Log(regexp.MatchString(`1\d2`, "zzz123zzz"))
}

func TestQuoteMeta(t *testing.T)  {
	t.Log(regexp.QuoteMeta(`1\d2`))
}

// https://www.cnblogs.com/yalibuxiao/p/4194881.html
// posix和perl标准的正则表达式区别;
func TestCompile(t *testing.T)  {
	pat := `\d+`
	reg, CompileErr := regexp.Compile(pat)
	if CompileErr != nil {
		t.Fatal(CompileErr)
	}

	t.Log(reg.String())

	bs := "zzz1234zz11z"
	t.Log(reg.FindString(bs))

	reg.Longest()
	t.Log(reg.MatchString(bs))
	t.Log(reg.FindAllString(bs,-1))
	t.Log(reg.ReplaceAllString(bs, "bbbbb"))

}



```

### panic与recover

- 直接上代码

```
func returnPanic() error {
  panic(errors.New("panic"))
}

func TestPanic(t *testing.T) {
  defer func() {
    if r := recover(); r!= nil {
      if err, ok := r.(error); ok {
        // do something
        fmt.Println(err.Error())
      }
    }
  }()
  
  returnPanic();
}
```

### sync

- 两种锁Mutex （互斥锁）和RWMutex（读写锁）
```
参考文章：https://blog.csdn.net/chenbaoke/article/details/41957725
```

- pool,有一个NEW属性，New对应的闭包只会生成一次
```
package main

import (
	"bytes"
	"io"
	"os"
	"sync"
	"time"
)

var bufPool = sync.Pool{
	New: func() interface{} {
		// The Pool's New function should generally only return pointer
		// types, since a pointer can be put into the return interface
		// value without an allocation:
		return new(bytes.Buffer)
	},
}

// timeNow is a fake version of time.Now for tests.
func timeNow() time.Time {
	return time.Unix(1136214245, 0)
}

func Log(w io.Writer, key, val string) {
	b := bufPool.Get().(*bytes.Buffer)
	b.Reset()
	// Replace this with time.Now() in a real logger.
	b.WriteString(timeNow().UTC().Format(time.RFC3339))
	b.WriteByte(' ')
	b.WriteString(key)
	b.WriteByte('=')
	b.WriteString(val)
	w.Write(b.Bytes())
	bufPool.Put(b)
}

func main() {
	Log(os.Stdout, "path", "/search?q=flowers")
}

```

- waitGroup Add() Done() Wait(),等待所有的任务完成
```
package main

import (
	"sync"
)

type httpPkg struct{}

func (httpPkg) Get(url string) {}

var http httpPkg

func main() {
	var wg sync.WaitGroup
	var urls = []string{
		"http://www.golang.org/",
		"http://www.google.com/",
		"http://www.somestupidname.com/",
	}
	for _, url := range urls {
		// Increment the WaitGroup counter.
		wg.Add(1)
		// Launch a goroutine to fetch the URL.
		go func(url string) {
			// Decrement the counter when the goroutine completes.
			defer wg.Done()
			// Fetch the URL.
			http.Get(url)
		}(url)
	}
	// Wait for all HTTP fetches to complete.
	wg.Wait()
}
```

- once.Do(func()) func只执行一次
```
package main
import (
	"fmt"
	"sync"
)
func main() {
	var once sync.Once
	onceBody := func() {
		fmt.Println("Only once")
	}
	done := make(chan bool)
	for i := 0; i < 10; i++ {
		go func() {
			once.Do(onceBody)
			done <- true
		}()
	}
	for i := 0; i < 10; i++ {
		<-done
	}
}
print: Only once
```


### go mod

- ref
```
https://segmentfault.com/a/1190000018398763?utm_source=tag-newest
```

- require
```

    Go语言版本 >= 1.11
    设置环境变量 GO111MODULE=on

```

- go mod init
```

    创建foo路径，位置任意
    进入foo目录，执行go mod init github.com/liujianping/foo即可。

```

- go.mod
```

    module
    to define the module path;
    go
    to set the expected language version;
    require
    to require a particular module at a given version or later;
    exclude
    to exclude a particular module version from use; and
    replace
    to replace a module version with a different module version.

```

- sample
```
module my/thing
go 1.12
require other/thing v1.0.2
require new/thing/v2 v2.3.4
exclude old/thing v1.2.3
replace bad/thing v1.4.5 => good/thing v1.4.5
```

- go mod sample
```
1. go mod init / go mod init github.com/foo/bar
2. go mod tidy
3. go mod vender
4. go build -mod=vender -o main xxx.go

```

### go pprof

> 这篇文章讲的很透彻
>
> https://cizixs.com/2017/09/11/profiling-golang-program/

### cpu profile展示了函数在cpu的耗时占用情况

#### 用http请求得到cpu profile文件-线上采用

> 安装install graphviz看图更加直观

- 代码准备：起一个6060的监听服务

```golang
import _ "net/http/ppof"
go func() {
  http.ListenAndSever("localhost:6060", nil)
}
```

- 获取cpu profile文件和分析cpu profile文件

```
可以直接在网页上查看：http://localhost:6060/debug/pprof/
或者
收集pprof分析结果：go tool pprof ./gateway http://localhost:6060/debug/pprof/profile
通过web展示分析结果:
go tool pprof -http=:8080 pprof.gateway.samples.cpu.001.pb.gz 
通过cli展示分析结果：

```

#### 用go test单元测试得到cpu profile文件

执行单个go文件中具体一个测试方法

```bash
$ go test -v -run TestEthRpcClient_GetTransactionByHash -cpuprofile=cpu.prof transactions_test.go transactions.go rpc.go
```



#### 使用runtime的pprof包获取cpu profile文件

> 上面针对http服务，非http服务就要采用这种方式

```
var cpuprofile = flag.String("cpuprofile", "", "write cpu profile to `file`")
var memprofile = flag.String("memprofile", "", "write memory profile to `file`")

func main() {
	flag.Parse()
	if *cpuprofile != "" {
		f, err := os.Create(*cpuprofile)
		if err != nil {
			log.Fatal("could not create CPU profile: ", err)
		}
		defer f.Close()
		if err := pprof.StartCPUProfile(f); err != nil {
			log.Fatal("could not start CPU profile: ", err)
		}
		defer pprof.StopCPUProfile()
	}

	if *memprofile != "" {
		f, err := os.Create(*memprofile)
		if err != nil {
			log.Fatal("could not create memory profile: ", err)
		}
		defer f.Close()
		runtime.GC() // get up-to-date statistics
		if err := pprof.WriteHeapProfile(f); err != nil {
			log.Fatal("could not write memory profile: ", err)
		}
	}
}
```

- 采集profile数据
```
./fortest --cpuprofile=cpuprofile --memprofile=memprofile
pprof cpuprofile
```

#### 使用火焰图展示cpu profile

```bash
 1、 安装go-torch
            go get github.com/uber/go-torch
    2、安装FlameGraph
           git clone https://github.com/brendangregg/FlameGraph.git
			$ vim ~/.profile
         export PATH=$PATH:~/local/FlameGraph 【这步一定要设置，生成火焰图时会用到】
    3、安装graphviz (CentOS, Redhat) 
          apt install graphviz
```

采集profile文件

```
$ go tool pprof ./pprof http://localhost:6060/debug/pprof/profile
或者来自go test
$ go test -v -run TestEthRpcClient_GetTransactionByHash -cpuprofile=cpu.prof -memprofile=mem.pro transactions_test.go transactions.go rpc.go
```

输出火焰图svg

```
$ go-torch -b ./pprof.gateway.samples.cpu.001.pb.gz -f 04.svg
```

#### 总结

​		采集profile数据，最实用方式通过单元测试，预发布环境在runtime的pprof包。

#### 创建性能分析镜像

> https://github.com/znddzxx112/go-profile

```Dockerfile
FROM golang:1.13.5

WORKDIR /go
ENV GOPROXY https://goproxy.cn
ENV GO111MODULE on
ENV GOBIN $GOPATH/bin

RUN apt update && apt install -y graphviz git && mkdir pprof && go get github.com/uber/go-torch
RUN git clone https://github.com/brendangregg/FlameGraph.git

ENV PATH $PATH:/go/FlameGraph

CMD ["go-torch"]
```



### flag

- Package flag implements command-line flag parsing
```
package main

import (
	"flag"
	"fmt"
)

var cpuprofile string
var enableProfile bool

func init()  {
	flag.StringVar(&cpuprofile, "cpuprofile", "cpuprofile", "cpu profile name")
	flag.BoolVar(&enableProfile, "enableProfile", false, "enableProfile")
}

func main()  {
	flag.Parse()

	if cpuprofile != "" {
		fmt.Println(cpuprofile)
	}

	if enableProfile {
		fmt.Print(enableProfile)
	}
	fmt.Println(flag.Args())
}

```

- use
```
go run flag.go --cpuprofile=cpupp --enableProfile=false hello foo
```

### time 

```
package timet

import (
	"fmt"
	"testing"
	"time"
)

func TestTime(t *testing.T) {
	now := time.Now()
	t.Log(now)
	t.Log(now.Format("2006-01-02 15:04:05"))
	t.Log(now.Format("2006-1-2 15:4:5"))
	t.Log(now.Date())
	t.Log(now.Clock())
	t.Log(now.Year())
	t.Log(now.Month().String())
	t.Log(now.Day())
	t.Log(now.YearDay())
	t.Log(now.Hour())
	t.Log(now.Minute())
	t.Log(now.Second())
	t.Log(now.Weekday().String())
	t.Log(now.Unix())
	t.Log(now.UnixNano())
	t.Log(now.Nanosecond())
}

func TestLocation(t *testing.T) {
	now := time.Now()
	t.Log(now.Format("2006-01-02 15:04:05"))
	t.Log(now.Location().String())
	t.Log(now.UTC().Location().String())
	t.Log(now.In(now.UTC().Location()).Format("2006-01-02 15:04:05"))

	loc := time.FixedZone("UTC", 8*3600)
	t.Log(now.In(loc).Format("2006-01-02 15:04:05"))

	location, _ := time.LoadLocation("Local")
	t.Log(now.In(location).Format("2006-01-02 15:04:05"))

}

func TestTimeCal(t *testing.T) {
	now := time.Now()
	t.Log(now.Format("2006-01-02 15:04:05"))

	duration, _ := time.ParseDuration("1h")
	afterNow := now.Add(duration)
	t.Log(afterNow.Format("2006-01-02 15:04:05"))

	d, _ := time.ParseDuration("-1h")
	beforNow := now.Add(d)
	t.Log(beforNow.Format("2006-01-02 15:04:05"))

	loc := time.FixedZone("UTC", 8*3600)
	monthStartdayTime := time.Date(now.Year(), now.Month(), 0, 24, 0, 0, 0, loc)
	t.Log(monthStartdayTime.Zone())
	t.Log(monthStartdayTime.Format(time.RFC3339))

	t.Log(monthStartdayTime.IsZero())
	t.Log(now.Equal(monthStartdayTime))
	subDuration := now.Sub(monthStartdayTime)
	t.Log(subDuration.String())
	t.Log(subDuration.Seconds())

	t.Log(now.Unix() - monthStartdayTime.Unix())
}

func TestTimer(t *testing.T) {
	timer := time.NewTimer(time.Second * 2)
	defer timer.Stop()

	tt := time.After(time.Second * 5)
	var start bool = true
	for start {
		select {
		case <- tt:
			fmt.Println("over")
			start = false
		case nowTime := <-timer.C:
			fmt.Println(nowTime.Format(time.RFC3339))
			timer.Reset(time.Second * 2)
		}
	}

}

func TestTicker(t *testing.T)  {
	ticker := time.NewTicker(time.Second * 3)
	defer ticker.Stop()

	for {
		select {
		case nowTime := <- ticker.C:
			fmt.Println(nowTime.Format(time.RFC3339))
		case nowTime := <- time.Tick(time.Second):
			fmt.Println(nowTime.Format(time.RFC3339Nano))
		}
	}
}

```


### os

```
package ost

import (
	"fmt"
	"os"
	"os/exec"
	"os/signal"
	"os/user"
	"strings"
	"syscall"
	"testing"
	"time"
)

var currentDir string

func init() {
	currentDir, _ = os.Getwd()
}

func TestFile(t *testing.T) {

	fileName := fmt.Sprintf("%s/%s", currentDir, "file.csv")
	fd, OpenFileErr := os.OpenFile(fileName, os.O_RDWR|os.O_CREATE|os.O_APPEND, 0666)
	if OpenFileErr != nil {
		t.Fatal(OpenFileErr)
	}
	defer fd.Close()

	writeHeader(fd, []string{"id", "name", "score"})
	writeBody(fd, [][]string{
		{"1", "z", "88"},
		{"2", "y", "89"},
		{"3", "x", "90"},
	})

	t.Log(fd.Fd())
	fileinfo, StatErr := fd.Stat()
	if StatErr != nil {
		t.Log(os.IsExist(StatErr))
	}
	// fileinfo
	t.Log(fileinfo.Name())
	t.Log(fileinfo.Size())
	t.Log(fileinfo.Mode())
	t.Log(fileinfo.ModTime().Format(time.RFC3339))
}

func writeHeader(fd *os.File, header []string) {
	fd.WriteString(strings.Join(header, ",") + "\n")
}

func writeBody(fd *os.File, body [][]string) {
	for _, line := range body {
		fd.WriteString(strings.Join(line, ",") + "\n")
	}
}

func TestFileUD(t *testing.T) {
	fileName := fmt.Sprintf("%s/%s", currentDir, "file")
	newFIlename := fmt.Sprintf("%s/%s", currentDir, "newfile")
	os.Create(fileName)
	if RenameErr := os.Rename(fileName, newFIlename); RenameErr != nil {
		t.Fatal(RenameErr)
	}
	if RemoveErr := os.Remove(newFIlename); RemoveErr != nil {
		t.Fatal(RemoveErr)
	}
}

func TestFileExist(t *testing.T) {
	fileNameNotExist := fmt.Sprintf("%s/%s", currentDir, "notExist")
	fdNot, fileErr := os.OpenFile(fileNameNotExist, os.O_RDONLY, 0440)
	if fileErr != nil {
		t.Log(os.IsNotExist(fileErr))
		if os.IsNotExist(fileErr) {
			t.Log("not exist")
		} else {
			t.Fatal(fileErr)
		}

	}
	defer fdNot.Close()

	var fileExist bool = true
	_, StatErr := os.Stat(fileNameNotExist)
	if StatErr != nil {
		if os.IsNotExist(StatErr) {
			fileExist = false
		}
	}
	t.Log(fileExist)
}

func TestDir(t *testing.T) {
	dir := "/tmp/dirt"
	MkdirAllErr := os.MkdirAll(dir, 0755)
	if MkdirAllErr != nil {
		if os.IsPermission(MkdirAllErr) {
			t.Log("permission")
		}
		t.Fatal(MkdirAllErr)
	}

	if ChdirErr := os.Chdir(dir); ChdirErr != nil {
		t.Fatal(ChdirErr)
	}

	now := time.Now()
	todayZoreTime := time.Date(now.Year(), now.Month(), now.Day(), 0, 0, 0, 0, time.FixedZone("UTC", 8*3600))

	if ChtimesErr := os.Chtimes(dir, todayZoreTime, todayZoreTime); ChtimesErr != nil {
		t.Fatal(ChtimesErr)
	}

	if _, CreateErr := os.Create("/tmp/test.txt"); CreateErr != nil {
		t.Fatal(CreateErr)
	}

	t.Log(os.Getwd())

}

func TestProcess(t *testing.T) {
	hostname, _ := os.Hostname()
	t.Log(hostname)
	userhome, _ := os.UserHomeDir()
	t.Log(userhome)
	usercache, _ := os.UserCacheDir()
	t.Log(usercache)
	t.Log(os.Getenv("GOPATH"))
}

func TestOsExec(t *testing.T) {
	os.Chdir("/tmp/dirt")
	cmdPath, _ := exec.LookPath("ls")
	cmd := exec.Command(cmdPath, "-al")
	byte, CombinedOutErr := cmd.CombinedOutput()
	if CombinedOutErr != nil {
		t.Fatal(CombinedOutErr)
	}
	t.Log(string(byte))

	t.Log(cmd.ProcessState.ExitCode())
	t.Log(cmd.ProcessState.String())
	t.Log(cmd.ProcessState.Pid())
	t.Log(cmd.ProcessState.Success())
}

func TestOsSignal(t *testing.T)  {
	fmt.Println(os.Getpid())
	signalChan := make(chan os.Signal)
	signal.Notify(signalChan)
	var isStart bool = true
	for isStart {
		select {
		case sig := <- signalChan:
			fmt.Println(sig.String())
			if sig == syscall.SIGQUIT || sig == syscall.SIGSTOP {
				isStart = false
			}
		}
	}
	// kill -USR2 pid
	// kill -QUIT pid
}

func TestUserAndGroup(t *testing.T)  {
	t.Log(user.Lookup("znddzxx112"))
	t.Log(user.Current())
}

```



### reflect

```
package reflectt

import (
	"reflect"
	"testing"
)
type foo struct {
	id string
	name string
}
func (f *foo) String() string {
	return f.id + f.name
}
func TestTypeOf(t *testing.T)  {

	for _, v := range []interface{}{
		8, int32(32), int64(64),
		"hello reflect", true, foo{id:"1",name:"lee"}} {
		oftype := reflect.TypeOf(v)
		t.Log(oftype.Kind().String())
		t.Log(oftype.Size())
		t.Log(oftype.Name())
		t.Log(oftype.NumMethod())
	}

}

func TestValueOf(t *testing.T)  {
	for _, v := range []interface{}{
		8, int32(32), int64(64),
		"hello reflect", true, foo{id:"1",name:"lee"}} {
		oftype := reflect.ValueOf(v)
		t.Log(oftype.Kind().String())
		t.Log(oftype.String())
	}
}

```

### context

- 参考url
```
https://deepzz.com/post/golang-context-package-notes.html
https://www.cnblogs.com/yjf512/p/10399190.html
```

- 做什么用?

```
gorotine之间传递，父取消后子也一并取消，控制goroutine的生命周期。当一个计算任务被goroutine承接了之后，由于某种原因（超时，或者强制退出）我们希望中止这个goroutine的计算任务
```

```
package contextt

import (
	"context"
	"fmt"
	"testing"
	"time"
)

func genInt(ctx context.Context, chanInt chan<- int) {
	var n int = 0
	var isStart bool = true
	for isStart {
		select {
		case <-ctx.Done():
			close(chanInt)
			isStart = false
		default:
			chanInt <- n
		}
		n++
	}
	return
}

func TestCtxCancel(t *testing.T)  {

	ctx , cancel := context.WithCancel(context.Background())

	chanInt := make(chan int, 1)
	go genInt(ctx, chanInt)

	var isStart bool = true;
	for isStart {
		select {
		case i, ok := <-chanInt:
			if !ok {
				isStart = false
			}
			fmt.Println(i)
			if i == 5 {
				cancel()
			}
		}
	}

}

func toRequest(ctx context.Context, chanInt chan<- int)  {
	var n int = 11;
	var isStart bool = true
	for isStart {
		select {
		case <-ctx.Done():
			DeadlineTime, ok := ctx.Deadline()
			fmt.Println(DeadlineTime.Format(time.RFC3339), ok)
			fmt.Println(ctx.Err())
			chanInt <- n
			isStart = false
		}
	}
}

func toRequest2(ctx context.Context, chanInt chan<- int)  {
	var n int = 12;
	var isStart bool = true
	for isStart {
		select {
		case <-ctx.Done():
			DeadlineTime, ok := ctx.Deadline()
			fmt.Println(DeadlineTime.Format(time.RFC3339), ok)
			fmt.Println(ctx.Err())
			chanInt <- n
			isStart = false
		}
	}
}

func TestCtxCancelMutli(t *testing.T){
	ctx, cancel := context.WithCancel(context.Background())

	chanInt := make(chan int, 1)
	go toRequest(ctx, chanInt)

	chanInt2 := make(chan int, 1)
	go toRequest2(ctx, chanInt2)

	cancel()
	fmt.Println(<-chanInt)
	fmt.Println(<-chanInt2)

}

func TestCtxTimeout(t *testing.T)  {
	ctx, cancel := context.WithTimeout(context.Background(), time.Second * 2)
	defer cancel()

	chanInt := make(chan int, 1)
	go toRequest(ctx, chanInt)

	chanInt2 := make(chan int, 1)
	go toRequest2(ctx, chanInt2)

	fmt.Println(<-chanInt)
	fmt.Println(<-chanInt2)
}

```


### go版本升级

- 备份原来的golang目录 & 用新版本1.13替换旧目录
```
cd /usr/local
mv go go1.12.1
sudo curl -sSL "https://studygolang.com/dl/golang/go1.13.linux-amd64.tar.gz" -o go1.13.tar.gz --progress
sudo tar -zxvf go1.13.tar.gz -C /usr/local
go env -w GOSUMDB=off //由于sum.golang.org被墙，下载包验证校验关闭
go env -w GOPROXY="https://goproxy.cn,direct" // 使用国内代理  $GOPROXY = "https://goproxy.cn,direct"
go env -w GOPRIVATE=".github.com" 
```

### parse与format时区问题

#### time.Parse()使用的是默认时区UTC

#### time.Format()使用的是本地time.Local

#### 设置时区

```golang
func SetDefaultLocation() {
	loc, err := time.LoadLocation("Asia/Shanghai")
	if err == nil {
		time.Local = loc
	}
}
```



#### 解决办法使用time.ParseInLocaltion()

```goalng
package main

import (
	"time"
	"fmt"
)

func main(){
	localTime, err := time.ParseInLocation("2006-01-02 15:04:05", "2019-11-03 01:01:02", time.Local)
	if err != nil{
		fmt.Println(err)
		return
	}
	fmt.Println(localTime)
	fmt.Println(time.Now())
	fmt.Println(time.Now().Sub(localTime).Seconds())
}
```

#### 类型与字面量

##### 类型

> golang来说，同类型之间才可以做加减乘除操作
>
> 不同类型之间，需要做一些类型转化，都是显式转换。不是隐式转换。

字面量

> 字面量可以被多个类型接受。
>
> 比如：
>
> var i int = 1
>
> var f float64 = 1
>
> var b byte = 'z'
>
> 1是字面量（十进制） i,f是变量。
>
> 0x11(16进制) 0b10（2进制）‘z’ Ascall码

