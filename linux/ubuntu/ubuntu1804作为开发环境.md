[TOC]

#### ubuntu18.04安裝

1. 下载ubuntu的iso文件

   > 使用国内的镜像源，下载速度更快速些

2. 制作成U盘启动盘

   > 使用ultrios工具制作

3. 系统使用U盘启动

   > 按照提示依次next

#### 软件安装

##### ssh

> openssh-server安装

```bash
$ sudo apt-get install openssh-server
$ sudo vi /etc/ssh/sshd.config
// 开通Port和允许公钥登录
Port 22
PubkeyAuthentication yes
AuthorizedKeysFile .ssh/authorized_keys .ssh/authorized_keys2
$ sudo service ssh restart
// 将公钥写入.ssh/authorized_keys 即可实现公钥登录
```

##### vpn客户端

> 参考文章：http://www.pianshen.com/article/156769043/

> 1. 安装l2tp/ipsec

```bash
$ sudo apt-get install network-manager-l2tp-gnome
```

> 2. Ubuntu18.04 右上角 下拉箭头中找 设置 或者直接点击 齿轮型图标，进入设置。
>
> 3. 在设置界面，选择网络，界面出现 VPN
>
> 4. 点击VPN右侧的 +,
>    便可以看见第2层隧道协议（L2TP）
>    说明执行的命令生效。
>
> 5. 点击L2TP进入界面填写入：代理地址，用户名和密码。
>
> 6. 【IPsec设置】
>
>    填写Pre-shared key
>
>    Phase1 Algorithms:填入3des-sha1-modp1024
>
>    Phase2 Algorithms:填入3des-sha1

##### vim

原因

> ubunt18.04使用vim-tiny版版本,退格键不能使用

做法

> 卸载tiny 版本,安装full 版本

```bash
  $ sudo apt-get remove vim-common

  $  sudo apt-get install vim
```

##### git

```bash
$ sudo apt install git
```

设置email和name

> git config --local user.email "znddzxx112@163.com"
>
> git config --local user.name "znddzxx112"

##### Beekeeper Studo

> snap install Beekeeper

##### RDM

> snap install redis-desktop-manager

##### synergy

> 安装鼠标键盘共享软件

```bash
$ sudo apt install synergy
```

> 软件设置中要取消 use ssl encryption
>
> 开放端口 ufw allow 24800/tcp,随后ufw reload

##### postman

> 下载页面:https://www.postman.com/downloads/

```bash
$ tar -zxvf Postman-linux-x64-7.19.1.tar.gz -C ~/local/
$ ln -s ~/local/postman/Postman ~/bin
```

##### sublime_text

> https://www.sublimetext.com/3

```bash
$ tar -xjvf sublime_text_3_build_3211_x64.tar.bz2 -C ~/local/
$ ln -s /home/znddzxx112/local/sublime_text_3/sublime_text /home/znddzxx112/bin/
$ sublime
```

##### robo 3t

> https://robomongo.org/download
>
> mv robo3t-1.4.3-linux-x86_64-48f7dfd ~/local/robo3t
>
> ln -s ~/local/robo3t/bin/robo3t ~/bin/

##### krakan

> 要收费了
>
> 官网下载：https://www.gitkraken.com/ 
>
> 下载ubuntu1604的deb包,然后双击安装
>
> 输入gitkraken打开

##### smartgit

> 要收费，非商业用途
>
> 下载：https://www.syntevo.com/smartgit/download/
>
> 安装：https://www.syntevo.com/smartgit/download/#installation-instructions

```bash
// 安装，让系统记住缺失的包
$ sudo dpkg -i smartgit-19_1_7.deb
// 如果有依赖包未安装
$ sudo --fix-broken install
// 再次执行
$ sudo dpkg -i smartgit-19_1_7.deb
// 搜索软件包
$ dpkg -l | grep smargit
// 删除
$ sudo dpkg -r smartgit
```

##### git cola

> 自由软件
>
> 包含git-cola git-DAG
>
> 推荐使用git-dag,图示非常棒

```bash
$ sudo apt-get install git-cola
```

##### typora

> 是一款markdown编写软件，推荐
>
> 官网:https://www.typora.io/
>
> linux安装过程：https://www.typora.io/#linux
>
> 安装软件源，然后安装软件
>
> 安装完之后设置，文件-》软件偏好，设置自动保存

##### xmind

> https://www.xmind.net/download/xmind8/

```bash
$ sudo apt-get install -y libcanberra-gtk-module
$ mkdir -p ~/local/mind8
$ unzip xmind_8xxx.zip  -d ~/local/mind8
$ cd ~/local/mind8
$ sudo sh ./setup.sh
$ cd XMind_amd64
$ ./XMind //启动

$ vi ~/bin/XMind.sh 
#!/bin/bash

cd ~/local/xmind8/XMind_amd64 && ./XMind &
```

##### docker

> 针对ubuntu有好几种安装方式，选择软件源安装方式
>
> https://docs.docker.com/install/linux/docker-ce/ubuntu/#install-docker-engine---community-1#install-docker-engine---community
>
> 可以使用deb进行安装
>
>  sudo dpkg -i containerd.io_1.2.6-3_amd64.deb
>  sudo dpkg -i docker-ce-cli_19.03.6~3-0~ubuntu-disco_amd64.deb
>   sudo dpkg -i docker-ce_19.03.6~3-0~ubuntu-disco_amd64.deb
>
> 安装完后把用户加入docker组中，然后重启

```bash
$ sudo usermod -aG docker your_username
```

##### blog项目

> git clone 到 workspace/caokelei目录下

##### zero_documents项目

> git clone 到workspace/caokelei目录下

```bash
$ sudo vim /etc/hosts
// 192.168.1.108 gitlab.localhost.com
$ git clone ssh://git@gitlab.localhost.com:8022/root/zero_documents.git
```

##### Golang

> 安装包可下载或者从移动硬盘同步而来
>
> 安装在local/go/go1.13下
>
> 下载地址：https://golang.google.cn/dl/

```bash
$ mkdir -p ~/local/gopath
$ vi .profile
export GOPATH=$HOME/local/gopath
export GOROOT=$HOME/local/go1.13
export GOBIN=$GOROOT/bin
export PATH=$GOBIN:$PATH
```

设置代理

> https://goproxy.cn/
>
> $ echo "export GO111MODULE=on" >> ~/.profile 
>
> $ echo "export GOPROXY=https://goproxy.cn" >> ~/.profile $ source ~/.profile

##### IntelliJ IDEA

> 下载toolbox
>
> https://www.jetbrains.com/zh-cn/toolbox-app/
>
> 随后安装golang 插件
>
> https://www.cnblogs.com/chenfool/p/8514000.html

##### Phpstorm

> 安装包可下载或者从移动硬盘同步而来
>
> 安装在local/目录下
>
> 安装命令bin/phpstorm.sh
>
> 配置模板zero_documents的settings目录下
>
> ctrl+shift+F键会被输入法的热键占用

##### Goland

> 安装包可下载或者从移动硬盘同步而来
>
> 安装在local/目录下
>
> 安装命令bin/goland.sh
>
> 配置模板zero_documents的settings目录下
>
> ctrl+shift+F键会被输入法的热键占用

##### Webstorm

安装

> 安装包可下载或者从移动硬盘同步而来
>
> tar -zxvf WebStorm-2019.3.3.tar.gz -C ~/local
> cd ~/local/WebStorm-193.6494.34/
>
> bin/webstorm.sh
>
> 可以使用Goland的setting

##### Clion

> 安装包可下载或者从移动硬盘同步而来
>
> tar -zxvf CLion-2019.3.5.tar.gz -C ~/local
>
> cd ~/local/clion-2019.3.5
>
> bin/clion.sh 

##### meld

> apt-get install meld



##### bcompare

> https://www.scootersoftware.com/download.php

#### 家目录下文件夹释义

> bin                   // 命令，或者命令软连接
>
> shells             // 软连接之乡zero_ducments下shells目录
>
> data               // 放置eth等数据文件
>
> Desktop        // 桌面
>
> Downloads // 软件下载
>
> gopath  
>
> local               // 软件安装
>
> workspace   // 工作目录
>
> ​         caokelei       //目录下防止 zero_documents和blog项目
>
> ​        znddzxx112//防止znddzxx112项目

#### 数据同步

##### .ssh与bin目录

> ~/bin = /home/znddzxx112/workspace/caokelei/zero_documents/znddzxx112/bin
>
> ~/.ssh = /home/znddzxx112/workspace/caokelei/zero_documents/znddzxx112/ssh

> .ssh/id*等文件权限要为644才可生效

##### shells目录

```bash
$ ln -s ~/workspace/caokelei/zero_documents/znddzxx112/shells ~/
```

