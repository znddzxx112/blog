#### centos介绍与安装

##### 版本历史

```
6.5 	i386, x86-64 	6.5 	2013-12-01[68] 	2013-11-21[69]

6.6 	i386, x86-64 	6.6 	2014-10-28[70] 	2014-10-14[71]

6.7 	i386, x86-64 	6.7 	2015-08-07[72] 	2015-07-22[73]

6.8 	i386, x86-64 	6.8 	2016-05-25[74] 	2016-05-09[75]

7-1406 	x86-64 	7.0 	2014-07-07[76] 	2014-06-10[77]

7-1511 	x86-64 	7.2 	2015-12-14[84] 	2015-11-19[85]
```

> 我目前选择 6.8-minimal

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
- 推荐做法 下载minimal(速度最快)

##### 下载

- 官网

```
最新版本网址：
https://wiki.centos.org/Download

历史版本网址:
http://vault.centos.org/
```

- 国内

```
// 网易镜像(首选) 存储6的最新版本和7的最新版本
http://mirrors.163.com/

// 电子科技大学
http://mirrors.stuhome.net/centos/

// 中国科技大学
http://centos.ustc.edu.cn/centos/
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

##### 常见名词

- SRPMS——Source RPM

- DRPMS——Delta RPMS(升级包)

- RPM——Red Hat Package Manager

- repodata——软件仓库


##### VMware10安装

- 新建虚拟机选中iso文件
- 按照提示下一步，下一步...
- **网络选择桥接**
- 安装过程配置ipv4

##### 必要配置

- 关闭selinux

```
su
vi /etc/sysconfig/selinux
selinux = disabled
init 6 // 重启生效
```

- 配置ip地址

```
# cd /etc/sysconfig/network-scripts
# vi ifcfg-eth0

//固定IP地址配置方法-前提桥接
DEVICE=eth0
HWADDR=
TYPE=Ethernet   // 网络类型
UUID=
ONBOOT=yes
NM_CONTROLLED=yes
BOOTPROTO=none
IPADDR=192.168.1.119
NETMASK=255.255.255.0 // 子网掩码
GATEWAY=192.168.1.253 //网关
IPV6INIT=no     //不使用IPV6INIT
ARPCHECK=no

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

- 禁用ICMP协议

```
# echo "1" > /proc/sys/net/ipv4/icmp_echo_ignore_all

# vi /proc/sys/net/ipv4/icmp_echo_ignore_all 
// 1 为禁用 0 为启用
```

- 禁用ipv6加快速度

```
// 禁用
# echo "install ipv6 /bin/true" > /etc/modprobe.d/disable-ipv6.conf

// 重启生效

// 启用
# vi /etc/modprobe.d/disable-ipv6.conf
install ipv6 /bin/true //删除此行

```

- 安装choose a tool（对初级使用者方便）

```
# yum install setuptool ntsysv system-config-firewall-tuisystem-config-network-tui

# setup // 进入 choose a tool
```

- 查询Linux内核与发行版信息

```
# uname -a
Linux centos64bit68 2.6.32-642.el6.i686 #1 SMP Tue May 10 16:13:51 UTC 2016 i686 i686 i386 GNU/Linux
```

- 操作系统版本

```
# cat /etc/redhat-release
```

- 查看发行版

```
# cat /proc/version
```

- 查看bit

```
cat /proc/version
```

- 查看文件系统类型
```
# mount
```

- 查看自启动服务

```
chkconfig --list network
chkconfig --list NetworkManager
```

- 服务默认启动或关闭

```
chkconfig --list 服务名称
chkconfig --level 345 服务名称  on/off
chkconfig --add 服务名称
chkconfig --del 服务名称

eg:
chkconfig --list network
```

- 设置默认界面
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

- 解决中文乱码

```
# vi /etc/sysconfig/i18n 
LANG="zh_CN.UTF-8"

```

- 更换源 - 阿里源

- 参考文章:http://mirrors.aliyun.com/help/centos

```
0、安装 yum -y install wget
1、备份
# mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
2、下载新的CentOS-Base.repo到/etc/yum.repos.d/
# wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-6.repo 
3、之后运行yum 
# makecache生成缓存
```

