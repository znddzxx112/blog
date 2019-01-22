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

- 使用devtoolset-2环境变量
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
