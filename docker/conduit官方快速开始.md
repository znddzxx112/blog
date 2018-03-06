- 参考文章
```
https://skyao.io/publication/service-mesh-2017-summary/
```

- k8s在线环境
```
https://www.katacoda.com/courses/kubernetes/playground
```

- Conduit中文文档
```
http://conduit.doczh.cn/
```

## 总览 Conduit overview
```
Conduit is an ultralight service mesh for Kubernetes. 
It makes running services on Kubernetes safer and more reliable by transparently managing the runtime communication between services. 
It provides features for observability, reliability, and security—all without requiring changes to your code.
Conduit基于Kubernetes的轻量级服务网格。 
通过透明地管理服务之间的运行时间通信，它使Kubernetes上的运行服务更安全，更可靠。 
它提供了可观察性，可靠性和安全性的功能 - 无需更改代码。

The Conduit service mesh is deployed on a Kubernetes cluster as two basic components: a data plane and a control plane.
The data plane carries the actual application request traffic between service instances. 
The control plane drives the data plane and provides APIs for modifying its behavior (as well as for accessing aggregated metrics). 
The Conduit CLI and web UI consume this API and provide ergonomic controls for human beings.
Conduit服务网格作为两个基本组件部署在Kubernetes集群上：数据平面和控制平面。
数据平面承载服务实例之间的实际应用请求流量。
控制平面驱动数据平面，并提供用于修改其行为的API（以及访问聚合度量标准）。 
Conduit CLI和Web UI使用此API并为人类提供人体工程学控制。

These proxies transparently intercept communication to and from each pod, 
and add features such as retries and timeouts, instrumentation, 
and encryption (TLS), as well as allowing and denying requests according to the relevant policy.
这些代理透明地拦截每个Pod的通信，并添加重试和超时，
检测和加密（TLS）等功能，并根据相关策略允许和拒绝请求。
控制面板职责1.请求策略2.权限验证
```


## 快速开始【Getting Started】

- 安装命令
```
// 确认k8s版本 要求1.8以上
$ kubectl version --short
// 安装conduit
$ curl https://run.conduit.io/install | sh
$ export PATH=$PATH:$HOME/.conduit/bin
$ conduit version
// 使用默认的命名空间安装控制面板
$ conduit install | kubectl apply -f -
$ conduit dashboard
```

- 安装实例app
```
$ curl https://raw.githubusercontent.com/runconduit/conduit-examples/master/emojivoto/emojivoto.yml | 
   conduit inject - | 
   kubectl apply -f -
$ kubectl get svc web-svc -n emojivoto -o jsonpath="{.status.loadBalancer.ingress[0].*}"
```

- 使用cli展示conduit服务网格状态
```
// 命令包含 conduit stat , conduit tap
$ conduit stat deployments
$ conduit tap deploy emojivoto/voting
```

## 服务网格中增加服务 【Adding your service to the mesh】

- 先决条件
```
1. Applications that use WebSockets or HTTP tunneling/proxying (use of the HTTP CONNECT method), 
   or plaintext MySQL, SMTP, or other protocols where the server sends data before the client sends data, 
   require additional configuration. See the Protocol Support section below.
1. 应用使用websocket 或者 http 隧道,http2 以及那些服务器能够主动推送的协议

2.gRPC applications that use grpc-go must use grpc-go version 1.3 or later 
  due to a bug in earlier versions.
2. 如果是gRpc应用, grpc-go version 1.3 or later

3. Conduit doesn’t yet support external DNS lookups 
(e.g. proxying a call to a third-party API). This will be addressed in an upcoming release.
3. Conduit 暂不支持其他的第三方dns发现，但是会在下一次版本中支持。
```

- 使用配置文件增加服务
```
deployment.yml 配置文件中包含应用的信息，切换和回滚更新，在pod部署都依赖这个配置文件
```

- 协议支持
```
支持使用http2.0 websocket的应用
However, non-HTTPS WebSockets and HTTP tunneling/proxying (use of the HTTP CONNECT method)
currently require manual configuration to disable the layer 7 features for those connections.
非https的webscokets和http隧道协议，当前需要手动管理和配置。

For pods that accept incoming CONNECT requests and/or incoming WebSocket connections, 
use the --skip-inbound-ports flag when running conduit inject. 
For pods that make outgoing CONNECT requests and/or outgoing WebSocket connections, 
use the --skip-outbound-ports flag when running conduit inject

对于使用websocket链接的端口，需要命令
conduit inject deployment.yml --skip-inbound-ports=80,7777 | kubectl apply -f -
 
对于不使用http的链接，比如mysql(3306)需要命令：
conduit inject deployment.yml --skip-outbound-ports=3306 | kubectl apply -f -
```

## 调试应用【debugging an app】
```
// 总览应用的健康情况
$ conduit stat deployments
// 查看当前通过这个应用的请求
Let’s use the tap command to take a look at requests currently flowing through this deployment.
$ conduit tap deploy emojivoto/voting
// 检索出异常请求
$ conduit tap deploy emojivoto/voting | grep Unknown -B 2
// 检索来自path等于--path /emojivoto.v1.VotingService/VotePoop
$ conduit tap deploy emojivoto/voting --path /emojivoto.v1.VotingService/VotePoop
```

## 导出变量到Prometheus【Exporting metrics to Prometheus】
```
Prometheus 是k8s的监控方案
对于单机的Linux服务器监控，已经有了Nagios，Zabbix这些成熟的方案。 
在Kubernetes集群中，我们使用新一代的监控系统Prometheus来完成集群的监控。
Prometheus集成了数据采集，存储，异常告警多项功能，是一款一体化的完整方案。
```

## 生产环境部署【road to production】
```
We’ll make alpha / beta / GA designations based on actual community usage.
有alpha/beta/GA 版本，采用社区化运作.

公布了版本发布时间表
0.3: Telemetry Stability
Late February 2018
Visibility
    Stable, automatic top-line metrics for small-scale clusters.
    稳定，自动化，针对为小型集群
Usability
    Routing to external DNS names
    DNS路由
Reliability
    Least-loaded L7 load balancing
    7层负载
    Improved error handling
    错误处理
    Improved egress support
Development
    Published (this) public roadmap
    All milestones, issues, PRs, & mailing lists made public

0.4: Automatic TLS; Prometheus++ 
    自动TLS,更好支持prometheus框架
Late March 2018
Usability
    Helm integration
    Mutating webhook admission controller
Security
    Self-bootstrapping Certificate Authority
    Secured communication to and within the Conduit control plane
    Automatically provide all meshed services with cryptographic identity
    Automatically secure all meshed communication
    自启动证书颁发机构
     与Conduit控制平面之间以及内部的安全通信
     自动提供具有加密身份的所有网状服务
     自动保护所有网状通信
Visibility
    Enhanced server-side metrics, including per-path and per-status-code counts & latencies.
    Client-side metrics to surface egress traffic, etc.
    增强的服务器端指标，包括每路径和每个状态码计数和延迟。
    客户端指标用于表面出口流量等
Reliability
    Latency-aware load balancing
    延迟负载均衡

0.5: Controllable Deadlines/Timeouts
    可控制的截止和超时
Early April 2018
Reliability
    Controllable latency objectives to configure timeouts
    Controllable response classes to inform circuit breaking, retryability, & success rate calculation
    High-availability controller
    可控延迟目标来配置超时
    可控响应类，用于通知断路，重试和成功率计算
    高可用性控制器
Visibility
    OpenTracing integration
    OpenTracing集成
Security
    Mutual authentication
    Key rotation
    相互认证
    按键旋转
     
0.6: Controllable Response Classification & Retries
可控响应分类和重试
Late April 2018
Reliability
    Automatic alerting for latency & success objectives
    自动延迟和成功提醒
    Controllable retry policies
    可控制的重试策略
Routing
    Rich ingress routing
    Contextual route overrides
    丰富的入口路由
    上下文路由覆盖
Security
    Authorization policy
    授权政策
And Beyond:
    Controller policy plugins
    Support for non-Kubernetes services
    Failure injection (aka “chaos chihuahua”)
    Speculative retries
    Dark traffic
    gRPC payload-aware tap
    Automated red-line testing
    控制器策略插件
    支持非Kubernetes服务
    失败注射
    投机重试
    gRPC有效载荷感知分接头
    自动化的红线测试
```

## 参与方式
```
Conduit on Github
Join us on the #conduit channel in Linkerd slack https://slack.linkerd.io/
邮件列表：
   Users list: conduit-users@googlegroups.com
   Developers list: conduit-dev@googlegroups.com
   Announcements: conduit-announce@googlegroups.com
```
## 总结
```
Conduit 是从头开始的，目标是成为最快、最轻、最简单并且最安全的 Service Mesh。
他使用 Rust 构建了快速、安全的数据平面，用 Go 开发了简单强大的控制平面，总体设计围绕着性能、安全性和可用性进行。
为什么要做一个 Conduit？Linkerd 是世界上最多生产级部署的 Service Mesh。

Conduit 是让微服务安全可靠的下一代 Service Mesh。
他能透明的管理服务之间的通信，自动提供可测性、可靠性、安全性和弹性的支持。
还是跟 Linkerd 相仿，他的数据平面是在应用代码之外运行的轻量级代理，控制平面是一个高可用的控制器。
然而和 Linkerd 不同的是，Conduit 的设计更加倾向于 Kubernetes 中的低资源部署。

Linkrd最早出现的Service,生产级别的产品.
当前linkrd和envoy 都和istio集成，成为istio的数据面板.
Istio/Conduit 属于非侵入式的Service Mesh属于第二代.

```
