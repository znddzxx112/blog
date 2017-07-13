> windows下进行c/c++编程

- 安装clion
```
下载地址：http://www.jetbrains.com/clion/
只有x86_64,32位系统安装不了
```

- 安装cygwin
```
官网下载：https://cygwin.com/
```

- cygwin安装make,gcc-core,gcc-c++,gdb
```
下一步->install from Internet -> 设置下载安装路径 -> direct connection ->
选择下载源（可以选mirrors.ustc.edu.com[东北大学镜像站]，
或者添加网易镜像站：http://mirrors.163.com/cygwin/ [参考http://mirrors.163.com/.help/cygwin.html]） 
选择Devel模块，搜索make,gcc-core,gcc-c++,gdb
```

- clion配置cygwin
```
Setting->Toolchains 配置 cygwin home 地址
```

- 建cpp的项目位置
```
cygwininstllDir/home/bitcao/
```

- 开发流程
> 方式1：直接使用clion shift+F9

> 方式2

```
clion 仅仅编写
在cygwin中g++编译 或者 放到真实虚拟机中编译执行
g++ -std=c++11 -o main main.cpp
g++ -std=c++11 -o modeule module
```
