### 对http接口进行mock

#### 背景问题

前后端分离大背景下，前端依赖后端接口才能完成全部工作。如果后端接口迟迟不能使用会严重影响前端开发进度。

当一个业务横跨多个业务或系统，下游系统依赖上游系统接口。如果上游系统无法提供接口会严重影响下游系统开发和测试进度。

#### 什么是接口mock

mock: 对于一些不容易构造/获取的**对象**，创建一个mock对象来模拟对象的**行为**。

接口mock：对于尚未实现的接口，创建一个mock接口来模拟真实接口的行为。

#### 目的

在开发初期，后端同学创建mock接口供前端和app开发同学进行使用，等到后端同学完成真实接口后，用真实接口替换mock接口。

只要交互双方定义好接口，团队同学之间可以并行工作，互不影响。

### 使用yapi进行接口mock

当前，后端接口文档存储于yapi中，yapi会根据接口文档返回值自动mock。yapi还提供高级mock功能。

yapi能基本满足当前需求。

#### 上传接口文档至yapi

php和golang业务项目通过gitlab CI/CD功能，已能上传至yapi。

#### 使用mock接口地址

在yapi接口详情页能找到mock地址

比如：Mock地址：

http://192.168.3.194:3000/mock/116/api/v1/activity/Mill/GetOrderList

直接调用，比如

```bash
curl --location --request POST 'http://192.168.3.194:3000/mock/116/api/v1/activity/Mill/GetOrderList?page=1'
```

返回:

```
{
    "code": 200,
    "msg": "成功",
    "data": [
        {
            "id": "1123",
            "created_at": "2020-04-20 08:21:30"
        }
    ]
}
```

#### 使用yapi的高级mock功能

高级Mock页卡中，添加期望即可。

注意点：

参数过滤：请求必须包含设置的参数，并且值相等才可能返回期望。参数可以在 Body 或 Query 中。

yapi高级mock官方文档：https://hellosean1025.github.io/yapi/documents/adv_mock.html



### 总结

前后端分离大背景下, 前后端同学交互双方定义好接口，使用mock接口，团队同学之间可以并行工作，互不影响。

