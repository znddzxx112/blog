[TOC]



## rocketmq-client-go项目

### 生产者和消费者的参数设置

用一段代码作为例子来说明是如何进行进行参数设置

> 关键词：闭包

```golang
type CoreOptions struct {
	GroupName         string
	RetryTimes        int
}

type ConsumerOptions struct {
	CoreOptions
	AutoCommit            bool
}

func defaultConsumerOptions() ConsumerOptions {
	return ConsumerOptions{
		CoreOptions : CoreOptions {
			GroupName : "default_consumer",
			RetryTimes : 2,
		},
		AutoCommit : true,
	}
}

type ConsumerOpts func(*ConsumerOptions)

func WithGroupName(name string) ConsumerOpts {
	return func(options *ConsumerOptions) {
		options.GroupName = name
	}
}

func WithAutoCommit(autoCommit bool) ConsumerOpts  {
	return func(options *ConsumerOptions) {
		options.AutoCommit = autoCommit
	}
}

func NewConsumerOptions(opts ...ConsumerOpts) ConsumerOptions  {
	options := defaultConsumerOptions()
	for _, apply := range opts {
		apply(&options)
	}
	return options
}

func main() {
	opts := NewConsumerOptions(WithGroupName("testGroup"), WithAutoCommit(false))
	fmt.Printf("%v", opts)
	return
}
```

#### 核心参数

> 生产者和消费者都会使用

> 参数解释可以看这篇文章：https://zhuanlan.zhihu.com/p/27397055

```golang
type ClientOptions struct {
	GroupName         string  // 生产者如果是事务消息，使用相同group名称来进行回查。消费者相同的订阅topic使用相同的group名称
	NameServerAddrs   primitive.NamesrvAddr // namesrv地址
	NameServerDomain  string // namesrv地址
	Namesrv           *namesrvs
	ClientIP          string //本机ip ClientID是由ClientIP+InstanceName构成
	InstanceName      string // 当前实例名称
	UnitMode          bool
	UnitName          string
	VIPChannelEnabled bool // broker的netty server会起两个通信服务。两个服务除了服务的端口号不一样，其他都一样。其中一个的端口（配置端口-2）作为vip通道，客户端可以启用本设置项把发送消息此vip通道。
	RetryTimes        int  // 请求重试次数
	Interceptors      []primitive.Interceptor // 请求拦截器
	Credentials       primitive.Credentials // 资格证书
	Namespace         string // namespace ,topic的命名空间
}
func DefaultClientOptions() ClientOptions {
	opts := ClientOptions{
		InstanceName: "DEFAULT",
		RetryTimes:   3,
		ClientIP:     utils.LocalIP,
	}
	return opts
}

```

#### 生产者参数

```golang
type producerOptions struct {
	internal.ClientOptions
	Selector              QueueSelector
	SendMsgTimeout        time.Duration // 发送的超时时间
	DefaultTopicQueueNums int // 默认选择topic第nums个队列
	CreateTopicKey        string // "TBW102" Will be created at broker when isAutoCreateTopicEnable. when topic is not created,
	// and broker open isAutoCreateTopicEnable, topic will use "TBW102" config to create topic
}
// producer的默认参数
func defaultProducerOptions() producerOptions {
	opts := producerOptions{
		ClientOptions:         internal.DefaultClientOptions(),
		Selector:              NewRoundRobinQueueSelector(),
		SendMsgTimeout:        3 * time.Second,
		DefaultTopicQueueNums: 4, // 自动创建topic的话，默认选定的queue编号
		CreateTopicKey:        "TBW102",
	}
	opts.ClientOptions.GroupName = "DEFAULT_CONSUMER"
	return opts
}
```

createTopicKey

> 配置说明：发送消息的时候，如果没有找到topic，若想自动创建该topic，需要一个key topic，这个值即是key topic的值
>
> 默认值：TBW102
>
> 这是RocketMQ设计非常晦涩的一个概念，整体的逻辑是这样的：
>
> 生产者正常的发送消息，都是需要topic预先创建好的
> 但是RocketMQ服务端是支持，发送消息的时候，如果topic不存在，在发送的同时自动创建该topic
> 支持的前提是broker 的配置打开autoCreateTopicEnable=true
> autoCreateTopicEnable=true后，broker会创建一个TBW102的topic，这个就是我们讲的默认的key topic

可以看到producer的默认参数

> InstanceName: "DEFAULT",
> RetryTimes:   3,
> ClientIP:     utils.LocalIP,
> Selector:              NewRoundRobinQueueSelector(),
> SendMsgTimeout:        3 * time.Second,
> DefaultTopicQueueNums: 4,
> CreateTopicKey:        "TBW102",

#### 消费者参数

```golang
type consumerOptions struct {
	internal.ClientOptions
	ConsumeTimestamp string
	ConsumerPullTimeout time.Duration
	ConsumeConcurrentlyMaxSpan int
	PullThresholdForQueue int64
	PullThresholdSizeForQueue int
	PullThresholdForTopic int
	PullThresholdSizeForTopic int
	// 拉消息间隔时间
	PullInterval time.Duration
	// 批量消费条数
	ConsumeMessageBatchMaxSize int
	// 每次拉消息条数
	PullBatchSize int32
	// 每次拉消息时是否同步订阅消息
	PostSubscriptionWhenPull bool
	// 一条消息被消费次数
	MaxReconsumeTimes int32
	// Suspending pulling time for cases requiring slow pulling like flow-control scenario.
	SuspendCurrentQueueTimeMillis time.Duration
	// 消费超时时间
	ConsumeTimeout time.Duration
	// 消费模式 //集群消费还是广播消费
	ConsumerModel  MessageModel
	// 消费策略
	Strategy       AllocateStrategy
	// 消费顺序
	ConsumeOrderly bool
	// 从哪里开始消费，从头开始消费，还是从尾部开始消费
	FromWhere      ConsumeFromWhere
	// 拦截器
	Interceptors []primitive.Interceptor
	// 连续消费最大次数
	MaxTimeConsumeContinuously time.Duration
	// 自动提交
	AutoCommit            bool
	// 未知
	RebalanceLockInterval time.Duration
}
```

默认参数

```golang
func defaultPushConsumerOptions() consumerOptions {
	opts := consumerOptions{
		ClientOptions:              internal.DefaultClientOptions(),
		// 策略
		Strategy:                   AllocateByAveragely,
		// 1分钟
		MaxTimeConsumeContinuously: time.Duration(60 * time.Second),
		RebalanceLockInterval:      20 * time.Second,
		MaxReconsumeTimes:          -1, // 16次
		ConsumerModel:              Clustering,//集群消费
		AutoCommit:                 true,//自动提交
	}
	opts.ClientOptions.GroupName = "DEFAULT_CONSUMER"
	return opts
}
```



### 日志

#### 接口与实现

先定义日志接口

```golang
type Logger interface {
	Debug(msg string, fields map[string]interface{})
	Info(msg string, fields map[string]interface{})
	Warning(msg string, fields map[string]interface{})
	Error(msg string, fields map[string]interface{})
	Fatal(msg string, fields map[string]interface{})
}
```

实现一个默认日志结构体

```golang
type defaultLogger struct {
	logger *logrus.Logger
}
func (l *defaultLogger) Debug(msg string, fields map[string]interface{}) {}
func (l *defaultLogger) Info(msg string, fields map[string]interface{}) {}
func (l *defaultLogger) Warning(msg string, fields map[string]interface{}) {}
func (l *defaultLogger) Error(msg string, fields map[string]interface{}) {}
func (l *defaultLogger) Fatal(msg string, fields map[string]interface{}) {}
```

#### 单例模式与门面模式

> golang导入包后会执行init()，利用这一点实现单例

```
var rLog Logger
func init() {
	r := &defaultLogger{
		logger: logrus.New(),
	}
	rLog = r // 默认日志
}
// 还可以自定义默认日志
func SetLogger(logger Logger) {
	rLog = logger
}
//门面模式
func Debug(msg string, fields map[string]interface{}) {
	rLog.Debug(msg, fields)
}
```

### 生产者队列选择器

#### 多态

> 定义接口、多个实现接口的结构体

```golang
type QueueSelector interface {
	Select(*primitive.Message, []*primitive.MessageQueue) *primitive.MessageQueue
}
// 第一个结构体
type manualQueueSelector struct{}
func NewManualQueueSelector() QueueSelector {
	return new(manualQueueSelector)
}
func (manualQueueSelector) Select(message *primitive.Message, queues []*primitive.MessageQueue) *primitive.MessageQueue {
	return message.Queue
}
// randomQueueSelector choose a random queue each time.
type randomQueueSelector struct {
	rander *rand.Rand
}
// roundRobinQueueSelector choose the queue by roundRobin.
type roundRobinQueueSelector struct {
	sync.Locker
	indexer map[string]*int32
}
type hashQueueSelector struct {
	random QueueSelector
}
```

### 拦截器-Interceptor

#### 闭包

> 责任连模式、类似中间件实现、type func
>
> 本质参数传递的是闭包

### 全局异常处理

```golang
type PanicHandler func(interface{})

func WithRecover(fn func()) {
	defer func() {
		handler := PanicHandler
		if handler != nil {
			if err := recover(); err != nil {
				handler(err)
			}
		}
	}()

	fn()
}

func main() {
	PanicHandler = func(err interface{}) {
		log.Println(err)
	}
	WithRecover(func() {
		panic("i am panic")
	})
}
```

### 通讯部分

#### 标志位

> 关键词：位操作，是否存在标志位，加上标志

请看例子

```golang
// 存在以下标志位
const ResponseType = 1
const ResponseType2 = 1<<1
const ResponseType3 = 1<<2
const ResponseType4 = 1<<3
const ResponseType5 = 1<<4
// 判断是否有ResponseType3标记
func isResponseType3(flag int) bool {
	return (ResponseType3 & flag) == ResponseType3
}
// 标记上ResponseType3
func markResponseType3(flag int) int {
	return ResponseType3 | flag
}
func main() {
	log.Printf("%v", isResponseType3(3))// false
	log.Printf("%v", isResponseType3(7))// true
	log.Printf("%v", markResponseType3(3))//7
	log.Printf("%v", markResponseType3(1))//5
}
```

#### 协议格式

```
// Frame format:
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + item | frame_size | header_length |         header_body        |     body     +
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + len  |   4bytes   |     4bytes    | (21 + r_len + e_len) bytes | remain bytes +
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
```

> 协议分成4个部分
>
> frame_size：4个字节表示整体长度,除了frame_size自身4个字节
>
> header_length：4个字节表示header长度
>
> header_body：用json序列化后数据具体标识整个通讯请求的元数据，如请求什么，怎样的方式请求（异步/oneway）请求客户端的版本，语言，请求的具体参数等
>
> body:byte数组，二进制数据，消息传递过程中真正的数据

> RemotingCommand结构体包含header+body

```golang
type RemotingCommand struct {
	Code      int16             `json:"code"` // 请求/响应码
	Language  LanguageCode      `json:"language"` // 开发语言
	Version   int16             `json:"version"` //版本号，可用于兼容老版本
	Opaque    int32             `json:"opaque"`//请求标识码，不断自增的整形
	Flag      int32             `json:"flag"` //按bit解析第0位标识是这次通信是request还是response，0标识request, 1 标识response。
	Remark    string            `json:"remark"`//附带的文本信息，一些异常信息
	ExtFields map[string]string `json:"extFields"`// 这个字段不通的请求/响应不一样，完全自定义
	Body      []byte            `json:"-"`
}
```

#### 协议编码

> 关键词：大端序

看懂代码例子

```golang
type RemotingCommand struct {
	Code      int16             `json:"code"` // 请求/响应码
	Language  byte      `json:"language"` // 开发语言
	Version   int16             `json:"version"` //版本号，可用于兼容老版本
	Opaque    int32             `json:"opaque"`//请求标识码，不断自增的整形
	Flag      int32             `json:"flag"` //按bit解析第0位标识是这次通信是request还是response，0标识request, 1 标识response。
	Remark    string            `json:"remark"`//附带的文本信息，一些异常信息
	ExtFields map[string]string `json:"extFields"`// 这个字段不通的请求/响应不一样，完全自定义
	Body      []byte            `json:"-"`
}
func (cmd *RemotingCommand) isResponseType() bool {
	return (ResponseType & cmd.Flag) == ResponseType
}
// 标记上ResponseType3
func (cmd *RemotingCommand) markResponseType() {
	cmd.Flag = cmd.Flag | ResponseType
}

func encode(cmd *RemotingCommand) ([]byte, error) {
	header, err := json.Marshal(cmd)
	if err != nil {
		return nil, err
	}
	frameSize := 4 + len(header) + len(cmd.Body)
	buf := bytes.NewBuffer(make([]byte, frameSize))
	buf.Reset()// 让buf置空

	if err := binary.Write(buf, binary.BigEndian, int32(frameSize)); err != nil{
		return nil, err
	}
	if err := binary.Write(buf, binary.BigEndian, int32(len(header))); err != nil{
		return nil, err
	}
	if err := binary.Write(buf, binary.BigEndian, header); err != nil{
		return nil, err
	}
	if err := binary.Write(buf, binary.BigEndian, cmd.Body); err != nil{
		return nil, err
	}
	return buf.Bytes(), nil
}

func main() {
	extFields := make(map[string]string, 0)
	extFields["foo"] = "bar"
	body := []byte("hello foo")
	cmd := &RemotingCommand {
		Code: 301,
		Language: byte(1),
		Version: 317,
		Opaque:atomic.AddInt32(&opaque, 1),
		Flag:int32(0),
		Remark:"",
		ExtFields: extFields,
		Body:body,
	}
	bs, _ := encode(cmd)
	log.Printf("%x", bs)
}
```

#### 协议解码

```golang
// data := AllData[4:]
func decode(data []byte) (*RemotingCommand, error) {
	buf := bytes.NewBuffer(data)
	length := int32(len(data))
	var oriHeaderLen int32
	if err := binary.Read(buf, binary.BigEndian, &oriHeaderLen); err != nil {
		return nil, err
	}
	headerLength := oriHeaderLen & 0xFFFFFF
	header := make([]byte, headerLength)
	if err := binary.Read(buf, binary.BigEndian, &header); err != nil {
		return nil, err
	}
	cmd := &RemotingCommand{}
	if err := json.Unmarshal(header, cmd); err != nil {
		return nil, err
	}

	bodyLength := length - 4 - headerLength
	if bodyLength > 0 {
		body := make([]byte, bodyLength)
		if err := binary.Read(buf, binary.BigEndian, &body); err != nil {
			return nil, err
		}
		cmd.Body = body
	}
	return cmd, nil

}
func main() {
	extFields := make(map[string]string, 0)
	extFields["foo"] = "bar"
	body := []byte("hello foo")
	cmd := &RemotingCommand {
		Code: 301,
		Language: byte(1),
		Version: 317,
		Opaque:atomic.AddInt32(&opaque, 1),
		Flag:int32(0),
		Remark:"",
		ExtFields: extFields,
		Body:body,
	}
	bs, _ := encode(cmd)
	log.Printf("%x", bs)
	command, err := decode(bs[4:])
	if err != nil {
		log.Fatal(err)
	}
	log.Printf("%v", command)
}
```



#### 底层客户端

> 关键结构体：
>
> tcpConnWrapper ：控制具体tcp连接初始化，销毁
>
> RemotingCommand：包含通讯协议各个字段，协议编码和解码
>
> ResponseFuture: 控制RemotingCommand同步或者异步发送、接受响应、响应超时处理
>
> remotingClient:map结构维护长连接，map结构保存发送请求表，map结构保存请求处理函数
>
> 它是脱离生产者和消费者的业务逻辑，关注请求发送与响应

tcp长连接初始化和断开，请看例子

```golang
type tcpConnWrapper struct {
	net.Conn
	closed atomic.Bool
}

func initConn(ctx context.Context, addr string) (*tcpConnWrapper, error) {
	var d net.Dialer
	conn, err := d.DialContext(ctx, "tcp", addr)
	if err != nil {
		return nil, err
	}
	return &tcpConnWrapper{
		Conn: conn,
	}, nil
}

func (wrapper *tcpConnWrapper) destroy() error {
	wrapper.closed.Swap(true)
	return wrapper.Conn.Close()
}

func (wrapper *tcpConnWrapper) isClosed() bool {
	if !wrapper.closed.Load() {
		return false
	}
	return true
}

func main() {
	ctx, _ := context.WithTimeout(context.Background(), time.Millisecond * 1000)
	wrapper, err := initConn(ctx, "182.61.200.6:80")
	if err != nil {
		log.Fatal(err)
	}
	wrapper.destroy()
	log.Println(wrapper.isClosed())
}
```

看下ResponseFuture结构体，控制RemotingCommand同步或者异步发送、接受响应、响应超时处理

```
// ResponseFuture
type ResponseFuture struct {
	ResponseCommand *RemotingCommand
	Err             error
	Opaque          int32
	callback        func(*ResponseFuture)
	Done            chan bool
	callbackOnce    sync.Once
	ctx             context.Context
}

// NewResponseFuture create ResponseFuture with opaque, timeout and callback
func NewResponseFuture(ctx context.Context, opaque int32, callback func(*ResponseFuture)) *ResponseFuture {
	return &ResponseFuture{
		Opaque:   opaque,
		Done:     make(chan bool),
		callback: callback,
		ctx:      ctx,
	}
}
// 执行回调函数
func (r *ResponseFuture) executeInvokeCallback() {
	r.callbackOnce.Do(func() {
		if r.callback != nil {
			r.callback(r)
		}
	})
}
// 响应超时和响应返回时的操作
func (r *ResponseFuture) waitResponse() (*RemotingCommand, error) {
	var (
		cmd *RemotingCommand
		err error
	)
	select {
	case <-r.Done:
		cmd, err = r.ResponseCommand, r.Err
	case <-r.ctx.Done():
		err = utils.ErrRequestTimeout
		r.Err = err
	}
	return cmd, err
}
```

客户端remotingClient结构体，维护长连接，发送请求表，请求处理函数

```golang

type ClientRequestFunc func(*RemotingCommand, net.Addr) *RemotingCommand

type TcpOption struct {
}

type ClientRequestFunc func(*RemotingCommand, net.Addr) *RemotingCommand

type remotingClient struct {
	responseTable    sync.Map //维护响应表	request.Opaque 请求编号 => responseFutre
	connectionTable  sync.Map // 维护着连接表 addr => tcpConnWrapper(自定义结构体)
	option           TcpOption // tcp参数
	processors       map[int16]ClientRequestFunc //处理函数
	connectionLocker sync.Mutex //建立连接时，全局锁
	interceptor      primitive.Interceptor //拦截器
}


func (c *remotingClient) RegisterRequestFunc(code int16, f ClientRequestFunc) {
	c.processors[code] = f
}

func (c *remotingClient) receiveAsync(f *ResponseFuture) {
	_, err := f.waitResponse()
	if err != nil {
		f.executeInvokeCallback()
	}
}

func (c *remotingClient) connect(ctx context.Context, addr string) (*tcpConnWrapper, error) {
	c.connectionLocker.Lock()
	defer c.connectionLocker.Unlock()
	tcpWrapper, ok := c.connectionTable.Load(addr)
	if ok {
		return tcpWrapper.(*tcpConnWrapper), nil
	}
	tcpConn, err := initConn(ctx, addr)
	if err != nil {
		return nil, err
	}
	c.connectionTable.Store(addr, tcpConn)
	WithRecover(func() {
		go c.receiveResponse(tcpConn)
	})
	return tcpConn, nil
}

func (c *remotingClient)receiveResponse(r *tcpConnWrapper) {
	var err error
	for {
		header := make([]byte, 4)
		if err != nil {
			if r.isClosed(err) {
				return
			}
			if err != io.EOF {
				log.Printf("%v", err)
			}
			c.closeConnection(r)
			r.destroy()
			break
		}

		_, err = io.ReadFull(r, header)
		if err != nil {
			continue
		}

		var length int32
		err = binary.Read(bytes.NewReader(header), binary.BigEndian, &length)
		if err != nil {
			continue
		}

		buf := make([]byte, length)

		_, err = io.ReadFull(r, buf)
		if err != nil {
			continue
		}

		cmd, err := decode(buf)
		if err != nil {
			log.Println(err)
			continue
		}
		c.processCMD(cmd, r)
	}
}

func (c *remotingClient) processCMD(cmd *RemotingCommand, r *tcpConnWrapper) {
	if cmd.isResponseType() {
		resp, exist := c.responseTable.Load(cmd.Opaque)
		if exist {
			c.responseTable.Delete(cmd.Opaque)
			responseFuture := resp.(*ResponseFuture)
			go WithRecover(func() {
				responseFuture.ResponseCommand = cmd
				responseFuture.executeInvokeCallback()
				if responseFuture.Done != nil {
					responseFuture.Done <- true
				}
			})
		}
	} else {
		f := c.processors[cmd.Code]
		WithRecover(func() {
			res := f(cmd, r.RemoteAddr())
			if res != nil {
				res.Opaque = cmd.Opaque
				res.Flag |= 1 << 0
				err := c.sendRequest(r, res)
				if err != nil {
					rlog.Warning("send response to broker error", map[string]interface{}{
						rlog.LogKeyUnderlayError: err,
						"responseCode":           res.Code,
					})
				}
			}
		})
	}
}

func (c *remotingClient) sendRequest(conn *tcpConnWrapper, request *RemotingCommand) error {
	var err error
	err = c.doRequest(conn, request)
	return err
}

func (c *remotingClient) doRequest(conn *tcpConnWrapper, request *RemotingCommand) error {
	content, err := encode(request)
	if err != nil {
		return err
	}
	_, err = conn.Write(content)
	if err != nil {
		c.closeConnection(conn)
		return err
	}
	return nil
}

func (c *remotingClient) closeConnection(toCloseConn *tcpConnWrapper) {
	c.connectionTable.Range(func(key, value interface{}) bool {
		if value == toCloseConn {
			c.connectionTable.Delete(key)
			return false
		} else {
			return true
		}
	})
}

func (c *remotingClient) ShutDown() {
	c.responseTable.Range(func(key, value interface{}) bool {
		c.responseTable.Delete(key)
		return true
	})
	c.connectionTable.Range(func(key, value interface{}) bool {
		conn := value.(*tcpConnWrapper)
		err := conn.destroy()
		if err != nil {
			rlog.Warning("close remoting conn error", map[string]interface{}{
				"remote":                 conn.RemoteAddr(),
				rlog.LogKeyUnderlayError: err,
			})
		}
		return true
	})
}
```

同步发送流程

```
func (c *remotingClient) InvokeSync(ctx context.Context, addr string, request *RemotingCommand) (*RemotingCommand, error) {
   // 从remotingClient中connectionTable获取，如果获取不到tcpConnWrapper  initConn方法中初始化
	conn, err := c.connect(ctx, addr) 
	if err != nil {
		return nil, err
	}
	// request.Opaque是请求的编号，用于收到响应时获取
	resp := NewResponseFuture(ctx, request.Opaque, nil) 
	// request保存responseTable中
	c.responseTable.Store(resp.Opaque, resp)
	// 获取到响应之后，删除请求编号
	defer c.responseTable.Delete(request.Opaque)
	// 发送请求
	err = c.sendRequest(conn, request)
	if err != nil {
		return nil, err
	}
	// 等待响应返回
	return resp.waitResponse()
}
```

看下异步发送流程

```golang
func (c *remotingClient) InvokeAsync(ctx context.Context, addr string, request *RemotingCommand, callback func(*ResponseFuture)) error {
	conn, err := c.connect(ctx, addr)
	if err != nil {
		return err
	}
	resp := NewResponseFuture(ctx, request.Opaque, callback)
	c.responseTable.Store(resp.Opaque, resp)
	err = c.sendRequest(conn, request)
	if err != nil {
		return err
	}
	// 通过协程响应返回时执行回调函数
	go WithRecover(func() {
		c.receiveAsync(resp)
	})
	return nil
}
```



#### Rocketmq内部客户端

> 会涉及具体业务事项
>
> SendHeartbeatToAllBrokerWithLock()
>
> ​		// 发送心跳
>
> UpdateTopicRouteInfo()
>
> ​		// 更新路由信息



rmqClient结构体

```
type rmqClient struct {
	option ClientOptions
	// group -> InnerProducer
	producerMap sync.Map

	// group -> InnerConsumer
	consumerMap sync.Map
	once        sync.Once

	remoteClient remote.RemotingClient
	hbMutex      sync.Mutex
	close        bool
	rbMutex      sync.Mutex
	namesrvs     *namesrvs
	done         chan struct{}
	shutdownOnce sync.Once
}
```

初始化阶段，注册处理函数

```golang
var clientMap sync.Map

func GetOrNewRocketMQClient(option ClientOptions, callbackCh chan interface{}) RMQClient {
	client := &rmqClient{
		option:       option,
		remoteClient: remote.NewRemotingClient(),
		namesrvs:     option.Namesrv,
		done:         make(chan struct{}),
	}
	actual, loaded := clientMap.LoadOrStore(client.ClientID(), client)
	if !loaded {
		client.remoteClient.RegisterRequestFunc(ReqNotifyConsumerIdsChanged, func(req *remote.RemotingCommand, addr net.Addr) *remote.RemotingCommand {

		})
		client.remoteClient.RegisterRequestFunc(ReqCheckTransactionState, func(req *remote.RemotingCommand, addr net.Addr) *remote.RemotingCommand {

		})

		client.remoteClient.RegisterRequestFunc(ReqGetConsumerRunningInfo, func(req *remote.RemotingCommand, addr net.Addr) *remote.RemotingCommand {

		})
	}
	return actual.(*rmqClient)
}
```

启动Start()

```
func (c *rmqClient) Start() {
	c.once.Do(func() {
		if !c.option.Credentials.IsEmpty() {
			c.remoteClient.RegisterInterceptor(remote.ACLInterceptor(c.option.Credentials))
		}
		// fetchNameServerAddr 每隔2分钟获取nameserverAddr地址
		// 本质向一个namesrv发送http请求获取
		// 获取的快照数据存放logs/rocketmq-go/snapshot目录下
		if len(c.option.NameServerAddrs) == 0 {
			c.namesrvs.UpdateNameServerAddress(c.option.NameServerDomain, c.option.InstanceName)
		}

		// schedule update route info 定时更新topic的路由信息
		// topic分布在哪些broker上
		go primitive.WithRecover(func() {
			// delay
			op := func() {
				c.UpdateTopicRouteInfo()
			}
		})

      // 定时清除不在topic路由中的broker
      // 定时向在topic路由中的broker发送心跳
      // 心跳：通过底层客户端向指定的addr发送一个请求
      // 心跳目的，连接不可用，能够关闭
		go primitive.WithRecover(func() {
			op := func() {
				c.namesrvs.cleanOfflineBroker()
				c.SendHeartbeatToAllBrokerWithLock()
			}
		})

		// schedule persist offset 未知
		go primitive.WithRecover(func() {
			。。。
		})

		// 未知
		go primitive.WithRecover(func() {
			。。。
	})
}
```

关闭shutdown

```golang
func (c *rmqClient) Shutdown() {
	c.shutdownOnce.Do(func() {
		close(c.done)
		c.close = true
		c.remoteClient.ShutDown()
	})
}
```

> InvokeSync(),InvokeASync()都是用底层remoteClient代为发送

### NameSrv

> 关键的几个方法
>
> UpdateNameServerAddress() 
>
> ​		// 从namesrv拿到地址并保存在快照
>
> AddBroker(routeData *TopicRouteData)  
>
> ​		//brokerAddressesMap存放对应关系 brokerName -> *BrokerData 
>
> cleanOfflineBroker() 
>
> ​		// 清除不在topic路由中的broker。依据routeDataMap sync.Map数据清除brokerAddressesMap不存在的broker
>
> UpdateTopicRouteInfo(topic string) 
>
> ​		// 向namesrv发送请求，获取最新的topic路由信息
>
> ​		// 往routeDataMap存放topic路由数据  topic=>TopicRouteData的对应关系
>
> FetchPublishMessageQueues(topic string)
>
> ​		// 未知
>
> FindBrokerAddrByTopic(topic string) string
>
> ​		// 从结构体routeDataMap sync.Map中获取broker地址
>
> FindBrokerAddrByName(brokerName string) string
>
> ​		// 从结构体brokerAddressesMap 中获取broker地址
>
> FindBrokerAddressInSubscribe(brokerName string, brokerId int64, onlyThisBroker bool)
>
> ​		// 从结构体brokerAddressesMap 中获取broker地址等数据
>
> FetchSubscribeMessageQueues(topic string) ([]*primitive.MessageQueue, error)
>
> ​		// 向namesrv请求获取到routeDataMap数据
>
> ​		// 解析后返回topic对应的队列信息

namesrv 结构体

```
type namesrvs struct {
	// namesrv addr list
	srvs []string

	// lock for getNameServerAddress in case of update index race condition
	lock sync.Locker

	// index indicate the next position for getNameServerAddress
	index int // 随机获取一个namesrv地址

	// brokerName -> *BrokerData
	brokerAddressesMap sync.Map // 着重关注，brokerName=>BrokerData对应关系

	// brokerName -> map[string]int32: brokerAddr -> version
	brokerVersionMap map[string]map[string]int32 // brokerName=>version对应关系
	// lock for broker version read/write
	brokerLock *sync.RWMutex

	//subscribeInfoMap sync.Map
	routeDataMap sync.Map   // 着重关注，存放topic路由数据 topic=>TopicRouteData的对应关系

	lockNamesrv sync.Mutex

	nameSrvClient remote.RemotingClient
}
```

```
// TopicRouteData TopicRouteData
type TopicRouteData struct {
	OrderTopicConf string
	QueueDataList  []*QueueData  `json:"queueDatas"`
	BrokerDataList []*BrokerData `json:"brokerDatas"`
}
// BrokerData BrokerData
type BrokerData struct {
	Cluster             string           `json:"cluster"`
	BrokerName          string           `json:"brokerName"`
	BrokerAddresses     map[int64]string `json:"brokerAddrs"`
	brokerAddressesLock sync.RWMutex
}
// QueueData QueueData
type QueueData struct {
	BrokerName     string `json:"brokerName"`
	ReadQueueNums  int    `json:"readQueueNums"`
	WriteQueueNums int    `json:"writeQueueNums"`
	Perm           int    `json:"perm"`
	TopicSynFlag   int    `json:"topicSynFlag"`
}
```

获取namesrv其中一个地址

> 使用轮询策略获取地址

```
func (s *namesrvs) getNameServerAddress() string {
	s.lock.Lock()
	defer s.lock.Unlock()

	addr := s.srvs[s.index]
	index := s.index + 1
	if index < 0 {
		index = -index
	}
	index %= len(s.srvs)
	s.index = index
	return strings.TrimLeft(addr, "http(s)://")
}
```



### 生产者

defaultProducer 结构体

```golang
type defaultProducer struct {
	group       string
	client      internal.RMQClient
	state       int32
	options     producerOptions
	publishInfo sync.Map
	callbackCh  chan interface{}

	interceptor primitive.Interceptor
}
```

Message结构体

```golang
type Message struct {
	Topic         string
	Body          []byte
	Flag          int32
	TransactionId string
	Batch         bool
	// Queue is the queue that messages will be sent to. the value must be set if want to custom the queue of message,
	// just ignore if not.
	Queue *MessageQueue

	properties map[string]string
	mutex      sync.RWMutex
}
```

发送同步消息

```golang
func (p *defaultProducer) SendSync(ctx context.Context, msgs ...*primitive.Message) (*primitive.SendResult, error) {
	
	...
	// 构造msg，将多个msgs合并至msg
	msg := p.encodeBatch(msgs...)
	// 构造返回结果
	resp := new(primitive.SendResult)
	...
	// 调用方法
	err := p.sendSync(ctx, msg, resp)
	return resp, err
}
func (p *defaultProducer) sendSync(ctx context.Context, msg *primitive.Message, resp *primitive.SendResult) error {
		// 重试次数
	....
		// 调用rmqclient同步发送，上文介绍过会调用底层
		res, _err := p.client.InvokeSync(ctx, addr, p.buildSendRequest(mq, msg), 3*time.Second)
		if _err != nil {
			err = _err
			continue
		}
		// 处理返回resp
		return p.client.ProcessSendResponse(mq.BrokerName, res, resp, msg)
	}
	return err
}
func (c *rmqClient) ProcessSendResponse(brokerName string, cmd *remote.RemotingCommand, resp *primitive.SendResult, msgs ...*primitive.Message) error {
	var status primitive.SendStatus
	switch cmd.Code {
	case ResFlushDiskTimeout:
		status = primitive.SendFlushDiskTimeout
	case ResFlushSlaveTimeout:
		status = primitive.SendFlushSlaveTimeout
	case ResSlaveNotAvailable:
		status = primitive.SendSlaveNotAvailable
	case ResSuccess:
		status = primitive.SendOK
	default:
		status = primitive.SendUnknownError
		return errors.New(cmd.Remark)
	}
	// 返回状态判断
	resp.Status = status
	...
	
	return nil
}
```



### 消费者

push消费者

```golang
type pushConsumer struct {
	*defaultConsumer 
	queueFlowControlTimes        int
	queueMaxSpanFlowControlTimes int
	consumeFunc                  utils.Set
	submitToConsume              func(*processQueue, *primitive.MessageQueue)
	subscribedTopic              map[string]string
	interceptor                  primitive.Interceptor
	queueLock                    *QueueLock
	done                         chan struct{}
	closeOnce                    sync.Once
}
```

初始化过程

```
func NewPushConsumer(opts ...Option) (*pushConsumer, error) {
    // 默认参数，可以参照参数解析过程
	defaultOpts := defaultPushConsumerOptions()
	...
	// 内部namesrv
	srvs, err := internal.NewNamesrv(defaultOpts.NameServerAddrs)
	....
	defaultOpts.Namesrv = srvs
	// groupName=namespace+ defaultOpts.GroupName
	if defaultOpts.Namespace != "" {
		defaultOpts.GroupName = defaultOpts.Namespace + "%" + defaultOpts.GroupName
	}

	// 默认消费初始化
	dc := &defaultConsumer{
		client:         internal.GetOrNewRocketMQClient(defaultOpts.ClientOptions, nil),
		....
	}
	// pushConsumer消费者初始化
	p := &pushConsumer{
		defaultConsumer: dc,
		subscribedTopic: make(map[string]string, 0),
		...
	}
	return p, nil
}
```







### 获取本机ip和虚假IP地址

```bash
func ClientIP4() ([]byte, error) {
	addrs, err := net.InterfaceAddrs()
	if err != nil {
		return nil, errors.New("unexpected IP address")
	}
	for _, addr := range addrs {
		if ipnet, ok := addr.(*net.IPNet); ok && !ipnet.IP.IsLoopback() {
			fmt.Println(ipnet)
			if ip4 := ipnet.IP.To4(); ip4 != nil {
				return ip4, nil
			}
		}
	}
	return nil, errors.New("unknown IP address")
}

func FakeIP() []byte {
	buf := bytes.NewBufferString("")
	buf.WriteString(strconv.FormatInt(time.Now().UnixNano()/int64(time.Millisecond), 10))
	return buf.Bytes()[4:8]
}
```

### 定时任务

一个具体的定时任务书写

```
// schedule update route info 定时更新路由信息
		go primitive.WithRecover(func() {
			// delay
			op := func() {
				c.UpdateTopicRouteInfo()
			}
			time.Sleep(10 * time.Millisecond)
			op()

			ticker := time.NewTicker(_PullNameServerInterval)
			defer ticker.Stop()
			for {
				select {
				case <-ticker.C:
					op()
				case <-c.done:
					rlog.Info("The RMQClient stopping update topic route info.", map[string]interface{}{
						"clientID": c.ClientID(),
					})
					return
				}
			}
		})
```

### 权限处理

```golang
const (
	permPriority = 0x1 << 3
	permRead     = 0x1 << 2
	permWrite    = 0x1 << 1
	permInherit  = 0x1 << 0
)

func queueIsReadable(perm int) bool {
	return (perm & permRead) == permRead
}

func queueIsWriteable(perm int) bool {
	return (perm & permWrite) == permWrite
}

func queueIsInherited(perm int) bool {
	return (perm & permInherit) == permInherit
}

func perm2string(perm int) string {
	bytes := make([]byte, 3)
	for i := 0; i < 3; i++ {
		bytes[i] = '-'
	}

	if queueIsReadable(perm) {
		bytes[0] = 'R'
	}

	if queueIsWriteable(perm) {
		bytes[1] = 'W'
	}

	if queueIsInherited(perm) {
		bytes[2] = 'X'
	}

	return string(bytes)
}
```

