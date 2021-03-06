[TOC]



### 资源

> github：https://github.com/ethereum/go-ethereum
>
> 与eth通信的json-rpc wiki:https://github.com/ethereum/wiki/wiki/JSON-RPC
>
> 有官方go实现，cpp,pythen实现
>
> nodejs实现的web3.js库，文档：https://web3js.readthedocs.io/en/v1.2.6/
>
> 以太坊技术与实现：https://learnblockchain.cn/books/geth/part3/sign-and-valid.html

### 安装ethereum

前提安装golang,C compilers 

#### 方式1：源码安装

```bash
$ git clone https://github.com/ethereum/go-ethereum
$ sudo apt-get install -y build-essential
$ cd go-ethereum
$ make geth
```

#### 方式2：ubuntu ppa

> https://github.com/ethereum/go-ethereum/wiki/Building-Ethereum

```
$ sudo add-apt-repository -y ppa:ethereum/ethereum
$ sudo apt-get update
$ sudo apt-get install ethereum
```



### 标准命令

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

### 运行geth

#### 运行主网节点

```bash
$ geth  --syncmode=light --datadir=~/data/eth-main 
```

 `--syncmode` 参数的同步模式

`--syncmode=full`

> full模式，从开始到结束，获取区块header和body,并且校验每个元素，需要下载所有区块信息。

`--syncmode=fast`

> fast模式，历史区块的快照，历史不会逐一验证，此后，像full节点一样进行同步操作。可能会丢失部分，不会影响后续

`--syncmode=light`

> 仅获取当前状态。会向full节点发起请求

> 轻节点满足“创建账户”，“转账”，“部署合约与合约交互”三个场景，不涉及历史数据
>
> 速度最快半个小时完事，磁盘大小300M左右

--gcmode=archive

> Archive mode means that all states of values in smart contracts as well as all balances of an account are stored.
>
> 保留合约和账户的历史数据，如果不使用，只能查到最新区块，某个账户的钱

` --datadir` 参数可以选择数据保存位置

##### 主网节点配置

> ```undefined
> CPU: 8 core
> 内存: 16G
> 硬盘: 500G SSD (固态硬盘)
> 网络: 5M+
> ```

##### 进入控制台

```bash
$ geth attach ~/data/eth-main/geth.ipc
```

##### 查看同步状态

> eth.syncing
>
> false // 代表同步成功

查看当前区块

> eth.blockNumber

#### 测试网络运行节点

```bash
// pow
$ geth --testnet --syncmode=light --datadir ~/data/eth-test-ropsten
// poa
$ geth --rinkeby  --syncmode=light --datadir ~/data/eth-test-rinkeby --bootnodes=enode://a24ac7c5484ef4ed0c5eb2d36620ba4e4aa13b8c84684e1b4aab0cebea2ae45cb4d375b77eab56516d34bfbd3c1a833fc51296ff084b770b94fb9028c4d25ccf@52.169.42.101:30303
```

`--networkid=x` 区分网络，只有相同网络id值才可相连

1，默认代表主网

3, --testnet ropsten测试网络 pow网络

4, --rinkeby rinkeby网络,POA网络

国内区块浏览器

> http://ropsten.ethhelp.cn/

国内ropsten节点

> 1. admin.addPeer('enode://2d1e1f1242c3b54ea56046f74f15943f47ab410e3c0b82bffb501793ebb19e147f8f0e63d01c2a6052b5db8d8c9caa9f1b04cabf917a38c38f78284192cebf55@47.93.7.170:20000'); *// 62ms*
> 2. admin.addPeer('enode://7ab83cadce8b5f82a3154874454ec18eccf6076a4f3a6474fe62f77cb7586fddfa42852be9b7493f9df2a3e5fd74035470db24ac51f070f7770ef65a5a2949ef@47.98.221.237:43248'); *// 52ms*
> 3. admin.addPeer('enode://9b65efd19d3b4df4a44cb20b9e9bc62d3051f2637c19518b01c31ace9bf648cbb9b1f207389589a8d34d0de3960046433863915f0dc7dd32b58807c20c7af9be@101.201.155.117:30303'); *// 62ms*
> 4. admin.addPeer('enode://9c854be9dc0b2e79c95799a8b3ef5f8894338cf28dbf0aed3d3ea8530e5bb59266ba9250dffc84d57b3aca3f9db087d5da7099aa3d8a95bf7fbb0f62ae6026a9@47.96.231.38:30305'); *// 53ms*
> 5. admin.addPeer('enode://c5773269cee16da31342bc9bc525de1bc5e1de492be138bc24dadfa1a14d67fffa556b1da64566b4a61dac5b76db79eb39e74dbf19835dac8e516dd34a5ad5a3@116.62.148.208:30303'); *// 45ms*

rinkeby水龙头网站

> https://faucet.rinkeby.io/

#### 本地开发环境搭建

```bash
$ mkdir -p ~/data/eth-dev
$ geth --dev --dev.period 0 --networkid=1444 --datadir ~/data/eth-dev --rpc --rpcaddr 0.0.0.0 --rpcport 8545 --ws --wsaddr "0.0.0.0" --wsorigins="*"  --wsport 8546 --rpcapi web3,eth,debug,personal,net --vmdebug --rpccorsdomain="http://127.0.0.1:8080" --allow-insecure-unlock --unlock "0xec44cfa70aedf56a9b65e4f7d092567671d3b618"


```

> --dev.period 出块周期 0:代表交易发生时才出块
>
> --dev 允许挖矿,搭建一个POA(proof-of-authority)私有网络
>
> --rpc 启用rpc,http-rpc
>
> --rpcaddr 地址
>
> --rpcport 端口

#### 部署私有网络（再造一个 以太坊）

> https://github.com/ethereum/go-ethereum#operating-a-private-network

#### docker方式运行节点

> https://github.com/ethereum/go-ethereum#docker-quick-start

### 编程语言与`geth`节点交互

> 作为开发者，不满足通过geth attach提供的方式与geth交互。
>

#### geth中与json-rpc相关参数

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

#### geth控制台命令文档

`admin,debug,miner,personal,txpool`的文档在下方

> https://github.com/ethereum/go-ethereum/wiki/Management-APIs

`eth`的文档在下方

> https://github.com/ethereum/wiki/wiki/JavaScript-API
>
> 另外 eth = web3.eth
>
> personal =web3.personal

在控制台输入`web3`能看到所有的接口名称

#### 各种语言与geth通信JSON-RPC文档

实现如下json-rpc规范文档，即可

json-rpc是协议规范，通信方式可选http,websock,ipc皆可

> https://github.com/ethereum/wiki/wiki/JSON-RPC

nodejs已经实现json-rpc，库名称web3.js文档

> https://web3js.readthedocs.io/en/v1.2.6/web3-eth.html

### nodejs实现关键操作

> 这里采用web3.js库作为基础
>
> lweb3,web3代表含义，库自身与rpc提供的功能更加严格的区分

```js
const lweb3 = new Web3() 
const web3= new Web3(new Web3.providers.HttpProvider(config.geth))
```

#### 创建离线钱包

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

#### 通过keystore导入钱包

> 目的得到address验证密码是否正确，并把keystore存储

```js
let account = web3.eth.accounts.decrypt(keystore, password)
console.log(account.address, account.privateKey)
```

#### 通过私钥导入钱包

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

#### 通过助记词导入钱包和导出钱包

> BIP39钱包助记词规范，可以找相应实现的各个语言的库
>
> https://www.jianshu.com/p/d5bac6d36dc6



#### keystore形式和私钥形式导出钱包

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

#### 修改keystore密码

> 先用旧密码解锁keystore,并得到私钥
>
> 然后用私钥和新密码得到新的keystore文件，并存储

```bash
oldaccount = await lweb3.eth.accounts.decrypt(keystorev3 json,oldpassword)
// 返回新的keystore文件
lweb3.eth.accounts.encrypt(oldaccount.privateKey, newPassword)
```

#### 转账

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



#### 获取地址余额

```js
web3.eth.getBalance(address, block)
```

> address 是地址
>
> block 默认为latest，也可以是blockNum 比如348
>
> 方法含义：到某一个区块时，某一个address的余额是多少

#### 获取区块信息【block】

```js
// 参数根据区块number或者hash，返回区块信息
web3.eth.getBlock(blockHashOrBlockNumber)
// 返回一个区块中交易笔数
web3.eth.getBlockTransactionCount(blockHashOrBlockNumber).then(console.log)
// 返回一个区块中叔块数量
web3.eth.getBlockUncleCount(blockHashOrBlockNumber).then(console.log);
```

#### 获取转账信息【transaction】

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



#### 获取一个地址历史转账记录和转账笔数

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



#### 一段信息用私钥签名与公钥验签过程

##### 私钥签名过程

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

##### 公钥验签过程

> 根据signature.signature和message,就可以返回签名私钥对应的地址

```js
let message = req.body.message;
            let signature = req.body.signature;
            // 返回签名私钥对应的地址
            let address = await lweb3.eth.accounts.recover(message, signature);
            console.log(address);
// 最后校对address即可
```

#### 交易用私钥签名与公钥验签过程

##### 交易用私钥签名过程

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

##### 交易公钥验签过程

```js
 let rawTransaction = req.body.rawTransaction;
            // 返回签名私钥对应的地址
            let address = await lweb3.eth.accounts.recoverTransaction(rawTransaction);
            console.log(address);
```

#### 转账已签名交易

```js
let rawTransaction = req.body.rawTransaction;

let transaction= await web3.eth.sendSignedTransaction(rawTransaction);
// transaction 是transaction对象
```

#### 区块产生、转账交易、地址变动的事件订阅

> web3提供这三种时间监听
>
> web3.eth.subscribe('pendingTransactions')
>
> web3.eth.subscribe('newBlockHeaders')
>
> web3.eth.subscribe('logs')

```
web3.eth.subscribe('logs', {
        address: '0x20f62c75e39a932f9bb1e27ad5a3f75b5ddf72a4'
    }, function(error, result){
        if (!error)
            console.log(result);
    })
    .on("connected", function(subscriptionId){
        console.log(subscriptionId);
    })
    .on("data", function(log){
        console.log(log);
    })
    .on("changed", function(log){
        console.log(log);
    });
```



### geth控制台实现关键操作

> 如果有多种网络，把 --datadir带上较好

#### 创建账号

```bash
$ geth --datadir ~/data/eth-test-ropsten account new
```

#### 私钥导入账号

> personal.importRawKey("938","keypass")

#### 查看账号

```bash
$ geth --datadir ~/data/eth-test-ropsten account list
Account #0: {abab347093fa054a2d40b88426c4686abea2e99a} keystore:///home/
```

#### 更新账号密码

```bash
$ geth --datadir ~/data/eth-test-ropsten account update 0
```

#### 连接控制台

```bash
$ geth --datadir ~/data/eth-test-ropsten attach
// 或者
$ geth attach ~/data/eth-test-ropsten/geth.ipc
// 或者
$ geth --datadir ~/data/eth-test-ropsten console
```

> attach 连接一个节点
>
> console不连接节点

#### 转账

> 在控制台执行

##### 解锁账户

```bash
> personal.unlockAccount()
```

##### 发送转账

```bash
>eth.sendTransaction({from:"0x7f53309f95559c52d08f18724c0b24aa758d1953",to:"0xf9143e3b7de8ce91e463e30480f5afe84d3067ba",value:web3.toWei(10,"ether")})
"0x5a6fbb3161329ca2591b7ecbcaca8a15a94cac5d402fce929f24504c76b8b7bb"
```

#### 合约部署

```bash
eth.sendTransaction({from:"0xec44cfa70aedf56a9b65e4f7d092567671d3b618", data:"0x608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055506000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16600073ffffffffffffffffffffffffffffffffffffffff167f342827c97908e5e2f71151c08502a66d44b6f758e3ac2f1de95f02eb95f0a73560405160405180910390a36101e6806100dc6000396000f3fe608060405234801561001057600080fd5b50600436106100365760003560e01c80630ae50a391461003b578063f285329214610085575b600080fd5b6100436100c9565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6100c76004803603602081101561009b57600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291905050506100f2565b005b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b8073ffffffffffffffffffffffffffffffffffffffff166000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff167f342827c97908e5e2f71151c08502a66d44b6f758e3ac2f1de95f02eb95f0a73560405160405180910390a3806000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055505056fea2646970667358221220b8bf5bf0bc80e1906626e07809f2307347a8a915ad8311f8af0aa48e0f655e2264736f6c63430006060033", value:0})
```

通过回执查看合约地址

```bash
eth.getTransactionReceipt("0x58c8832e2add782ce19816d4a1e53ba47582ac5a0c2ea1a157d501efd230fbbb")
```



#### 没有命令可以直接导出私钥，基点是keystor文件



### golang实现关键操作

> 采用ethereum官方实现golang的rpc代码库
>
> https://github.com/ethereum/go-ethereum/rpc
>
> rpc文档：
>
> https://github.com/ethereum/wiki/wiki/JSON-RPC

#### 定义基本EthRpcClient结构

> 这里以http-rpc为例子，在实际项目中定义EthRpcClient结构体，方便在项目中调用
>
> 包中go文件规划如下：
>
> rpc.go 存放EthRpcClient结构体相关
>
> transactions.go 存放转账交易相关
>
> blocks.go 存放区块相关
>
> accounts.go 存放钱包账户相关

```go
package ethereum

import (
	"github.com/ethereum/go-ethereum/rpc"
)

type EthRpcClient struct {
	client *rpc.Client
}

func NewEthRpcClient(ethHttpRpc string) *EthRpcClient {
	e := new(EthRpcClient)
	ethRpcClient, dialHttpErr := rpc.DialHTTP(ethHttpRpc)
	if dialHttpErr != nil {
		log.Fatal("EthRpcClient:", dialHttpErr)
	}
	e.client = ethRpcClient
	return e
}
func (ethClient *EthRpcClient) GetClient() *ethclient.Client {
	return ethclient.NewClient(ethClient.client)
}
```

#### 转发已签名交易

```go
func (ethClient *EthRpcClient) SendRawTransaction(rawTransactionData string) (transactionHash string, callErr error) {
	transactionHash = ""
	callErr = ethClient.client.Call(&transactionHash, "eth_sendRawTransaction", rawTransactionData)
	return
}
```

#### 获取交易信息

```go
type RpcTransaction struct {
	BlockHash        string `json:"blockHash"`
	BlockNumber      string `json:"blockNumber"`
	From             string `json:"from"`
	Gas              string `json:"gas"`
	GasPrice         string `json:"gasPrice"`
	Hash             string `json:"hash"`
	Input            string `json:"input"`
	Nonce            string `json:"nonce"`
	To               string `json:"to"`
	TransactionIndex string `json:"transactionIndex"`
	Value            string `json:"value"`
	V                string `json:"v"`
	R                string `json:"r"`
	S                string `json:"s"`
}

func (ethClient *EthRpcClient) GetTransactionByHash(txHash string) (transaction *RpcTransaction, callErr error) {
	transaction = &RpcTransaction{}
	callErr = ethClient.client.Call(transaction, "eth_getTransactionByHash", txHash)
	return
}
```



### block对象结构



### transaction对象结构



### gasLimit与gasPrice含义

> 为了衡量执行成功某一些操作需要花费的代价
>
> 某一些操作，比如转账，合约执行。合约执行比转账更加复杂，所需代价更高
>
> gas 中文翻译 汽油，瓦斯
>
> gasLimit ：总gas量。衡量完成操作所需的汽油总量，如果总量设低了，即完不成操作，gas还会被收取
>
> gasPrice: 每份gas的价格。
>
> 操作手续费=gasLimit * gasPrice
>
> 为了转账手续费可以由微调gasPrice，手续费低完成转账时会延长。设置gasLimit过低，会完不成操作，所以要选择合适的gasLimit。
>
> 这个网站https://ethgasstation.info/可以查询gasPrice与时间关系

### keystore文件与私钥关系

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



### 智能合约

##### 关于智能合约solidity语言教程

> https://solidity-cn.readthedocs.io/zh/develop/

##### eth浏览器

> https://eth.tokenview.com/cn/

eth代币查看

> https://cn.etherscan.com/

usdt代币的合约 https://cn.etherscan.com/address/0xdac17f958d2ee523a2206206994597c13d831ec7#code

#### 合约概念

##### 事务

> 一般来说，写入数据称为事务，而读取数据称为调用。事务和调用的处理方式非常不同。
>
> 事务改变网络的状态。一般账户之间转账，执行合同，部署合同。
>
> 事务执行需要gas和时间
>
> 事务调用之后一般不能立即收到返回值，因为不是立即执行。会立即返回事务id

事务特点

> 消耗gas
>
> 改变网络状态
>
> 不会立即执行
>
> 不要期望有返回值，仅仅返回事务id

##### 调用

调用特点

> 不会消耗gas
>
> 不会改变网络状态
>
> 立即执行
>
> 有返回值

#### 部署流程

大致如下：

>  1.启动一个以太坊节点
>  2.编译已写好的智能合约
>  3.将编译好的智能合约部署到节点网络（这一步会消耗以太币，还需要使用你的节点的默认地址或者指定地址来给合约签名。） => 获得合约地址
>  4.用web3.js提供的JavaScript API来调用合约

#### 推荐使用remix-ide完成编写和部署过程

```
docker pull remixproject/remix-ide:latest
docker run -p 8080:80 -d remix-ide --name remixproject/remix-ide:latest
```

浏览器打开 http://127.0.0.1:8080

本地节点需要加上这几个配置项

> geth --rpc --rpcapi web3,eth,debug,personal,net --vmdebug --rpccorsdomain="http://127.0.0.1:8080"

#### 安装Solidity编译器Solc

```bash
sudo add-apt-repository ppa:ethereum/ethereum
sudo apt-get update
sudo apt-get install solc
```

> 文档地址：https://solidity-cn.readthedocs.io/zh/develop/using-the-compiler.html#commandline-compiler

#### 使用Webstorm作为sol文件编辑器

> 安装插件Intellij-Solidity

#### truffle安装

> 类似于solidity语言依赖管理，类似java的maven
>
> 自己与区块链进行交互是繁琐，truffle让交互变得轻松

```bash
$ npm install -g truffle
```

文档

> https://www.trufflesuite.com/docs/truffle/quickstart



#### ganache-cli安装

```bash
$ npm install -g ganache-cli
```

> Ganache-cli是为以太坊开发准备的个人区块链钱包，你可以用它执行智能合约，研发应用和执行测试用例。Ganache的前身是testrpc，跟testrpc的作用一样。

#### 代码例子

##### 投票

> 主席发起多个提案以及允许可以投票的账户地址，投票账户直接投或者把票委托给其他账户（增加其他账户的权重）

##### 拍卖

> 拍卖价格公开：每个账户发送value给合约，合约是否为最高价。
>
> 其他非最高价可以划转回原账户
>
> 拍卖价格非公开（盲拍）

##### 远程购买

> 卖方创建合约，在合约非锁定时，卖方可以撤销
>
> 买方花2倍的资金转账到合约，使合约状态为锁定，卖方不可撤销
>
> 买方可触发确认收货，合约状态closed，资金划转
>
> 商业模式：
>
> 1. 卖方必须要买方确认，才可以拿到资金
>2. 买方花费2倍资金，才拿到商品

#### 智能合约MetaCoin项目作为例子

```bash
$ mkdir MetaCoin
$ cd MetaCoin
$ truffle unbox metacoin
```

> metaCoin github地址:https://github.com/truffle-box/metacoin-box

正常新建项目使用命令

```bash
$ mkdir helloword
$  truffle init
```

##### ganache-cli启动节点

```bash
$ ganache-cli -h 127.0.0.1 -p 7545 --networkId 5777
```

##### 修改truffle-config.js配置

```javascript
networks: {
      development: {
          host: "127.0.0.1",     // Localhost (default: none)
          port: 7545,            // Standard Ethereum port (default: none)
          // from: "0x52652789342a4c7A828b1E7A11c78A748476D511",//Account to send txs from (default: accounts[0])
          network_id: "5777",       // Any network (default: none)
      },
      compilers: {
        solc: {
            version: "0.4.25",    // Fetch exact version from solc-bin (default: truffle's version)
            // docker: true,        // Use "0.5.1" you've installed locally with docker (default: false)
            // settings: {          // See the solidity docs for advice about optimization and evmVersion
            //  optimizer: {
            //    enabled: false,
            //    runs: 200
            //  },
            //  evmVersion: "byzantium"
            // }
        }
    }
   }
```

##### 连接节点

```bash
$ truffle console --network development
```

##### 编译和部署合约,并调用合约的方法

> https://www.trufflesuite.com/docs/truffle/getting-started/interacting-with-your-contracts
>
> 存在疑问

```bash
$ truffle compile --network development
$ truffle migrate --network development
或者
truffle(development)> compile
truffle(development)> migrate
// 调用
truffle(development)> let ins = await MetaCoin.deployed()
等效于
truffle(development)> let ins = ConvertLib.at("0x79804eCc027E2Fc9E1D1ACec6bad402032414Dfe")

truffle(development)> let accounts = await web3.eth.getAccounts()
truffle(development)> let balance = await ins.getBalance(accounts[0])
truffle(development)> balance.toNumber()
truffle(development)>  let result = await  instance.sendCoin(accounts[1], 10, {from: accounts[0]})
```

> truffle(development)> balance.toNumber() 
>
> 将BN对象，转成number
>
> {from: accounts[0]} 是隐藏对象，即Ethereum transaction
>
> 有以下字段
>
> - `from`
> - `to`
> - `gas`
> - `gasPrice`
> - `value`
> - `data`
> - `nonce`
>
> result
>
> - `result.tx` *(string)* - Transaction hash
> - `result.logs` *(array)* - Decoded events (logs)
> - `result.receipt` *(object)* - Transaction receipt (includes the amount of gas used)

##### 重新发布合约

```bash
truffle(develop)> let newInstance = await MetaCoin.new()
truffle(develop)> newInstance.address
'0x64307b67314b584b1E3Be606255bd683C835A876'
```





##### 事件监听



#### 深入理解Solidity

> https://solidity-cn.readthedocs.io/zh/develop/solidity-in-depth.html



### 其他作者优秀文章

> 这个作者的几篇文章都不错
>
> https://www.cnblogs.com/tinyxiong/p/9927300.html
>
> 关于keystore介绍的配图来源：https://www.cnblogs.com/405845829qq/p/10103747.html



### defi

#### 项目风险

这个项目有三个风险  第三个风险是这个项目独有的
一个是合约漏洞风险       （被盗 被锁）
一个是管理员权限集中风险（跑路）
一个是pmm算法  “预言机”这一个环节的巨大风险（人为操纵喂价）

#### 为啥借贷火？

1、 预期eth会涨，防止踏空。但又想使用其他币

#### defi几个方向

1、 借贷平台：maker、 compound。
1.1、 核心问题：抵押品的价格变化。 变低先要求交保证金，如果不交就清算，变高就可以获取更多。

#### 什么是无常损失？

#### 如何避免无常损失？

https://www.mytokencap.com/news/153663.html
1、 使用稳定币
2、 使用sushi类代币弥补
3、 主动出击，使用价格预言机（price oracle）