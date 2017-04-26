- 参考文章：http://www.ruanyifeng.com/blog/2014/05/restful_api.html
- http://www.ruanyifeng.com/blog/2011/09/restful.html

- 原文
```
网络应用程序，分为前端和后端两个部分。当前的发展趋势，就是前端设备层出不穷（手机、平板、桌面电脑、其他专用设备......）。
因此，必须有一种统一的机制，方便不同的前端设备与后端进行通信。这导致API构架的流行，甚至出现"API First"的设计思想。RESTful API是目前比较成熟的一套互联网应用程序的API设计理论。我以前写过一篇《理解RESTful架构》，探讨如何理解这个概念。

如果一个架构符合REST原则，就称它为RESTful架构。
```

- 我的理解
```
restful 提供了一种api设计思路。
get，post，put，代表动作
url 代表资源 host/version/resorce/?param1=foo
可以自我引申，服务框架中使用，更加简洁
```

- goLang
```
框架beego也采用此种方式
喜欢go，可以看一下
```
