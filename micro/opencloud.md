### 开放平台接入文档

#### OpenAPI explorer

![image-20210325100316303](C:\Users\86188\AppData\Roaming\Typora\typora-user-images\image-20210325100316303.png)

#### 开放平台参考

#### 阿里云 

> https://open.aliyun.com/
>
> https://next.api.aliyun.com/document

> 1、分层：大分类（平台）->模块->接口
>
> 2、每个接口介绍有“OpenAPI 名称，描述，查看文档”，三列
>
> 3、每个接口文档包含“统一请求参数格式、响应参数格式(json字符串)、错误码(体现在响应报文httpCode：4xx,5xx，且body格式为{ “message”:"具体错误原因"}）”
>
> 4、 请求报文header部分放置公共参数：content-type：application/x-www-form-urlencoded或者application/json
>
> 版本相关：x-acs-version
>
> 认证相关：x-acs-date，x-acs-signature-nonce, x-acs-algorithm=ACS3-HMAC-SHA256，x-acs-security-token，Authorization
>
> 5、响应报文：content-type:application/json，body部分为json字符串即响应参数
>
> 4、sdk处理“认证”，“公共参数”功能
>
> ​	各个语言sdk写法参照：
>
> ​	https://github.com/alibabacloud-go/darabonba-openapi/blob/master/client/client.go
>
> ​	 https://github.com/alibabacloud-go/fnf-20190315“
>
> **错误码**
>
> https://next.api.aliyun.com/document/fnf/2019-03-15/DescribeExecution

```shell
curl --location --request POST 'https://open.aliyun.com/ehpc/StartGWSInstance ' \
--header 'Content-Type: application/json' \
--header 'x-acs-version: 1' \
--header 'x-acs-date: xxx' \
--header 'x-acs-signature-nonce: xxx' \
--header 'x-acs-algorithm: ACS3-HMAC-SHA256' \
--header 'x-acs-security-token: xxx' \
--header 'Authorization: xxxx' \
--data-raw '{
    "InstanceId": "i-bp1bzqq4rj1eemun"
}'
```

httpCode=200

```json
{
        "RequestId": "04F0F334-1335-436C-A1D7-6C044FE73368"
}
```

错误返回:

| HttpCode | Error Code    | 错误信息          |
| :------- | :------------ | :---------------- |
| 400      | InvalidParams | Invalid param: %s |
| 406      | EcsError      |                   |
| 406      | AliyunError   |                   |
| 407      | NotAuthorized |                   |
| 409      | PartFailure   |                   |
| 500      | UnknownError  |                   |

```
{
	"message": "xxxx"
}
```



#### 飞书

> https://open.feishu.cn/document/ukTMukTMukTM/uITNz4iM1MjLyUzM

> 请求：
>
> ​    基本信息
>
> ​    路径参数
>
> ​    请求首部（header）：认证相关
>
> ​    请求体：json字符串
>
> ​    请求体示例
>
> 响应：
>
> ​    响应体：json字符串
>
> ​    响应体示例
>
> ​    错误码
>
> **响应体：**
>
> 绝大多数API的响应体结构包括code、msg、data三个部分。
>
> **code**为错误码，**msg**为错误信息，**data**为API的调用结果。默认请求成功时，code为0，msg为success。data在一些操作类API的返回中可能不存在。
>
> sdk参照：
>
> https://github.com/larksuite/oapi-sdk-go
>
> **飞书错误码**
>
> https://open.feishu.cn/document/ukTMukTMukTM/ugjM14COyUjL4ITN

```shell
curl -X POST https://open.feishu.cn/open-apis/message/v4/send \
-H 'content-type:application/json' \
-H 'Authorization:Bearer <这里替换为对应的access token>' \
-d '{
	"chat_id": "oc_5ad11d72b830411d72b836c20",
	"msg_type":"text",
	"content": { "text":"text content<at user_id=\"ou_88a56e7e8e9f680b682f6905cc09098e\">test</at>"
	}
}'
```

正确返回：httpcode=200

```json
{
    "code": 0,
    "msg": "success",
    "data": {
        // 响应的具体数据内容
    }
}
```

错误返回：

```json
{
    "code": 40004,
    "msg": "no dept authority error"
}
```

错误码

> https://open.feishu.cn/document/ukTMukTMukTM/ugjM14COyUjL4ITN



#### 微博

错误码

> https://open.weibo.com/wiki/Error_code

#### 360

> http://open.e.360.cn/api/ask.html

接口

> https://api.e.360.cn/{version}/{service_type}/{method}?{query_string}
>
> 体现分层：大分类（平台）->模块->接口

请求参数

> 请求的 Content-Type 为 **application/x-www-form-urlencoded** ，
> query_string由系统级参数部分和具体API调用参数部分组成，以key1=value&key2=value2&…表示，对于采用POST请求的Open API，query_string部分则是在POST请求体里。
> 所有查询类的Open API接口既支持POST，也支持GET方式，建议全部使用POST请求，提交类的Open API接口仅支持POST方式。

请求首部

系统级别参数：认证相关

> apiKey， accessToken

请求报文

```shell
curl -X POST \
--header 'apiKey:APIKEY' \
--header 'content-type:**application/x-www-form-urlencoded'
--data 'username=USERNAME&passwd=PASSWD' \
'https://api.e.360.cn/uc/account/clientLogin'
```

响应报文

```
{
	"code": 0,
	"message": "",
	
    "uid": "2563420133",
    "accessToken": "04128023d48837ecaee4e15367c1cc7c4e65f0ecea5a747db"
}
```

#### 钉钉

> https://developers.dingtalk.com/document/app/server-api-overview

> 1、分层：大分类（平台）->模块->接口

请求体:

```
POST https://oapi.dingtalk.com/service/get_auth_info?accessKey=ACCESS_KEY&timestamp=TIMESTAMP&suiteTicket=SUITE_TICKET&signature=SIGNATURE
```

```
{
        "auth_corpid":"ding1234",
        "suite_key":"suitefcurkdvkc1xxxx"
}
```

响应体:

```
{
        "errcode":0,
        "auth_user_info":{
                "userId":"manager975"
        },
}
```



错误码：

> https://developers.dingtalk.com/document/app/server-api-error-codes-1

```json
{
    "errcode": 40078,
    "errmsg": "不存在的临时授权码"
    "result": {}
}
```

​	

#### 开放平台区别对比

|                | 阿里云                   | 飞书                         | 360                          | 钉钉                         | 氚平台                                          |
| -------------- | ------------------------ | ---------------------------- | ---------------------------- | ---------------------------- | ----------------------------------------------- |
| 请求方法       | post                     | get、post                    | get、建议使用post            | get、post                    | post                                            |
| 请求路径       | 分层（平台->模块->接口） | 分层、版本                   | 分层、版本                   | 分层、身份认证               | 分层                                            |
| 请求首部header | 身份认证、版本           | 身份认证                     | 身份认证                     |                              | 身份认证、版本                                  |
| 请求体body     | json字符串               | json字符串                   | form表单                     | json字符串                   | json字符串                                      |
| 响应头         | 错误码                   | 200与4xx、5xx区分            | 200与4xx、5xx区分            | 200与4xx、5xx区分            | 200与4xx、5xx区分                               |
| 响应体body     | 错误描述、json字符串     | 错误码、错误描述、json字符串 | 错误码、错误描述、json字符串 | 错误码、错误描述、json字符串 | 错误码、错误描述、json字符串【code、msg、data】 |
| 错误码规范     | 全局                     | 全局                         | 接口局部                     | 全局                         | 全局（分层）                                    |
|                |                          |                              |                              |                              |                                                 |

