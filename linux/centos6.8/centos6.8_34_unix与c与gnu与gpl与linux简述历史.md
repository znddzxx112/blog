- 操作系统运行在某一个架构的机器上，早起不同公司会生产不同架构的计算机
- 肯.汤普森和里奇 在贝尔实验室 创造了unix，unix主要运行在x86架构，i386,...（苹果机器有自己的mac系统，window不能装在苹果机器上）
- 先有unix再有c语言，早起unix通过B语言编写，目前unix通过c语言和汇编语言编写
- 二人又创造了c语言
- unix有版权限制，copy right
- 早期有许多人通过简单修改unix，将它运行在其他架构机器上，软件移植成了问题
- 史托曼发起自由软件计划 - GNU计划，发布GPL版权协议
```
但不能将GPL软件直接售卖，二次改造的软件继续秉承GPL版权协议
```
- 史托曼为C语言写了GCC，GNU C COMPLIEc的编译器 GDBC的调试器
- 托瓦兹不借鉴unix写了linux内核，类unix的操作系统，跑在x86架构的机器上，尊徐GNU下的操作系统，所以GNU/liunux
- 托瓦兹使用C语言，GCC编译出了LINUX内核
- 更多的人开始在linux上写程序并分享出来，linux在内核为基础上，有一个个好用的工具，逐步庞大
- linux确实是linux is not unix
- linux上的软件，逐步通过 ./configure,make,make install,make clean的安装方式


- linux Distributions(linux 发行版)
- 分为二大系统,按照安装软件的区别
```
rpm方式 red hat，fedora，centos
dpkg方法 debian，ubuntu
（安装软件还可以通过源码安装，毕竟linux kernel就是这样安装起来的）
```

```
linux distrubutions = linux kernel+ software + tools
```
```
linux kernel:www.kernel.org
centos:www.centos.org
ubuntu:www.ubuntu.com
```
```
linux 是一个多任务，多用户的操作系统（运行在x86架构的硬件系统）
实现的标准是美国IEEE电气电子工业学会提出的标准，关于可携式操作系统接口POSIX
http://www.ieee.org/index.html
```
- linux主要的二个标准LSB，FHS


- linux的开机流程
```
1. BIOS 根据记录的启动顺序去找介质
2. CPU读取主引导分区Master Boot Record中的加载程序
3. 加载程序Boot Loader读取具体分区扇区
4. 扇区的内核程序开始启动
```
