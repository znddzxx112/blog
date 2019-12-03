- 更换软件源

- 参考文章:http://mirrors.aliyun.com/help/centos

### 更换成阿里源
```
0、安装 yum -y install wget
1、备份
# mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
2、下载新的CentOS-Base.repo到/etc/yum.repos.d/
# wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-6.repo 
3、运行 
# yum makecache // 生成缓存
```

### 使用其他的epel（第三方软件仓库）
```
centos7安装各种软件推荐https://pkgs.org/进行查找
epel 以下三个软件量大而且软件新：CentOS SCLo RH(有新版本软件)、EPEL（往往没有新版本软件）、Les RPM de Remi

yum repolist 查看在用软件源

这种软件源保留着一个数据库保存着每个软件的依赖
```

