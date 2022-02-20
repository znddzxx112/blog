#### 需求

登录凭证校验、鉴权、请求转发



### kong

#### 特性

- Cloud-Native：平台不可知，Kong可以从裸机运行到Kubernetes。

- 动态负载平衡：跨多个上游服务负载均衡流量。

- 基于散列的负载平衡：使用一致的散列/粘性会话进行负载平衡。

- 断路器：智能跟踪不健康的上游服务。

- 运行状况检查：上游服务的主动和被动监控。

- 服务发现：在Consul等第三方DNS解析器中解析SRV记录。

- 无服务器：直接从Kong调用并保护AWS Lambda或OpenWhisk功能。

- WebSockets：通过WebSockets与您的上游服务进行通信。

- OAuth2.0：轻松将OAuth2.0身份验证添加到API。

- 日志记录：通过HTTP，TCP，UDP或磁盘记录对系统的请求和响应。

- 安全性：ACL，Bot检测，白名单/黑名单IP等……

- Syslog：登录系统日志。

- SSL：为基础服务或API设置特定SSL证书。

- 监控：实时监控提供关键负载和性能服务器指标。

- **转发代理：使Kong连接到中间透明HTTP代理。**

- 身份验证：HMAC，JWT，Basic等。

- 速率限制：基于许多变量阻止和限制请求。

- 转换：添加，删除或操作HTTP请求和响应。

- 缓存：在代理层缓存并提供响应。

- CLI：从命令行控制您的Kong集群。

- REST API：Kong可以使用其RESTful API进行操作，以获得最大的灵活性。

- 地理复制：配置始终是不同地区的最新信息。

- 故障检测和恢复：如果您的某个Cassandra节点发生故障，Kong不会受到影响。

- 群集：所有Kong节点自动加入群集，使其配置在节点之间更新。

- 可扩展性：通过自然分布，Kong通过简单地添加节点来水平扩展。

- 性能：Kong通过扩展和核心使用NGINX轻松处理负载。

- 插件：可扩展的体系结构，用于为Kong和API添加功能。Kong 的插件机制是其高可扩展性的根源，Kong 可以很方便地为路由和服务提供各种插件，网关所需要的基本特性

  

  https://www.cnkirito.moe/kong-introduction/
  

#### 安装

> https://docs.konghq.com/enterprise/2.3.x/deployment/installation/ubuntu/
>

#### 安装依赖

postgreSQL

#### kong的dashboad入口

http://192.168.4.161:8002/overview



#### kong与nacos组合

https://my.oschina.net/xiejunbo/blog/4720458



#### kong admin api

```
curl -X POST http://localhost:8001/default/services \
  --data name=k8s-service-tcp \
  --data url='tcp://192.168.3.47:32108' | jq

curl http://localhost:8001/default/services/k8s_service | jq

添加路由：
curl -i -X POST http://localhost:8001/services/k8s-service-tcp/routes \
  --data 'paths[]=/mock' \
  --data name=mocking
```





### open-cloud

安装相关软件：mysql5.7、redis、rabbitmq、nginx

#### rabbitmq

```
1、拉镜像
docker pull rabbitmq:management

2、起 rabbit
docker run -d --hostname rabbit --name rabbit -e RABBITMQ_DEFAULT_USER=admin -e RABBITMQ_DEFAULT_PASS=123456 -p 15672:15672 -p 5672:5672 -p 25672:25672 -p 61613:61613 -p 1883:1883 rabbitmq:management

3、下载插件
wget https://github.com/rabbitmq/rabbitmq-delayed-message-exchange/releases/download/v3.8.0/rabbitmq_delayed_message_exchange-3.8.0.ez

5、拷贝（c5e3d04e3141 容器 id）
docker cp rabbitmq_delayed_message_exchange-3.8.0.ez 2ee1c99f65f3:/plugins

6、进入容器
docker exec -u 0 -it 2ee1c99f65f3 bash

7、开启插件

root@my-rabbit:/plugins

 rabbitmq-plugins enable rabbitmq_delayed_message_exchange

8、重启容器

docker restart d0ef31fbe084
```

#### redis

```
docker pulll redis:latest
docker run --name my-redis -p 6379:6379 -v /data/redis:/data -d redis redis-server  --appendonly yes
```

#### spring-gateway

是网关组件，使用量大



### nacos

#### 安装

> https://nacos.io/zh-cn/docs/quick-start-docker.html

安装相关软件：mysql5.7、prometheus、grafana

#### 访问入口

> http://192.168.4.161:8848/nacos/



#### 结语

如果使用spring gateway、nacos、apollo、skywalking、hystrix 。使用量大、坑被前人踩过。golang能接入这个体系。





### consul

#### 教程

> https://learn.hashicorp.com/tutorials/consul/get-started-service-discovery?in=consul/getting-started

#### 安装

> wget https://releases.hashicorp.com/consul/1.9.4/consul_1.9.4_linux_amd64.zip

#### 常用命令

```
$ consul agent -dev
$ consul members
$ curl localhost:8500/v1/catalog/nodes
$ consul leave
```

#### 服务定义

> 可以使用服务定义 或者 http api注册方式

```shell
$ mkdir ./consul.d
$ echo '{
  "service": {
    "name": "web",
    "tags": [
      "rails"
    ],
    "port": 80
  }
}' > ./consul.d/web.json
$ consul agent -dev -enable-script-checks -config-dir=./consul.d
$ curl 'http://localhost:8500/v1/health/service/web?passing'
```

#### 更新服务

```shell
$ echo '{
  "service": {
    "name": "web",
    "tags": [
      "rails"
    ],
    "port": 80,
    "check": {
      "args": [
        "curl",
        "localhost"
      ],
      "interval": "10s"
    }
  }
}' > ./consul.d/web.json
$ consul reload
```

#### 服务发现

> 使用本地sidecar代理 或者 DNS接口或HTTP API直接为服务提供IP

使用sidecar代理

```shell
$ socat -v tcp-l:8181,fork exec:"/bin/cat"
$ nc 127.0.0.1 8181
$ echo '{
  "service": {
    "name": "socat",
    "port": 8181,
    "connect": {
      "sidecar_service": {}
    }
  }
}' > ./consul.d/socat.json
$ consul connect proxy -sidecar-for socat
$ echo '{
  "service": {
    "name": "web",
    "connect": {
      "sidecar_service": {
        "proxy": {
          "upstreams": [
            {
              "destination_name": "socat",
              "local_bind_port": 9191
            }
          ]
        }
      }
    }
  }
}' > ./consul.d/web.json
$ consul connect proxy -sidecar-for web
```

#### dashboard

```shell
$ ./consul agent -dev -client 0.0.0.0 -ui
```

访问 http://192.168.4.161:8500/ui

#### 组成单server-单client的本地数据中心

```
// server
$ consul agent \
  -server \
  -bootstrap-expect=1 \
  -node=agent-one \
  -bind=192.168.4.161 \
  -data-dir=/tmp/consul \
  -config-dir=./consul.d \
  -client 0.0.0.0 \
  -ui \
  -dev 
// client
$ consul agent \
  -node=agent-two \
  -bind=192.168.4.35 \
  -data-dir=/tmp/consul \
  -client 0.0.0.0 \
  -ui 
// server
$ consul join 192.168.4.35
$ consul members

```



### kong集成consul服务发现

#### consul定义一个服务

consul.d/swagger-web.json

```
{
  "services": [
    {
      "address": "192.168.3.47",
      "id": "dn1",
      "name": "swag",
      "port": 32689,
      "tags": [
        "example service discovery"
      ]
    }
  ]
}

```

#### consul启动

```
consul agent -server -bootstrap-expect=1 -node=agent-one -bind=192.168.4.161 -data-dir=/tmp/consul -config-dir=./consul.d -client 0.0.0.0 -ui -dns-port=8600
```

#### 修改kong的配置项

vim /etc/kong/kong.conf

```
dns_resolver = 192.168.4.161:8600
```

#### 重启kong

```
kong restart  // 不是kong reload,reload不会重新读取配置文件
```

#### kong的dashboard增加service和route

> service为上游服务器，指明host和port
>
> route表明何种路由转发至上游服务器，指明路由和service

#### 测试

```
curl --location --request GET 'http://192.168.4.161:8000/swagger/index.html' \
--header 'Host: your-api.com'
```



#### kong的oauth2.0

阮一峰关于oauth2.0的4种模式

> https://www.ruanyifeng.com/blog/2014/05/oauth_2_0.html

不选择原因：

```
1、业务模式。开放平台的场景：调用方与服务方。与常见“微信-用户-第三方应用方”三方场景不同。使用oauth2.0中的客户端或密码模式（本质是http basic-auth密码明文传输），适用但不安全。
2、要求https，内部网络测试环境部署麻烦
```



#### kong的basic-auth

http的basic认证机制

Authorization: Basic base64encode(username+":"+password)



#### kong的key-auth

> https://www.cnblogs.com/sunhongleibibi/p/12084868.html

```
curl -i -X GET \
  --url http://localhost:8000 \
  --header "Host: example.com" \
  --header "apikey: 123456"
```



#### kong的hmac-auth

> https://blog.csdn.net/u014686399/article/details/100121736

加盐的hash算法。符合开放平台场景特征（用户id+secret）

```
curl --location --request GET 'http://your-api.com:8000/swagger/index.html' \
--header 'testhamc: 123456' \
--header 'Authorization: hmac username="ckl", algorithm="hmac-sha256",headers="testhamc",signature="AIr9m8h6jQQA/GpbrqC1/1OD9Drk37g2pd9Euj4Cg4g="' \
--header 'Date: Tue, 16 Mar 2021 10:02:26 GMT'
```

```
func TestHMAC(t *testing.T) {
	// 对sha256算法进行hash加密,key随便设置
	hash := hmac.New(sha256.New, []byte("ckl123456")) // 创建对应的sha256哈希加密算法
	hash.Write([]byte("testhamc: 123456"))            // 写入加密数据
	fmt.Printf("%x\n", hash.Sum(nil))                 // c10a04b78bcbcc1c4cba37f6afe0fa60cbf08f6e0a1d93b09387f7069be1aeff
	fmt.Println(base64.StdEncoding.EncodeToString(hash.Sum(nil)))
	loc, _ := time.LoadLocation("GMT")
	fmt.Println(time.Now().In(loc).Format(time.RFC1123))
}
```



