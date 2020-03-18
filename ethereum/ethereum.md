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

```bash
$ git clone https://github.com/ethereum/go-ethereum
$ sudo apt-get install -y build-essential
$ cd go-ethereum
$ make geth
```

- 方式2

ubuntu ppa

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

##### 运行一个轻节点

满足“创建账户”，“转账”，“部署合约与合约交互”三个场景，不涉及历史数据

```bash
$ geth console
```

本质是 `--syncmode` 同步模式不同

节点运行起来之后，可以用web3.js和自带客户端进行交互

##### 在测试网络运行节点,需要挖矿

```bash
$ geth --testnet console
```

测试网络数据存储于~/.ethereum/testnet

```bash
$ geth attach <datadir>/testnet/geth.ipc
```

使用上述方式与测试网络交互

##### 运行一个信任证明的测试网络，不需要挖矿

```bash
$ mkdir -p ~/data/eth-test
$ geth --dev --dev.period 14 --datadir data/eth-test 
$ geth --datadir ~/data/eth-test attach
```

> geth attach提供的方式，控制台文档
>
> https://github.com/ethereum/wiki/wiki/JavaScript-API

##### 用docker运行节点

> https://github.com/ethereum/go-ethereum#docker-quick-start

#### 编程方式与`geth`节点交互

> 作为开发者，不满足通过geth attach提供的方式与geth交互。
>
> 有以下文档关于json-rpc,各种语言实现以下即可通信,
>
> https://github.com/ethereum/wiki/wiki/JSON-RPC（nodejs的web3.js包已实现）
>
> json-rpc只是编码方式，通信协议以下http,websock,ipc皆可

这份文档的作用-未知

> https://github.com/ethereum/go-ethereum/wiki/Management-APIs

##### geth要支持json-rpc的相关参数

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

#### 部署私有网络（再造一个 以太坊）

> https://github.com/ethereum/go-ethereum#operating-a-private-network