# blog

focus on php，golang，centos，nginx，docker ...

##### 开卷有益-已读书籍

 - 《Centos 6.x系统管理实战宝典》
 - 《深入浅出Mysql全文》
 - 《redis入门指南》
 - 《php高级程序设计_模式，框架与测试》
 - 《深入php面向对象 模式与时间第三版》
 - 《Redis实战中文》
 - 《大型网站技术架构+核心原理与案例分析-李智慧》
 - 《redis设计与实现》
 - 《学会提问》
 - 《mongodb实战》
 - 《Effective MySQL之SQL语句最优化》
 -  《罗伯特议事规则（第十版中译本）》
 - 《unix环境高级编程》
 - 《linux shell编程》
 
 ##### 等待

 - 《高性能mysql第三版》
 - 《Go并发编程实战》
 - 《人月神话》
 - 《git权威指南》


###### phper
```
PHP 语言之所以能有今天的地位，得益于PHP语言设计者一直遵从实用主义，将技术的复杂性隐藏在底层。
PHP 语言入门简单，容易掌握，程序健壮性好，不容易出现像 Java 、 C++ 等其他语言那样复杂的问题，如内存泄漏和 Crash ，跟踪调试相对轻松很多。
PHP 官方提供的标准库非常强大，各种功能函数都能在官方的标准库中找到，包括MySQL、Memcache、Redis、GD图形库、CURL、XML、JSON等等，免除了开发者到处找库的烦恼。PHP 的文档非常棒，每个函数都有详细的说明和使用示例。
第三方类库和工具、代码、项目也很丰富。开发者可以快速、高效地使用 PHP 编写开发各类软件。
到目前为止市面上仍然没有出现比 PHP 更简单易用的编程语言。所以 PHP 的前景还是很广阔的，与其纠结于编程语言的选择，不如好好地深入学习使用 PHP 。
```

- composer
```
第一点就要提 Composer ，自从 Composer 出现后，PHP 的依赖管理可以变得非常简单。
程序内依赖一些类库和框架，直接使用 Composer 引入即可，通过使用 composer update 安装依赖的包。
解决了过去加载外部库的各种难题。Composer 也有国内镜像，速度非常快。
现在绝大部分PHP开源的项目都提供了 Composer 的支持，建议大家在项目中使用 Composer 来解决 PHP 代码包管理的问题，不要再使用下载源码、手工 include 的原始方法。
```

- php7
```
PHP7 版本对 Zend 引擎做了大量修改，大幅提升了 PHP 语言的性能，使用 PHP7 可以使你的程序性能瞬间翻倍。
即使是 WordPress 这样重量级的软件运行在 PHP7 都能有上千 QPS ，相当于一台服务器每天就能处理 8000 万次请求。
使用 PHP7 ，做好 MySQL 优化，使用 Memcache 和 Redis 进行加速，这套技术架构完全可以应对相当大规模的系统。
除了某些亿级用户的平台之外，一般规模的系统完全没有压力。
```

- PSR
```
PSR 是 PHP Framework Interop Group 组织制定的PHP语言开发规范，约定了很多方面的规则，如命名空间、类名
规范、编码风格标准、Autoload、公共接口等。
现在已经成为PHP技术社区事实上的标准了。
很多知名的 PHP 框架和类库都遵守了 PSR 规范。PHP 开发者应当学习掌握 PSR 规范，在开发程序时应当尽量遵循 PSR 规范。
```

- Swoole
```
2017 年 PHP 还局限于做 Web 网站吗？No ，如果你还不知道 Swoole ，赶快去了解一下吧。Swoole 的口号是重新定义 PHP 语言，Swoole 是一个异步并行的通信引擎，作为 PHP 的扩展来运行。Node.js 的异步回调 Swoole 有，Go语言的协程 Swoole 也有，这完全颠覆了对 PHP 的认知。
使用 Swoole PHP 可以实现常驻内存的 Server 程序，可以实现 TCP 、 UDP 异步网络通信的编程开发。
过去PHP只能做一个 Web 网站，现在使用 Swoole 可以做 Java 、C++ 才能实现的通信服务，比如 WebSocket 即使通信、聊天、推送服务器、RPC 远程调用服务、网关、代理、游戏服务器等。如果你想用 PHP 做点 Web 系统之外的东西，Swoole 是最好的选择。
```

- Laravel
```
最近几年最火热的 PHP 框架，官网号称是为 Web 艺术家设计的框架，可见这套框架有多优雅。
Laravel 提供的功能模块丰富，API 设计简洁，表达力强。而且它的社区非常活跃，代码贡献者众多，第三方的插件非常多，生态系统相当繁荣。 
Laravel 底层使用了很多 symfony2 组件，通过 composer 实现了依赖管理。
如果还在纠结使用什么PHP框架，不如选择 Laravel 。 Laravel 提供的命令行工具基于 symfony.console 实现，功能强大，集成了各种项目管理、自动生成代码的功能。
```

- Phar
```
PHP5.3 之后支持了类似 Java 的 jar 包，名为 phar。用来将多个 PHP 文件打包为一个文件。
这个特性使得 PHP 也可以像 Java 一样方便地实现应用程序打包和组件化。一个应用程序可以打成一个 Phar 包，直接放到 PHP-FPM 中运行。
配合 Swoole ，可以在命令行下执行 php server.phar 一键启动服务器。PHP 的代码包可以用 Phar 打包成组件，放到 Swoole 的服务器容器中去加载执行。
```

- C/C++/GO
```
任何技术有优点就有缺点，PHP 作为一门动态脚本语言，优点是开发方便效率高。缺点就是性能差。
在密集运算的场景下比 C 、 C++ 相差几十倍甚至上百倍。
另外 PHP 不可以直接操作底层，需要依赖扩展库来提供 API 实现。
PHP 程序员可以学习一门静态编译语言作为补充实现动静互补，C/C++/Go 都是不错的选择。
而且静态语言的编程体验与动态语言完全不同，学习过程可以让你得到更大的提升。
掌握 C/C++ 语言后，还可以阅读 PHP 、 Swoole 、 Nginx 、Redis 、 Linux内核 等开源软件的源码，了解其底层运行原理。
现在最新版本的Swoole提供了C++扩展模块的支持，封装了Zend API，用C++操作PHP变得很简单，可以用C++实现PHP扩展函数和类。
```

- HTML5
```
作为 Web 前端新一代标准，HTML5 未来前景非常广阔，市场需求量非常大。
从 PC 网站、B/S 企业软件、移动端网页、APP，这些领域都在拥抱 HTML5，掌握了 HTML5 才能在下一波互联网技术大潮中存活下来。
```

- Vue.js
```
PHP 程序员除了写后台程序之外，还有很大一部分工作在展现层，和浏览器前端打交道。2017 年你还在用 jQuery 操作 DOM 实现界面渲染吗？已经完全 out 了。
现在用 Vue.js 可以非常方便地实现数据和 DOM 元素的绑定。通过 Ajax 请求后台接口返回数据后，更新前端数据自动实现界面渲染。2017 年再不学 Vue 就晚了。
如果你不光要写 Web 程序，同时还希望兼顾 Android 、IOS 、PC 客户端等平台，React Native 是一个不错的选择。
```

- 深度学习/人工智能
```
互联网的未来属于人工智能，如果你还不了解机器学习、深度学习、人工智能这些概念，那你需要尽快学习了解一下。
现在互联网巨头们都在布局人工智能，包括 Google 、 Facebook 、微软、亚马逊 和国内的百度。
虽然现在还处于科学研究的阶段，但未来互联网的各个领域都会应用到人工智能，包括自动驾驶、大数据分析、网络游戏、图像识别、语言处理等。
当然现在普通的工程师可能还无法参与到人工智能产品中，但至少应该理解深度学习/人工智能的基本概念和原理。
```

- 职业生涯规划
```
看到很多PHP程序员职业规划的文章，都是直接上来就提Linux、PHP、MySQL、Nginx、Redis、Memcache、jQuery这些，然后就直接上手搭环境、做项目，中级就是学习各种PHP框架和类库，高级阶段就是MySQL优化、PHP内核与扩展、架构设计这些了。

这些文章都存在一个严重的缺陷，不重视基础。就好比练武功，只求速成，不修炼内功和心法，只练各种招式，这样能高到哪里去？我所见过的PHP大牛每一个都是具备非常扎实的基础，他们之所以能成为大牛，是因为基础足够好。基础不稳，面对技术复杂的系统，如同盲人摸象、管中窥豹，只得其门不得其法。而且如果基础不扎实，也没办法进入大公司。国外的Google、Facebook，国内的腾讯、阿里、百度、滴滴、京东、新浪等知名互联网企业，无论哪一家公司面试必然会考验应聘者的技术功底。无法进入一个拥有大规模并发请求的项目中得到历练，不坚持提升自己，那也只能在小公司混日子了。

我最开始工作也是在2家小公司，后来加入腾讯阿里，主要原因还是我坚持学习基础知识，从而得倒了这个机会。有几个方面的基础知识，我建议每一位PHP程序员都应该好好学习一下。我推荐几本书给大家，包括深入理解计算机系统、现代操作系统、C程序设计语言、C语言数据结构和算法、Unix环境高级编程、TCP/IP网络通信详解。另外我建议大家学习一下面向对象方面知识，PHP这方面的书不太多，建议看Java面向对象编程、Java编程思想、J2EE这些书。PHP语言基础方面，建议认真地把PHP5权威编程这本书好好读完。另外不光要读，还要照着书中的讲解动手去编程实践。

总之有一个好的基础，再去学LAMP、Redis、PHP框架、前端，这样取得的成就更大。这与年龄无关、与学历无关、与智力无关，与天赋也无关。只要肯努力学习，人人可以成为技术大牛。
```
