

[TOC]



### 安装

#### GUI客户端

> https://www.simplechain.com/

```bash
$ tar -zxvf SimpleNode.tar.gz -C ~/local/
```

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
$ sipe --datadir ~/data/sipc-main --syncmode=fast
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

> var balance = eth.getBalance("0x592f5a5c52318b16c36106d9efa5cf12cd16cf70")
>
> web3.fromWei(balance, "ether")