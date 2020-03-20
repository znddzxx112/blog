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

##### 部署私有网络（再造一个 以太坊）

> https://github.com/ethereum/go-ethereum#operating-a-private-network

##### docker方式运行节点

> https://github.com/ethereum/go-ethereum#docker-quick-start

#### 编程语言与`geth`节点交互

> 作为开发者，不满足通过geth attach提供的方式与geth交互。
>

##### geth中与json-rpc相关参数

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

`eth`的文档在下方

> https://github.com/ethereum/wiki/wiki/JavaScript-API
>
> 另外 eth = web3.eth
>
> personal =web3.personal

在控制台输入`web3`能看到所有的接口名称

##### 各种语言与geth通信

实现如下json-rpc规范文档，即可

json-rpc是协议规范，通信方式可选http,websock,ipc皆可

> https://github.com/ethereum/wiki/wiki/JSON-RPC

nodejs已经实现json-rpc，库名称web3.js文档

> https://web3js.readthedocs.io/en/v1.2.6/web3-eth.html

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



#### nodejs的web3.js库实现关键技术

> 这里采用web3.js库作为基础
>
> lweb3,web3代表含义，库自身与rpc提供的功能更加严格的区分

```js
const lweb3 = new Web3() 
const web3= new Web3(new Web3.providers.HttpProvider(config.geth))
```

##### 创建离线钱包

> 目的存储keystore文件在手机上

```js
 let account = await lweb3.eth.accounts.create();
            let keystore = await web3.eth.accounts.encrypt(account.privateKey, password);
```

> web3.eth.accounts.create() 返回地址和私钥
>
> web3.eth.accounts.encrypt() 将私钥和密码生成keystore文件
>
> // 本地生成公私钥还可以使用这个库https://github.com/ethereumjs/ethereumjs-wallet

```json
密码：123456
{
        "version": 3,
        "id": "7c521bea-827d-413c-91b1-1cdb8a5e57a6",
        "address": "90d983cff6bc0072194f67f9cbd7c45826c62011",
        "crypto": {
            "ciphertext": "ce576899804ac3c31d2c10fcc87f7a282cb5e4a150944eb780e4959485e5a78f",
            "cipherparams": {
                "iv": "423f0c1a32bccdfcf77633f3eea84ce5"
            },
            "cipher": "aes-128-ctr",
            "kdf": "scrypt",
            "kdfparams": {
                "dklen": 32,
                "salt": "b8e26c73923acd513b4ad05af9272c13f5a5b4f0c5f8b0b7dee7e890c3730b60",
                "n": 8192,
                "r": 8,
                "p": 1
            },
            "mac": "b370ff778d0f2f72964e0492537465785e9bff7e05518be985d0f5b437520bd4"
        }
    }
```

##### 通过keystore导入钱包

> 目的得到address验证密码是否正确，并把keystore存储

```js
let account = web3.eth.accounts.decrypt(keystore, password)
console.log(account.address, account.privateKey)
```

##### 通过私钥导入钱包

> 目的通过私钥和密码，生成keystore文件

```js
 let privateKey = req.body.privateKey;
            let password = req.body.password;
            let keystore = await web3.eth.accounts.encrypt(privateKey, password);
```

> web3.eth.accounts.encrypt(privateKey, password);

结果

```json
 {
        "version": 3,
        "id": "801ad3f4-e493-4747-ba7c-92389c1769ba",
        "address": "90d983cff6bc0072194f67f9cbd7c45826c62011",
        "crypto": {
            "ciphertext": "0b31a036da5baec500d62465671f6d69350bb9de6405c16dae1534b58961efc1",
            "cipherparams": {
                "iv": "3c94f62b76a9feea23e3cd3d5212973c"
            },
            "cipher": "aes-128-ctr",
            "kdf": "scrypt",
            "kdfparams": {
                "dklen": 32,
                "salt": "dc071388d04bc907402cec1559bc302c8b7c5b3c7f217ce12b39f98505960d9e",
                "n": 8192,
                "r": 8,
                "p": 1
            },
            "mac": "994a32195635a5901313e4efcabebbdfd88e78df204701358a2cd0bef42058e8"
        }
    }
```

##### 通过助记词导入钱包和导出钱包

> BIP39钱包助记词规范，可以找相应实现的各个语言的库
>
> https://www.jianshu.com/p/d5bac6d36dc6



##### keystore形式和私钥形式导出钱包

> web3.eth.accounts.decryp()验证通过，就可以将keystore内容展示出来,或者 私钥展示出来

```js
account = lweb3.eth.accounts.decryp({
                "version": 3,
                "id": "7c521bea-827d-413c-91b1-1cdb8a5e57a6",
                "address": "90d983cff6bc0072194f67f9cbd7c45826c62011",
                "crypto": {
                    "ciphertext": "ce576899804ac3c31d2c10fcc87f7a282cb5e4a150944eb780e4959485e5a78f",
                    "cipherparams": {
                        "iv": "423f0c1a32bccdfcf77633f3eea84ce5"
                    },
                    "cipher": "aes-128-ctr",
                    "kdf": "scrypt",
                    "kdfparams": {
                        "dklen": 32,
                        "salt": "b8e26c73923acd513b4ad05af9272c13f5a5b4f0c5f8b0b7dee7e890c3730b60",
                        "n": 8192,
                        "r": 8,
                        "p": 1
                    },
                    "mac": "b370ff778d0f2f72964e0492537465785e9bff7e05518be985d0f5b437520bd4"
                }
            }, "123456")
```

##### 修改keystore密码

> 先用旧密码解锁keystore,并得到私钥
>
> 然后用私钥和新密码得到新的keystore文件，并存储

```bash
oldaccount = await lweb3.eth.accounts.decrypt(keystorev3 json,oldpassword)
// 返回新的keystore文件
lweb3.eth.accounts.encrypt(oldaccount.privateKey, newPassword)
```

##### 转账

> 离线钱包考虑安全性的做法
>
> 先从keystore中获得私钥，lweb3.eth.accounts.decrypt()
>
> 生成交易var tx = new Tx(rawTx)
>
> 私钥对交易签名 tx.sign(privateKey);
>
> 再将签名后的数据发给eth节点 web3.eth.sendSignedTransaction()

```js
// 交易hash
            let account = await lweb3.eth.accounts.decrypt('{"address":"20f62c75e39a932f9bb1e27ad5a3f75b5ddf72a4","crypto":{"cipher":"aes-128-ctr","ciphertext":"72b2629b34fe0a89ac9dfe88b43711da8a6e5ccc83eac613df4b80ab60769b22","cipherparams":{"iv":"e79117112697b890392cd0116bf53b3e"},"kdf":"scrypt","kdfparams":{"dklen":32,"n":262144,"p":1,"r":8,"salt":"cee93931ce35872a50b6d35c47ca2bd8ada2019d1205af39461c892952a74d7e"},"mac":"71965f35e54c6493d38639b6ddea4f55f00ebfe8b65f7005c23d691bb73d80f7"},"id":"840af15c-74a4-4ad0-9e0e-53e2b09a0510","version":3}', password);
            console.log(account);
            let privateKey = new Buffer(account.privateKey.slice(2), 'hex')
            let nonce = await web3.eth.getTransactionCount(account.address);
            let gasPrice = await web3.eth.getGasPrice();

            let Tx = require('ethereumjs-tx');
            var rawTx = {
                from:account.address,
                nonce: nonce,
                gasPrice: gasPrice,
                to: to,
                value: lweb3.utils.toWei(value, 'ether'),
                data: '0x00'//转Token代币会用到的一个字段
            };

            let gas = await web3.eth.estimateGas(rawTx);
            rawTx.gas = gas;

            var tx = new Tx(rawTx);
            tx.sign(privateKey);
            var serializedTx = tx.serialize();
            
            web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex')) .then(function(data) {
                console.log(data);
            });
```

推荐以下这种写法

> 先构建好已签名的交易
>
> let tx = await web3.eth.accounts.signTransaction(rawTx, account.privateKey)
>
> 将
>
> web3.eth.sendSignedTransaction(tx.rawTransaction)

```
let gasPrice = await web3.eth.getGasPrice();
            var rawTx = {
                gasPrice: gasPrice,
                to:"0x20f62c75e39a932f9bb1e27ad5a3f75b5ddf72a4",
                value:lweb3.utils.toWei("666", 'ether')
            };
            let gas = await web3.eth.estimateGas(rawTx);
            rawTx.gas = gas;
            let account = await lweb3.eth.accounts.decrypt(keystore, password);
            let tx = await web3.eth.accounts.signTransaction(rawTx, account.privateKey);
            console.log(tx.rawTransaction);
            let hash = await web3.eth.sendSignedTransaction(rawTransaction);
```



##### 获取地址余额

```js
web3.eth.getBalance(address, block)
```

> address 是地址
>
> block 默认为latest，也可以是blockNum 比如348
>
> 方法含义：到某一个区块时，某一个address的余额是多少

##### 获取区块信息【block】

```js
// 参数根据区块number或者hash，返回区块信息
web3.eth.getBlock(blockHashOrBlockNumber)
// 返回一个区块中交易笔数
web3.eth.getBlockTransactionCount(blockHashOrBlockNumber).then(console.log)
// 返回一个区块中叔块数量
web3.eth.getBlockUncleCount(blockHashOrBlockNumber).then(console.log);
```

##### 获取转账信息【transaction】

```js
// 参数根据区块number或者hash，返回转账信息
            let transaction = await web3.eth.getTransactionFromBlock(blockHashOrBlockNumber, indexNumber);
            // 返回转账信息
            await web3.eth.getTransaction(transaction.hash).then(console.log);
            // 返回未处理的转账信息
            await web3.eth.getPendingTransactions().then(console.log);
            // 返回收到该笔交易的区块信息
            await web3.eth.getTransactionReceipt(transaction.hash).then(console.log);
            
```



##### 获取一个地址历史转账记录和转账笔数

web3.js没有提供查一个地址的历史转账记录，有以下三种实现方式

> 1. 遍历区块，再遍历区块中的交易，匹配from,to字段
>
>    用来实现的方法：
>
>    web3.eth.getTransactionFromBlock(blockHashOrBlockNumber, indexNumber);
>
> 2. 监听方式，订阅区块链消息。
>
>    可以使用的方法:
>
>    web3.eth.subscribe('logs', {address:"xx"})
>
>    以下二种也可实现
>
>    web3.eth.subscribe('pendingTransactions')
>
>    web3.eth.subscribe('newBlockHeaders')
>
>    这种方式如果rpc出现服务中断，数据会丢失
>
> 3. 独立job去遍历区块链，将数据保存在本地数据库中
>
> 我个人推荐第3种方式，区块链信息会被多次查询，保存在数据库是个不错的选择

```js
// 一个地址发起的转账笔数
            await web3.eth.getTransactionCount(transaction.from).then(console.log);
```



##### 一段信息用私钥签名与公钥验签过程

私钥签名过程

> 先从keystore文件+password中获取私钥
> 
> 然后私钥签名，得到signature.signature结果
>
> lweb3.eth.accounts.sign(message, account.privateKey)

```js
let account = await lweb3.eth.accounts.decrypt(keystore文件内容, password);
            let signature = await lweb3.eth.accounts.sign(message, account.privateKey);
            // signature.signature
```

公钥验签过程

> 根据signature.signature和message,就可以返回签名私钥对应的地址

```js
let message = req.body.message;
            let signature = req.body.signature;
            // 返回签名私钥对应的地址
            let address = await lweb3.eth.accounts.recover(message, signature);
            console.log(address);
// 最后校对address即可
```

##### 交易用私钥签名与公钥验签过程

交易用私钥签名过程

```js
let gasPrice = await web3.eth.getGasPrice();
            var rawTx = {
                gasPrice: gasPrice,
                to:"0x20f62c75e39a932f9bb1e27ad5a3f75b5ddf72a4",
                value:lweb3.utils.toWei("666", 'ether')
            };
            let gas = await web3.eth.estimateGas(rawTx);
            rawTx.gas = gas;
            let account = await lweb3.eth.accounts.decrypt(keystore, password);
            let tx = await web3.eth.accounts.signTransaction(rawTx, account.privateKey);
            console.log(tx.rawTransaction);
```

交易公钥验签过程

```js
 let rawTransaction = req.body.rawTransaction;
            // 返回签名私钥对应的地址
            let address = await lweb3.eth.accounts.recoverTransaction(rawTransaction);
            console.log(address);
```

##### 转账已签名交易

```js
let rawTransaction = req.body.rawTransaction;

let transaction= await web3.eth.sendSignedTransaction(rawTransaction);
// transaction 是transaction对象
```

##### 订阅区块、转账交易、地址的事件





#### geth自带console实现关键技术





#### golang实现关键技术

> 这里采用官方golang实现Ethereum协议的代码库
>
> https://github.com/ethereum/go-ethereum
>
> go-ethereum的文档列表：
>
> https://godoc.org/github.com/ethereum/go-ethereum/rpc
>
> https://godoc.org/github.com/ethereum/go-ethereum
>
> https://pkg.go.dev/github.com/ethereum/go-ethereum?tab=doc

```golang
package main

import (
    "fmt"
    "github.com/ethereum/go-ethereum/rpc"
)

func main() {

    client, err := rpc.Dial("http://localhost:8545")
    if err != nil {
        fmt.Println("rpc.Dial err", err)
        return
    }   

    var account[]string
    err = client.Call(&account, "eth_accounts")
    var result string
    //var result hexutil.Big
    err = client.Call(&result, "eth_getBalance", account[0], "latest")
    //err = ec.c.CallContext(ctx, &result, "eth_getBalance", account, "latest")

    if err != nil {
        fmt.Println("client.Call err", err)
        return
    }   

    fmt.Printf("account[0]: %s\nbalance[0]: %s\n", account[0], result)
    //fmt.Printf("accounts: %s\n", account[0])
}
```





#### block对象结构



#### transaction对象结构



#### keystore文件与私钥关系

> 如果私钥直接进行存储，一旦被盗，数字资产将被洗劫一空
>
> keystore文件是将私钥进行再加密后得到，只有同时盗取 keystore 文件和密码才能盗取我们的数字资产，相对安全多了。

> 助记词=密钥=(keystore+密码)

![29ce9ec7823e44198b8a223cb1414b92](/home/znddzxx112/workspace/caokelei/blog/ethereum/29ce9ec7823e44198b8a223cb1414b92.png)



> 上图解释清楚了keystore生成过程和从keystore中得到私钥过程
>
> mac值的作用：mac = sha256( 解密密钥 + **ciphertext** 密文), 在正式解密前就能知道解密密钥正确与否，从而可知passpharse是否正确
>
> 解释一下图中的过程：
>
> - **Cipher** 是用于加密以太坊私钥的对称加密算法。此处cipher用的是 *aes-128-ctr* 加密模式。
> - **Cipherparams** 是 *aes-128-ctr* 加密算法需要的参数。在这里，用到的唯一的参数 *iv*，是*aes-128-ctr*加密算法需要的初始化向量。
> - **Ciphertext** 密文是 *aes-128-ctr* 函数的加密输出。
>
> cipher的密钥比较长，同样难记忆，所以才会继续使用【密钥生成函数kdf】
>
> - **kdf** 是一个密钥生成函数，根据你的密码计算（或者取回）**解密密钥**。在这里，**kdf** 用的是*scrypt*算法。
> - **kdfparams** 是*scrypt*函数需要的参数。在这里，简单来说，*dklen、n、r、p* 和 *salt* 是 **kdf** 函数的参数。
>
> cipher密钥是kdf函数的输出



#### 其他作者优秀文章

> 这个作者的几篇文章都不错
>
> https://www.cnblogs.com/tinyxiong/p/9927300.html
>
> 关于keystore介绍的配图来源：https://www.cnblogs.com/405845829qq/p/10103747.html