[TOC]



#### 分区格式化

##### 查看文件系统

```bash
# df -lh
```

##### 分区

```bash
# fdisk /dev/sda4

d // 删除
p // 打印
n // 新建分区,1,回车
w // 保存退出
```

##### 格式化

```bash
# mkfs.etx4 /dev/sda4
```

##### 挂载

```bash
# mount -t ext4 /dev/sda4 /data1
```

##### 开机自动挂载

```bash
vi /etc/fstab

/dev/sda4 /data4 ext4 defaults 0 0
```

#### 安裝x system桌面

前提最好换成阿里云源，下载的时候速度会快一些

```
# yum groupinstall "X Window System"
# yum groupinstall "Server with GUI"
```

#### 安装SS

> 参考网址：https://www.cnblogs.com/cheyunhua/p/8683956.html

##### 整个流程

> 依次安装sslocal命令，privoxy命令
> sslocal 是ss的客户端，负责和server通信
> privoxy 是将http,https 代理给sslocal
> 开启浏览器代理将请求转发至privoxy的1080端口

##### 安装sslocal

```bash
# wget --no-check-certificate https://github.com/pypa/pip/archive/1.5.5.tar.gz
# tar zvxf 1.5.5.tar.gz
# python setup.py install
# pip install shadowsocks
```

##### sslocal.json

```bash
# vim /etc/sslocal.json
{
"server": "147.174.190.138",
"server_port": 8388,
"local_address": "127.0.0.1",
"local_port": 1080,
"password": "AS3e123jK",
"timeout": 300,
"method": "aes-256-cfb"
}
```

##### 运行sslocal

```bash
# useradd privoxy // 不使用root
sourceforge 获得privoxy源码
# ./configure && make && make install
查看vim /usr/local/etc/privoxy/config文件，先搜索关键字:listen-address找到listen-address 127.0.0.1:8118这一句，保证这一句没有注释，8118就是将来http代理要输入的端口。
然后搜索forward-socks5t,将forward-socks5t / 127.0.0.1:1080 。此句的注释去掉（注意后面的点不要删了！）.
# privoxy --user privoxy /usr/local/etc/privoxy/config
```

##### privoxy代理http和https

```bash
# useradd privoxy // 不使用root
sourceforge 获得privoxy源码
# ./configure && make && make install
查看vim /usr/local/etc/privoxy/config文件，先搜索关键字:listen-address找到listen-address 127.0.0.1:8118这一句，保证这一句没有注释，8118就是将来http代理要输入的端口。
然后搜索forward-socks5t,将forward-socks5t / 127.0.0.1:1080 。此句的注释去掉（注意后面的点不要删了！）.
# privoxy --user privoxy /usr/local/etc/privoxy/config
```

##### shell代理

> 为了命令行也能使用ss

```bash
# vim /etc/profile
export http_proxy=http://127.0.0.1:8118
export https_proxy=http://127.0.0.1:8118
export ftp_proxy=http://127.0.0.1:8118
```

#### 一个网卡配置虚拟ip

> 参考文章：https://blog.csdn.net/turkeyzhou/article/details/16971225

```bash
# ifconfig enp5s0f0:215 down // 下掉虚拟ip
# ifconfig enp5s0f0:215 192.168.20.215 //配置虚拟ip
```

##### ifcfg-eth0字段解析

> https://blog.csdn.net/jmyue/article/details/17288467

##### 样例

> DEVICE="eth0"
>  BOOTPROTO="static"
>  MTU=1500
>  ONBOOT=yes
>  IPADDR=
>  NETMASK=255.255.255.0
>  GATEWAY=XX.XX.XX.254

##### 参数说明

> 1 DEVICE=eth1
>  2 TYPE=Ethernet
>  3 ONBOOT=yes
>  4 NM_CONTROLLED=yes
>  5 BOOTPROTO=none
>  6 IPADDR=192.168.0.119
>  7 PREFIX=24
>  8 GATEWAY=192.168.0.1
>  9 DNS1=192.168.0.1
> 10 DEFROUTE=yes
> 11 IPV4_FAILURE_FATAL=yes
> 12 IPV6INIT=no
> 13 NAME="System eth0"
> 14 HWADDR="00:50:56:34:D2:91"
> 15 ARPCHECK=no
>
> HWADDR 与 DEVICE = eth1相对应
>
> 通过查看 cat /sys/class/net/eth0/address

#### ip路由，单播，多播，广播

> tcp 是点对点，采用单播
> udp 采用多播和广播 broadcast
> 从网卡中可以看出来
>
> 分成动态路由（通过守护进程同步信息实现）和静态路由
> ip层根据ip路由表进行数据包转发，每发现一条路由，数据包被转送下一级路由器，称为一次“跳步”。维护者路由表的机器叫路由器，连接2个网络
>
> 1、为某主机添加路由
> 　　$ sudo route add –host 192.168.10.58 dev eth1
> 　　//所有通向192.168.10.58的数据都是用eth1网卡
> 　　$ sudo route add –host 192.168.11.58 gw 192.168.10.1
> 　　//通向192.168.11.58的数据使用网关192.168.10.1
> 2、为某网络的添加路由
> 　　$ sudo route add –net 220.181.8.0/24 dev eth0
> 　　$ sudo route add –net 220.181.8.0/24 gw 192.168.10.1
> 　　3、添加默认网关
> 　　$ sudo route add default gw 192.168.10.1
> 　　4、删除路由，
> 　　$ sudo route del –host 192.168.168.110 dev eth0
> 　　可能你会遇到删除时候语法错误，请参看路由表的Flags,路由上面的第一条，G表示设定了网关，H表示操作了主机，所以就用$ sudo route del -host 192.168.10.58 gw 192.168.10.1删除，更详细的请man。
> 　　使用route 命令添加的路由，机器重启或者网卡重启后路由就失效了，和iptables一样，需要永久添加的话，也是使用开机执行，所以可以用以下方法添加永久路由：
> 　　1.在/etc/rc.local里添加执行命令，进行开机执行，因为是root权限，所以不用sudo了：
> 　　route add –net 220.181.8.0/24 dev eth0
> 　　route add –net 220.181.9.0/24 gw 192.168.10.1
> 　　2.在/etc/sysconfig/network里添加到末尾
> 　　方法：GATEWAY=gw-ip 或者 GATEWAY=gw-dev
> 　　3./etc/sysconfig/static-router :
> 　　any net x.x.x.x/24 gw y.y.y.y

#### 设置主机hostname不需要重启机器方法

```bash
# hostnamectl set-hostname 112
```

#### 多台笔记本共用一套鼠标和键盘

使用synergy1.8.8版本

##### ubuntu1804安装

```bash
$ sudo apt install synergy
```

##### windows7下载

```bash
下载地址：http://www.veryhuo.com/down/html/54291.html
```

##### centos7安装

```
安装说明：https://centos.pkgs.org/7/epel-x86_64/synergy-1.8.8-3.el7.x86_64.rpm.html
```

##### centos7开启端口

```bash
firewall-cmd --zone=public --add-port=24800/tcp --permanent
firewall-cmd --reload
firewall-cmd --list-all
```

最后windows7和centos7各自开启synergy软件,作为服务端需要设置打开端口，设置屏幕名称

