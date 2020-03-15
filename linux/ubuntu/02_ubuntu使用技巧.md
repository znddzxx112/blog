[TOC]

#### 使用字符界面启动

修改vi /etc/default/grub

> 修改GRUB_CMDLINE_LINUX_DEFAULT=”quiet splash”
>
> 为：GRUB_CMDLINE_LINUX_DEFAULT=” text”

然后运行下sudo update-grub2就可了，重新启动

#### deb包安装，查找，删除

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

