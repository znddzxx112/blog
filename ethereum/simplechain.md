

[TOC]



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