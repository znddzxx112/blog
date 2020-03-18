[TOC]



#### 资源

> github：https://github.com/ethereum/go-ethereum
>
> 与eth通信的json-rpc wiki:https://github.com/ethereum/wiki/wiki/JSON-RPC
>
> 有官方go实现，cpp,pythen实现
>
> nodejs实现的web3.js库，文档：https://web3js.readthedocs.io/en/v1.2.6/

#### 安装ethereum

前提安装golang,C compilers 

- 方式1：源码安装

```bash
$ git clone https://github.com/ethereum/go-ethereum
$ sudo apt-get install -y build-essential
$ cd go-ethereum
$ make geth
```

- 方式2：ubuntu ppa

> https://github.com/ethereum/go-ethereum/wiki/Building-Ethereum

```
$ sudo add-apt-repository -y ppa:ethereum/ethereum
$ sudo apt-get update
$ sudo apt-get install ethereum
```



#### 命令

- geth

  > 主要的Ethereum CLI client, 可以运行主网，测试网络，私有网络，全节点，历史节点，轻节点。
  >
  > 还作为网关允许其他实现json-rpc的终端进入Ethereum 网关，HTTP, WebSocket and/or IPC transports三种形式

- abigen

  > 把Solidity 源代码翻译成go包

- bootnode

  > 精简版本的Ethereum客户端实现，只参与网络节点发现协议，但不运行任何更高级别的应用程序协议。
  >
  > 作为轻量节点用于可以在私有网络找到节点

- puppeth

  > 一个CLI向导，帮助创建一个新的Ethereum网络

- evm

  > EVM (Ethereum虚拟机)的开发人员实用开发工具，它能够在可配置的环境和执行模式中运行字节码脚本。

- gethrpctest

  > geth rpc调试工具

- rlpdump

  > rlp导出调试工具

#### 运行geth

##### 运行主网节点

```bash
$ geth 
```

 `--syncmode` 参数的同步模式不同，可以运行全节点，归档节点和轻节点

> 轻节点满足“创建账户”，“转账”，“部署合约与合约交互”三个场景，不涉及历史数据

##### 测试网络运行节点

```bash
$ geth --testnet 
```

##### 本地开发网络

```
$ geth --dev 
```

`--datadir` 参数可以选择数据保存位置

##### 用docker运行节点

> https://github.com/ethereum/go-ethereum#docker-quick-start

#### 编程语言与`geth`节点交互

> 作为开发者，不满足通过geth attach提供的方式与geth交互。
>

##### geth中json-rpc相关参数

- `--rpc` Enable the HTTP-RPC server
- `--rpcaddr` HTTP-RPC server listening interface (default: `localhost`)
- `--rpcport` HTTP-RPC server listening port (default: `8545`)
- `--rpcapi` API's offered over the HTTP-RPC interface (default: `eth,net,web3`)
- `--rpccorsdomain` Comma separated list of domains from which to accept cross origin requests (browser enforced)
- `--ws` Enable the WS-RPC server
- `--wsaddr` WS-RPC server listening interface (default: `localhost`)
- `--wsport` WS-RPC server listening port (default: `8546`)
- `--wsapi` API's offered over the WS-RPC interface (default: `eth,net,web3`)
- `--wsorigins` Origins from which to accept websockets requests
- `--ipcdisable` Disable the IPC-RPC server
- `--ipcapi` API's offered over the IPC-RPC interface (default: `admin,debug,eth,miner,net,personal,shh,txpool,web3`)
- `--ipcpath` Filename for IPC socket/pipe within the datadir (explicit paths escape it)

geth有几种api，`admin,debug,eth,miner,net,personal,shh,txpool,web3`

通过`--rpcapi` `--ipcapi`  `--wsapi`  限定http,ipc,ws允许使用哪些api

`admin,debug,miner,persion,txpool`的文档在下方

> https://github.com/ethereum/go-ethereum/wiki/Management-APIs

`eth,web3`的文档在下方

> https://github.com/ethereum/wiki/wiki/JavaScript-API

各种语言实现如下json-rpc规范文档，即可与geth通信

json-rpc是协议规范，通信方式可选http,websock,ipc皆可

> https://github.com/ethereum/wiki/wiki/JSON-RPC

nodejs已经实现json-rpc，库名称web3.js文档

> https://web3js.readthedocs.io/en/v1.2.6/web3-eth.html

#### 部署私有网络（再造一个 以太坊）

> https://github.com/ethereum/go-ethereum#operating-a-private-network

#### 本地开发环境搭建

```bash
$ mkdir -p ~/data/eth-test
$ geth --dev --dev.period 0 --datadir ~/data/eth-test --rpc --rpcaddr=localhost --rpcport 8545
```

> --dev.period 出块周期 0:代表交易发生时才出块
>
> --dev 允许挖矿
>
> --rpc 启用rpc,http-rpc
>
> --rpcaddr 地址
>
> --rpcport 端口
>
> --syncmode=fast

连接控制台

```bash
$ geth --datadir ~/data/eth-test attach
// 或者
$ geth attach ~/data/eth-test/geth.ipc
```

控制台文档

> https://github.com/ethereum/wiki/wiki/JavaScript-API