[TOC]

##### virtual box下载

> https://www.virtualbox.org/wiki/Downloads

##### 下载ubuntu1804.ios

> 可以使用国内源

##### 创建虚拟机

> 双击文件：D:\local\virtualbox\drivers\vboxdrv\VBoxDrx.inf（我的目录D:\local\virtualbox\）
>
> 然后重启计算机

- 新建virtualbox虚拟机命名ubuntu1804-phpprod
- 选择存储-》选择ios文件
- 选择系统-》选择光驱引导顺序
- 启动虚拟机

![v1](C:\Users\86188\workspace\znddzxx112\blog\virtualbox\v1.jpg)

##### 安装ssh

```bash
$ sudo apt-get install openssh-server
$ sudo vi /etc/ssh/sshd.config
// 开通Port和允许公钥登录
Port 22
PubkeyAuthentication yes
AuthorizedKeysFile .ssh/authorized_keys .ssh/authorized_keys2
$ sudo service ssh restart
// 将准备用ssh登录的公钥写入到authorized_keys中
$ vi .ssh/authorized_keys
$ chmod 640 .ssh/authorized_keys
```

##### 设置网络规则

本机2222-》22

![v2](.\v2.jpg)

网卡2设置

![v3](.\v3.jpg)

##### 通过xshell登录虚拟机

![v4](C:\Users\86188\workspace\znddzxx112\blog\virtualbox\v4.jpg)



![v5](C:\Users\86188\workspace\znddzxx112\blog\virtualbox\v5.jpg)



##### 安装增强工具

1. 菜单中的 设备 > 安装增强功能
2. 在虚拟机中 cd / && mkdir cdrom && mount /dev/cdrom /cdrom
3. cd /cdrom && ./VBoxLinuxAdditions.run
4. 安装完成关闭虚拟机

##### 生成基础box

> 在任意文件夹打开git-bash执行
>
> vagrant.exe package --base ubuntu1804 --output ubntu1804.box
>
> ubuntu1804 为虚拟机名称