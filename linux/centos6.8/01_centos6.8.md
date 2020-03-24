[TOC]

#### centos6.8介绍与安装

> 选择6.8, 优先选择7，选择minimal, 体积小, 优先选择x86-64(64位)
> 因为64bit CPU 可以裝 i386/x86_64，32bit CPU 只能裝 i386，x86_64 是無法裝的

##### 下载

- 官网

```
最新版本网址：
https://wiki.centos.org/Download

历史版本网址:
http://vault.centos.org/

// 网易镜像(首选) 存储6的最新版本和7的最新版本
http://mirrors.163.com/
http://mirrors.163.com/centos/6.8/isos/i386/

// 电子科技大学
http://mirrors.stuhome.net/centos/

// 中国科技大学
http://centos.ustc.edu.cn/centos/
```

##### 使用虚拟机VMware10安装centos6.8

- 新建虚拟机选中iso文件
- 按照提示下一步，下一步...
- 网络选择桥接
- 安装过程配置ipv4

##### 必要配置

##### 关闭selinux

```
# vi /etc/sysconfig/selinux
修改 selinux = disabled
# init 6 // 重启生效
```

##### 配置ip地址

```
# cd /etc/sysconfig/network-scripts
# vi ifcfg-eth0

//固定IP地址配置方法-前提桥接
DEVICE=eth0
TYPE=Ethernet // 网络类
UUID=618685ae-cb4d-4660-b43e-b677517da559
ONBOOT=yes
NM_CONTROLLED=yes
BOOTPROTO=none
IPADDR=192.168.111.229
NETMASK=255.255.255.0 // 子网掩码 或者 PREFIX=24
GATEWAY=192.168.111.1
DNS1=192.168.111.1
DEFROUTE=yes
IPV4_FAILURE_FATAL=yes
IPV6INIT=no
NAME="System eth0"
HWADDR=00:0C:29:C3:F1:FC
ARPCHECK=no //不使用IPV6INIT

//DHCP 自动获取IP
DEVICE=eth0
HWADDR=00:0C:29:1B:F7:C5
ONBOOT=yes
BOOTPROTO=dhcp

// 配置DNS
# vi /etc/resolv.conf  
nameserver 192.168.1.253

// 重启网络服务
# service network restart
```

##### 禁用ICMP协议

```
# echo "1" > /proc/sys/net/ipv4/icmp_echo_ignore_all

# vi /proc/sys/net/ipv4/icmp_echo_ignore_all 
// 1 为禁用 0 为启用
```

##### 禁用ipv6加快速度

```
// 禁用
# echo "install ipv6 /bin/true" > /etc/modprobe.d/disable-ipv6.conf

// 重启生效
# init 6

// 启用
# vi /etc/modprobe.d/disable-ipv6.conf
install ipv6 /bin/true //禁用 删除此行

```

##### 设置默认界面

```
# vi /etc/inittab

#   0 - halt (Do NOT set initdefault to this)
#   1 - Single user mode
#   2 - Multiuser, without NFS (The same as 3, if you do not have networking)
#   3 - Full multiuser mode // 字符界面
#   4 - unused
#   5 - X11 // kde界面
#   6 - reboot (Do NOT set initdefault to this)
```

##### 解决中文乱码

```
# vi /etc/sysconfig/i18n 
LANG="zh_CN.UTF-8"

```

##### 版本历史

```
6.5 	i386, x86-64 	6.5 	2013-12-01[68] 	2013-11-21[69]

6.6 	i386, x86-64 	6.6 	2014-10-28[70] 	2014-10-14[71]

6.7 	i386, x86-64 	6.7 	2015-08-07[72] 	2015-07-22[73]

6.8 	i386, x86-64 	6.8 	2016-05-25[74] 	2016-05-09[75]

7-1406 	x86-64 	7.0 	2014-07-07[76] 	2014-06-10[77]

7-1511 	x86-64 	7.2 	2015-12-14[84] 	2015-11-19[85]
```

##### 网络资源

```
官方主页: http://www.centos.org/

邮件列表: http://www.centos.org/modules/tinycontent/index.php?id=16

论坛: http://www.centos.org/modules/newbb/

文档: http://www.centos.org/docs/

Wiki: http://wiki.centos.org/

镜像列表: http://www.centos.org/modules/tinycontent/index.php?id=32
```

##### i386,x86-64 区别

- i386是指intel發布的通用處理器類型，適合386，486，586，686的CPU
- x86_64是指intel的X86的64位處理器系統
- 64bit CPU 可以裝 i386/x86_64，32bit CPU 只能裝 i386，x86_64 是無法裝的
- 推荐做法 i386。

##### liveCD,binDVD,LiveDVD,minimal,netinstall

- BinDVD版——就是普通安装版，需安装到计算机硬盘才能用，bin一般都比较大，而且包含大量的常用软件，安装时无需再在线下载（大部分情况）。
- LiveDVD版——就是一个光盘CentOS系统，可通过光盘启动电脑，启动出CentOS系统，也有图形界面，也有终端。也可以安装到计算机，但是有些内容可能还需要再次到网站下载（自动）。
- LiveCD版——相比LiveDVD是个精简的光盘CentOS系统。体积更小，便于维护使用。(类似windows pe系统)
- minimal——还有个更Mini的CentOS系统版本。
- netinstall——网络安装版。
- 推荐做法 

##### 常见名词

- SRPMS——Source RPM

- DRPMS——Delta RPMS(升级包)

- RPM——Red Hat Package Manager

- repodata——软件仓库

#### 查询Linux内核和操作系统等基本信息

```
# uname -a
Linux centos64bit68 2.6.32-642.el6.i686 #1 SMP Tue May 10 16:13:51 UTC 2016 i686 i686 i386 GNU/Linux
# cat /etc/redhat-release
```

#### 查看发行版和位数

```
# cat /proc/version
```

#### 查看文件系统类型

```
# mount
```

#### 更换软件源

- 参考文章:http://mirrors.aliyun.com/help/centos

##### 更换成阿里源
```
0、安装 yum -y install wget
1、备份
# mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
2、下载新的CentOS-Base.repo到/etc/yum.repos.d/
# wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-6.repo 
3、运行 
# yum makecache // 生成缓存
```

##### 使用其他的epel（第三方软件仓库）
```
centos7安装各种软件推荐https://pkgs.org/进行查找
epel 以下三个软件量大而且软件新：CentOS SCLo RH(有新版本软件)、EPEL（往往没有新版本软件）、Les RPM de Remi

yum repolist 查看在用软件源

这种软件源保留着一个数据库保存着每个软件的依赖

启用这些软件源需要执行下 /opt/rh/devtoolset-6/enable
```

#### 系统服务自启动

##### 查看自启动服务

```
chkconfig --list network
chkconfig --list NetworkManager
```

##### 服务默认启动或关闭

```
chkconfig --list 服务名称
chkconfig --level 345 服务名称  on/off
chkconfig --add 服务名称
chkconfig --del 服务名称

eg:
chkconfig --list network
```

#### centos6.8服务器配置-开机启动脚本制作

##### 编写sh文件

```
# cd /etc/init.d/
# vi testbitcaoauto.sh 
#!/bin/sh

#add for chkconfig
#chkconfig: 2345 70 30
#description: the description of the shell
#processname: testbitcaoauto

status() {
        echo -n "hello"
        echo "wold"
}

echo "okok"

case "$1" in
    status)
        status
    ;;
esac

```

##### 设置开机启动

```
# chkconfig --add testbitcaoauto.sh
# chkconfig --level 345 testbitcaoauto.sh on
# chkconfig --list testbitcaoauto.sh 
# chmod +x testbitcaoauto.sh 
# service testbitcaoauto.sh status
```



#### 单用户模式解决网络原因无法启动

##### 进入单用户模式

```
# 启动centos,按下e，进入grud菜单界面
# 选中linux kernel,按下e
# 输入 空格 single 然后按下回车，再按esc
# 按下b，继续boot引导系统
```

##### 如果需要修改root密码

##### 在单用户模式下

```
# passwd root 即可
```

##### 虚拟机网卡的网卡设置新的mac地址

```
 Edit virtual machine settings-->Hardware-->Network Adapter-->Advanced..(右侧)-->Mac Address(为新的虚拟网卡的MAC)
 
```

##### 在单用户模式中完成以下操作

 ```
 1. 删除 /etc/udev/rules.d/70-persistent-net.rules

2. 删除 /etc/sysconfig/network-scripts/ifcfg-eth0 （做好备份）

3. 重新启动服务器，然后重建ifcfg-eth0（使用新的mac address）
 ```

##### 配置ip地址（重建ip地址）

 ```
  1 DEVICE=eth1
  2 TYPE=Ethernet
  3 ONBOOT=yes
  4 NM_CONTROLLED=yes
  5 BOOTPROTO=none
  6 IPADDR=192.168.0.119
  7 PREFIX=24
  8 GATEWAY=192.168.0.1
  9 DNS1=192.168.0.1
 10 DEFROUTE=yes
 11 IPV4_FAILURE_FATAL=yes
 12 IPV6INIT=no
 13 NAME="System eth0"
 14 HWADDR="00:50:56:34:D2:91"
 15 ARPCHECK=no

 # HWADDR 与 DEVICE = eth1相对应
 # 通过查看
 # vim /etc/udev/rules.d/70-persistent-net.rules

# service network restart
 ```

##### 如果因为rc.local造成重启不了

```
#在单用户模式下直接修改/etc/rc.d/rc.local即可
```



#### devtoolset-2安装

> centos6.8默认的仓库里的软件版本太老
> devtoolset针对开发者版本更高，比如c++11的支持
> devtoolset-2 devtoolset-3 devtoolset-4
- 参考文章：http://blog.csdn.net/qq_14821541/article/details/52297859
```
touch /etc/yum.repos.d/devtools-2.repo
[devtools2]
name=testing 2 devtools for CentOS $releasever 
baseurl=http://people.centos.org/tru/devtools-2/$releasever/$basearch/RPMS
enabled=1
gpgcheck=0

[devtoolset2]
name=RedHat DevToolset v2 $releasever - $basearch
baseurl=http://puias.princeton.edu/data/puias/DevToolset/$releasever/$basearch/
enabled=1
gpgcheck=0
```

```
yum check-update
yum install devtoolset-2-gcc  devtoolset-2-gcc-c++
```

##### 使用devtoolset-2环境变量

```
source /opt/rh/devtoolset-2/enable 
或者放到.bashrc/.zshrc中
echo 'source /opt/rh/devtoolset-2/enable' >> ~/.bash_profile
```

```
// 我用到devtoolset-2就ok了
devtoolset-3和devtoolset-4的安装要更简单了，执行命令
yum install centos-release-scl-rh centos-release-scl
yum check-update
yum install devtoolset-3-gcc  devtoolset-3-gcc-c++
yum install devtoolset-3-gcc  devtoolset-3-gcc-c++
安装起来自己所需要的devtoolset后，接下来就需要启用了
source /opt/rh/devtoolset-2/enable
source /opt/rh/devtoolset-3/enable
source /opt/rh/devtoolset-4/enable
```
