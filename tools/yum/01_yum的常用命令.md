##### centos6.8yum的常用命令

#### 参考文章：http://www.jianshu.com/p/d3af022bc89b

```
linux系统中的诸多程序都是由源代码编译或者由二次发行商选择性编译分布，
其大部分的程序安装得了需要依赖于三方的库文件，甚至很多的程序依赖关系会进入到死循环的情况中。
由于直接使用源代码编译安装比较繁，故出现了一系列的安装包管理程序。
```

- 软件包后缀rpm
- 前端管理工具yum
- 软件包后缀deb
- 前端管理工具apt-get


- rpm包的安装
```
rpm -i xx.rpm
```

- rpm升级
```
rpm -U xx.rpm
```

- rpm包卸载
```
rpm -e xx.rpm
```

- rpm包查询
```
rpm -qa xx.rpm
```

- yum的工作机制

```
其更像C/S架构模式，提供yum源的一方类似服务端，使用yum工具的一方类似客户端。
客户端每次下载远程服务器软件包的一个元数据表，存放至本地进行缓存 ，在要安装程序时，查询缓存，如果存在， 就向远程服务器请求软件安装，如果有依赖关系，YUM服务器会检查其软件安装情况并
记录本地，把有依赖并没有安装的软件提示用户安装。下载的元数据缓存至本地时，服
务器会对元数据进行特征算法，与自己本地进行对比，如果变动了， 就要下载新的元数据
```

- yum的安装及卸载
```
安装
rpm -i yum-version.rpm
卸载
rpm -e yum
```

- yum安装
```
yum install -y xx
```

- yum升级
```
yum update
```

- yum卸载
```
yum erase softname
```

- yum显示
```
list {all|available|updates|installed}
list php*
info package
```

- yum清理缓存
```
yum clean [ package ] | metadata | expire-cache| rpmdb | plugins | all ]
```

- yum生成缓存
```
yum makeclean
```

- yum搜索
```
yum search package
```

- 显示依赖关系
```
yum deplist package
```

```
可以直接去 rpm 仓库网站下载，但比较麻烦。使用yum的一个插件：yum-downloadonly 更简单
1. 安装yum-downloadonly
sudo yum -y install yum-utils
2. yumdownloader httpd 软件名字
```
