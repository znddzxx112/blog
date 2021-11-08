

[TOC]



#### 运行私有节点

gensis.json

```
{
  "config": {
    "chainId": 20,
    "homesteadBlock": 0,
    "eip150Block": 0,
    "eip155Block": 0,
    "eip158Block": 0,
    "byzantiumBlock": 0,
    "constantinopleBlock": 0,
    "petersburgBlock": 0,
    "istanbulBlock": 0,
    "berlinBlock": 0,
    "londonBlock": 0
  },
  "alloc": {},
  "coinbase": "0x0000000000000000000000000000000000000000",
  "difficulty": "20",
  "extraData": "",
  "gasLimit": "2100000",
  "nonce": "0x0000000000000042",
  "mixhash": "0x0000000000000000000000000000000000000000000000000000000000000000",
  "parentHash": "0x0000000000000000000000000000000000000000000000000000000000000000",
  "timestamp": "0x00"
}
```

```
$ sipe init gensis.json --datadir ./data
$ sipe --datadir ./data console 2>>sipe.log
```

获取p2p network: enode://922445bd1c853206c29710ead5e26d0efc34aabfd341eaecde8a1498ff53ff2248e8466844821d7758297dd30d27b93ca85d77dc9255ffdcb88cbf073f9a39bf@127.0.0.1:30303

#### 另一台机器开始挖矿

```
$ sipe --datadir ./minedata --mine --miner.threads=1 --miner.etherbase=0xBBE7C71F775246E727390B44CC9161A08F4e4eEf
```

或者

```
$ sipe attach ./data/sipe.ipc
> miner.setEtherbase("0xBBE7C71F775246E727390B44CC9161A08F4e4eEf")
> miner.start(1)
```

#### 生成ca证书

```
sipe ca new --datadir ./data
```



#### 允许rpc连接，开发智能合约

```
$ sipe --datadir ./data --rpc --rpcaddr 0.0.0.0 --rpcport 8545  --rpcapi web3,eth,debug,personal,net --vmdebug --rpccorsdomain="https://remix.ethereum.org" console
```

#### 创建新账户

```
$ sipe attach ./data/sipe.ipc
$ personal.newAccount()
```

#### 挖矿地址向新创建的地址转账

通过小狐狸钱包

#### 小狐狸钱包连接私有网络

设置-》新增网络

#### 使用remix开发智能合约

打开https://remix.ethereum.org/

选择injeckted Web3

#### 





### 安装

#### GUI客户端

> https://www.simplechain.com/

```bash
$ tar -zxvf SimpleNode.tar.gz -C ~/local/
```

有时github源码拉取速度慢，可从GUI客户端其中获取到sipe命令

#### 命令行客户端

下载代码

> https://github.com/simplechain-org/go-simplechain

```bash
$ make sipe
```

方便调用加个软连接

```bash
$ ln -s ~/workspace/sipc/go-simplechain/build/bin/sipe ~/bin/
```

### 运行主网节点

```bash
$ sipe --datadir ~/data/sipc-main --syncmode=fast  --rpc --rpcaddr 0.0.0.0 --rpcport 8545 --rpcapi web3,eth,debug,personal,net --rpccorsdomain="http://127.0.0.1:8080" --allow-insecure-unlock
```

> 同步到3056565区块，花费30分钟

### sipe控制台实现关键操作

#### 创建账户

```bash
$ sipe --datadir ~/data/sipc-main account new
```

#### 导入账户

> personal.importRawKey("938","keypass")

#### 查看余额

> web3.fromWei(eth.getBalance("0x592f5a5c52318b16c36106d9efa5cf12cd16cf70"), "ether")

### 合约编写与部署

#### 使用remix-ide完成编写和部署过程

```
docker pull remixproject/remix-ide:latest
docker run -p 8080:80 -d remix-ide --name remixproject/remix-ide:latest
```

本地节点需要加上这几个配置项

> sipe --datadir ~/data/sipc-main --syncmode=fast  --rpc --rpcaddr 0.0.0.0 --rpcport 8545 --rpcapi web3,eth,debug,personal,net --rpccorsdomain="http://127.0.0.1:8080" --allow-insecure-unlock

#### 导入账号并解锁账号

> personal.importRawKey("938","keypass")
>
> personal.unlock("xxxx")