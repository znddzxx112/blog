[TOC]

#### nvm安装多版本nodejs

> nvm 的全称是 **Node Version Manager**
>
> Node.js 的各种特性都没有稳定下来，所以我们经常由于老项目或尝新的原因，需要切换各种版本

```bash
$  nvm install 0.12
$  nvm ls
$ nvm use 0.12
```



#### nodejs下载和安装

> http://nodejs.cn/download/下载

```bash
$ tar -xJf node-v12.16.1-linux-x64.tar.xz -C ~/local/
$ vi ~/.profile
export NODEBIN=/home/znddzxx112/local/node-v12.16.1-linux-x64/bin
export PATH=$NODEBIN:$PATH
```

#### yarn

##### 安装yarn

```sh
$ npm install yarn -g
```

##### 安装依赖

```bash
$ yarn
```

##### 安装swagger-jsdoc命令

```bash
$ yarn add swagger-jsdoc
```

#### nodejs总体架构

nodejs各个模块依赖

![2018112310322113](/home/znddzxx112/workspace/caokelei/blog/nodejs/2018112310322113.jpeg)

native modules: 由js代码组成

builtin modules：由c++代码组成模块，提供基础功能

v8 engine：主要有两个作用 

​			1.虚拟机的功能，执行js代码（自己的代码，第三方的代码和native modules的代码）。

　　  2.提供C++函数接口，为nodejs提供v8初始化，创建context，scope等。

libuv：它是基于事件驱动的异步IO模型库

nodejs暴露给开发者的接口则是native modules，当我们发起请求时，请求自上而下，穿越native modules，通过builtin modules将请求传送至v8，libuv和其他辅助服务，请求结束，则从下回溯至上，最终调用我们的回调函数

#### nodejs函数调用过程

![1141038-20180104112029346-2103768780](/home/znddzxx112/workspace/caokelei/blog/nodejs/1141038-20180104112029346-2103768780.png)

- 执行node xx.js时,node先初始化v8,libuv,再处理js代码
- 1，2，3将监听注册到libuv中，4，5，6将回调送回callback函数处

- nodejs将v8、libuv有机结合在一起

#### 包依赖管理

package.json

> ```bash
> {
>   "name": "wallet-backend",
>   "version": "1.0.0",
>   "description": "",
>   "main": "server.js",
>   "scripts": {
>     "test": "node test.js",
>     "start": "node server.js",
>     "postinstall": "node ./lib/cmd.js"
>   },
>   "author": "morolt@gmail.com",
>   "license": "ISC",
>   "dependencies": {
>     "abi-decoder": "^1.1.0",
>     "amqplib": "^0.5.5",
>     "apn": "^2.2.0",
>     "bignumber.js": "^7.2.1",
>     "body-parser": "latest",
>     "ethereum-input-data-decoder": "latest",
>     "ethereumjs-tx": "^1.3.4",
>     "finalhandler": "^1.1.1",
>     "log4js": "^2.5.3",
>     "log4js-extend": "^0.2.1",
>     "md5": "^2.2.1",
>     "mysql": "^2.17.1",
>     "mysql2": "^2.1.0",
>     "node-cmd": "latest",
>     "node-schedule": "^1.3.2",
>     "protobufjs": "^3.8.2",
>     "request": "^2.88.0",
>     "router": "^1.3.2",
>     "scheduler": "0.14.0",
>     "sequelize": "^4.38.0",
>     "solc": "^0.4.23",
>     "squel": "^5.12.1",
>     "web3": "^1.0.0-beta.33"
>   }
> }
> ```

- yarn方式

```bash
$ npm install yarn -g
$ yarn 下载依赖
```

- npm

```bash
$ npm install express utility --save
```

> --save 安装express utility同时写入package.json中的`dependencies`





#### 并发模型



##### 多个协程或者多个异步操作

- 设置计数器或者golang中waitgrop包

  > 等待所有操作完成

##### 使用 async 控制并发



##### 使用promise控制并发

> promise链提供了一种让函数顺序执行的方法

#### 问题

- yarn add后的安装命令位置在哪

> 全局位置在~/.config/yarn/global/node_modules/.bin
>
> 非全局在node_modules/.bin
>
> 建议在.profile增加
>
> export YARNBIN=~/.config/yarn/global/node_modules/.bin
> export PATH=$YARNBIN:$PATH