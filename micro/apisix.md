## apisix

> https://apisix.apache.org/
>
> https://github.com/apache/apisix

### 安装apisix

> https://apisix.apache.org/zh/docs/apisix/getting-started

#### 测试安装情况

创建服务和创建路由

```shell
curl --location --request GET 'http://your-api.com:9080/swagger/index.html' \
--header 'Host: your-api.com'
```



### 开启hmac-auth认证身份认证

#### 创建消费者

开启hmac-auth

```json
{
  "access_key": "ckl",
  "clock_skew": 0,
  "disable": false,
  "secret_key": "ckl123456",
  "signed_headers": [
    "testhamc"
  ]
}
```



生成hmac签名：

> 文章：http://apisix.apache.org/zh/docs/apisix/plugins/hmac-auth

```golang
func TestHMACAPISIX(t *testing.T) {
	loc, _ := time.LoadLocation("GMT")
	date := time.Now().In(loc).Format(time.RFC1123)
	fmt.Println(date)

	// 对sha256算法进行hash加密,key随便设置
	secret := "ckl123456"
	//secret := "my-secret-key"
	hash := hmac.New(sha256.New, []byte(secret)) // 创建对应的sha256哈希加密算法
	message := []string{"GET", "/swagger/index.html", "", "ckl", date, "testhamc:123456"}
	//message := []string{"GET", "/index.html", "age=36&name=james", "user-key", "Tue, 19 Jan 2021 11:33:20 GMT", "User-Agent:curl/7.29.0", "x-custom-a:test"}
	signedMessage := strings.Join(message, "\n")
	signedMessage += "\n"
	fmt.Println(signedMessage)
	hash.Write([]byte(signedMessage)) // 写入加密数据
	fmt.Printf("%x\n", hash.Sum(nil)) // c10a04b78bcbcc1c4cba37f6afe0fa60cbf08f6e0a1d93b09387f7069be1aeff
	fmt.Println(base64.StdEncoding.EncodeToString(hash.Sum(nil)))

}
```



```shell
curl --location --request GET 'http://your-api.com:9080/swagger/index.html' \
--header 'Host: your-api.com' \
--header 'testhamc: 123456' \
--header 'Date: Wed, 17 Mar 2021 09:01:41 GMT' \
--header 'X-HMAC-SIGNATURE: GUfVRNx6mQbwWn2SLC0aTvMGWBiF65UYMy3Ze/GQSJw=' \
--header 'X-HMAC-ALGORITHM: hmac-sha256' \
--header 'X-HMAC-ACCESS-KEY: ckl' \
--header 'X-HMAC-SIGNED-HEADERS: testhamc'
```



### apisix使用consul注册中心

> 让consul监听53端口，apisix的服务就可以使用域名
>



### 开启监控prometheus

> https://apisix.apache.org/zh/docs/apisix/plugins/prometheus/

1、开启在dashboard插件prometheus

2、想要收集信息的路由启用插件prometheus

3、测试拉取

```bash
curl -i http://127.0.0.1:9080/apisix/prometheus/metrics
```

4、prometheus增加拉取源的配置

```
scrape_configs:
  - job_name: "apisix"
    metrics_path: "/apisix/prometheus/metrics"
    static_configs:
      - targets: ["127.0.0.1:9080"]
```

可以通过删除pod，或者kill -HUP 1 让prometheus加载配置

5、grafana官方下载json

> https://grafana.com/grafana/dashboards/11719/revisions

6、grafana设置prometheus作为数据来源

7、grafana导入官方下载的json



### 开启skywalking

#### apisix配置文件增加配置

```yaml
plugins:
  - skywalking

plugin_attr:
  skywalking:
    service_name: APISIX
    service_instance_name: "APISIX Instance Name"
    endpoint_addr: http://192.168.3.12:12800
```

#### 路由增加skywalking插件

```bash
curl http://127.0.0.1:9080/apisix/admin/routes/1  -H 'X-API-KEY: edd1c9f034335f136f87ad84b625c8f1' -X PUT -d '
{
    "methods": ["GET"],
    "uris": [
        "/*"
    ],
    "plugins": {
        "skywalking": {
            "sample_ratio": 1
        }
    },
    "upstream": {
        "type": "roundrobin",
        "nodes": {
            "192.168.3.47:30736": 1
       }
    }
}'
```

#### 测试

调用接口，查看skywalking