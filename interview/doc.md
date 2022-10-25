

[TOC]



### 自我介绍

```
1. 项目介绍，承担什么角色
2. 业务线上负责什么，技术线上负责什么
```



### 汇编语言&计算机组成

#### 什么是机器语言？

> 机器指令的集合，机器可以直接执行的命令

#### 什么是汇编语言？

> 机器指令便于记忆的书写格式

#### 机器如何读懂汇编指令?

> 汇编指令通过编译器转化成为机器码

#### 什么是寄存器？

> cpu中存储数据的器件。总共由14个寄存器。寄存器是32位，则是32位。
>
> AX、BX、CX、DX是通用寄存器，存放数据
>
> CS、IP是段寄存器。CS指明代码段地址，IP指明代码段偏移地址。CS、IP指向的内存地址数据会按照机器指令进行解析
>
> DS、ES是段寄存器。DS指明数据段地址，ES指明数据段的偏移地址。
>
> SS、SP是段寄存器。SS指明栈顶段地址，SP指明偏移地址。SS:SP指明栈顶元素
>
> si di和bx功能相近的寄存器 [bx], [si], [di]
>
> 标志寄存器PSW
>
> ​		ZF标志：判断执行结果是否为0
>
> ​		PF标志：奇偶标志
>
> ​		SF标志：相关指令执行后，结果是否为负。负数则为1，代表有符号数进行运算
>
> ​		CF标志：无符号数运算，记录最高位进位
>
> ​        OF标志：溢出标志位  页码：218
>
> ​        DF标志：控制si,di的递增和递减

##### 问题：标志寄存器PSW能做哪些事情？





##### 问题：栈的作用？

> 用桟暂存以后需要恢复的寄存器中的内容。出桟的顺序要和入栈的顺序相反





#### 汇编指令

> 传输指令
>
> ​	push 、 pop：实质是内存的传送指令，寄存器与内存之间传送数据
>
> pushf、popf: 标志寄存器传入栈中
>
> in、out 读写端口指令
>
> 转移指令
>
> ​	jmp 同时修改CS，IP的值。
>
> jmp short 标号：段内-128-127 ip的修改范围
>
> jmp far ptr 标号：远转移
>
> jcxz: 如果 cx寄存器为0 ，则跳转
>
> ret:把IP寄存器从到栈中取出
>
> retf:把IP和CS从寄存器中取出
>
> call: 把IP和cs寄存器中的值放入栈中
>
> je,jne  结合cmp结果，进行转移
>
> loop 执行cx寄存器自减，cx不为0 跳转到loop指定的标号
>
> 运算指令
>
> ​	add, sub
>
> ​    div，mul
>
> adc：带进位加法指令
>
> sbb:带借位的减法
>
> cmp：比较指令，相当于做减法，结果保存在状态PSW标志器中



#### 计算机中的存储单元？

> 8个位 = 1个字节

#### cpu对存储器的读写过程？

> cpu通过数据线，地址线，控制线。
>
> 控制线：控制读或者写
>
> 地址线：8位寄存器通过地址加法器可以生成20位的地址，控制4GB的内存空间。分成段地址+偏移地址。物理地址=段地址*16+偏移地址
>
> 数据线：一次读写从内存读入数据
>
> 读取过程：cpu通过总线从地址线指明的地址读取数据到寄存器
>
> 写过程：cpu通过总线将寄存器数据写到地址上
>
> 主板，接口卡都可以当作内存对待

cpu可以直接读写的3个地方的数据

> 1、内部寄存器
>
> 2、内存单元
>
> 3、端口

#### 编程本质

> 程序员通过改变寄存器的内容实现对cpu的控制
>
> 程序大部分是进行数据处理，处理数据之前要搞清楚数据放在哪里
>
> 数据可以放在cpu内部，内存，端口

#### 程序写出到执行过程

> 第1步：编写程序代码
>
> 第2步：代码进行编译链接。编译是将代码生成目标文件，再用连接程序ar对目标文件进行链接，产生可执行文件
>
> 可执行文件包含1. 目标文件，即机器码
>
> 2. 描述信息。程序大小和需要占用的内存空间
>
> 第3步：操作系统将程序调入内存
>
> 其中可执行文件中是有代码段，数据段和栈组成的

#### 连接的作用？

> 如果程序中调用了某一个库文件的子程序，就需要在连接的时候，将库文件和目标文件连接到一起，生成可执行文件。
>
> 同时加上描述信息。

#### 问题：谁将可执行文件载入内存并使它运行？

> 一个正在运行的程序（操作系统）将它载入内存，并将CPU控制权交给它（CS：IP指定），运行完之后，将控制权交还给操作系统

#### 问题：如何函数调用中参数和结果传递问题？

> 调用者将参数放入栈中，Call 子程序，子程序从栈获取参数，将执行结果也放入栈中，执行ret返回调用者



### 中断

#### 问题：什么是中断？

> 任何一个通用CPU，可以在执行完当前正在执行指令之后，检测从CPU外部或者内部的特殊信息，并对这种特殊信息做处理。这种特殊信息为中断信息。
>
> 本质：cpu不再继续执行指令，转而去处理这个特殊信息

#### 问题：内中断有哪几种？

> 除法错误
>
> 单步执行-  程序调试
>
> 执行info指令
>
> 执行int指令 - 汇编中手动触发中断

#### 问题：中断过程是怎么样的？

> CPU执行一步指令之后， 收到中断信息、其中包含中断类型码。开始处理中断信息，通过中断类型码在中断向量表找到中断处理程序入口CS和IP值，开始执行中断处理程序，执行完后iret指令，返回到CPU依照原先继续执行
>
> 准备处理中断，会将当前寄存器的值放入栈中
>
> 中断处理程序 就是一个子程序，用来响应中断信息

#### 问题：单步执行中断过程是怎么样的？

> CPU执行指令之后，检查状态寄存器ZF标志位，值为1，则执行1号中断处理程序（等待用户输入调试指令）

#### 问题：如何产生外中断？

> 通过int指令引发中断
>
> int 0 : 引发0号中断
>
> 相关芯片向CPU发送中断信息
>
> 外设输入到达，会产生9号中断，cpu检测IF标志位，不为0，则响应中断，将输入放置缓存区中

#### 问题：cpu如何不响应外中断？

> 将标志寄存器IF位为0

#### 问题：BIOS和操作系统中断程序的安装过程

> 1、开机后，CPU加电，从ffffH：0内存单元开始处理，这里是跳转指令。跳到BIOS硬件系统检测和初始化程序
>
> 2、BIOS初始化程序会将BIOS中断程序登记到中断向量表
>
> 3、随后执行int 19h中断，进入操作系统引导。控制权交给操作系统。
>
> 4、操作系统也会将自身中断程序登记到中断向量表
>
> 系统中断程序 = 系统调用程序 = 用汇编程序书写程序才可直接使用、c，go语言有一一对应的库函数实现
>
> 调用系统调用时，已经进入操作系统的系统态

#### 问题：磁盘读写的过程是怎么样？

> 软盘分上下二面、每面有80个磁道，每个磁道有18个扇区，每个扇区512个字节
>
> 则 软盘大小为2面 *  80磁道  *  18个扇区 * 512字节 等于 1.44MB左右
>
> 首先：要确定从读取位置
>
> 驱动器号 0：软驱A 1：软驱B 80H：硬盘C 81H硬盘D
>
> 磁头号：哪个面
>
> 扇区号、磁道号、读取扇区数
>
> 内存单元
>
> 读写标志
>
> 将以上数据通过调用int 13h中断程序告诉磁盘控制器，磁盘控制器将数据读取或者写入内存单元

#### 问题：逻辑扇区号是什么？

> 将上述物理扇区进行编号
>
> 逻辑扇区号 = （面号*80 + 磁道号* ） *  18 + 扇区号 - 1
>
> 面号 = int (逻辑扇区号 / 1440)
>
> 磁道号= int( rem(逻辑扇区号 / 1440) / 18)
>
> 扇区号 = rem( rem(逻辑扇区号 / 1440) / 18) + 1 
>
> 逻辑扇区号 + 内存单元 + 读写标志，再调用int 13h 中断程序，磁盘控制器将数据读取或者写入内存单元



### 计算机操作系统

#### 问题：操作系统的作用？

> 1、作为用户与计算机硬件系统之间的接口
>
> ​		命令行，系统调用（系统中断程序）- golang的标准库会去调用
>
> 2、作为计算机系统资源的管理者
>
> ​		处理机器管理
>
> ​					进程控制、进程同步（多个进程运行进行协调）、进程通信、
>
> ​					调度（作业调度、进程调度）
>
> ​		存储器管理（内存分配与回收）
>
> ​					内存分配：运行时程序，内存动态增长
>
> ​					内存保护：硬件实现防止越界、软件配合
>
> ​					地址映射
>
> ​					内存扩充：请求调入、置换功能
>
> ​		IO设备管理
>
> ​					缓存管理
>
> ​					文件管理、目录管理
>
> ​		信息（数据和程序）
>
> ​       共享资源的使用，避免冲突
>
> 3、实现对计算机资源的抽象

#### 问题：操作系统的基本特性？

> 1、 并行与并发
>
>    并行： 同一个时刻多个事件同一时刻发生
>
> ​    并发：在一段时间内发生，先后顺序不确定
>
> 2、引入进程、线程。资源分配单位，cpu调度单位
>
> 3、 资源共享
>
> 4、虚拟技术
>
> 5、异步性

#### 问题：什么是操作系统微内核？

> 1、足够小、提供核心功能
>
> 2、基于客户/服务器模式
>
> 3、机制与策略分离
>
> 4、采用面向对象技术：抽象、隐蔽。封装和继承。正确性、可靠性、易修改、易扩展

### 进程管理

#### 问题：作业调度流程是怎么样的？

> 从磁盘中程序调入至内存中，分配PCB(管理信息)，此时进程处于就绪状态
>
> 进程是程序的一次执行

#### 问题：进程有哪几个部分组成？

> PCB 进程控制块、代码段、数据段、栈
>
> PCB：管理信息、进程标识、处理机状态（寄存器信息）、现行运行状态、优先级、程序段和数据段开始地方、所需资源清单

#### 问题：进程有哪些状态？每种状态产生原因？

> 就绪  -  静止就绪
>
> 执行
>
> 阻塞 - 静止阻塞
>
> 就绪状态：分配PCB，但未分配主存信息

#### 问题：进程调度流程是在怎么样的？

> 挂起、激活
>
> 阻塞、唤醒
>
> 以上4个原子操作，让进程在几个状态之间切换

#### 问题：进程同步有那几种情况？过程是怎样的？

> 同步：让并发的进程协调起来
>
> 1、对于临界资源访问，使用互斥量 - 锁方式
>
> 2、一般性的进程同步，使用信号量。golang中使用wait，done实现协程同步

#### 问题：生产-消费者问题 - 同步问题是怎么样的？解决方案是什么？

> golang:
>
> 如何避免重复关闭管道？从已关闭的管道中写数据？
>
> sync.Once
>
> 如何停止从一个管道中读取数据？

#### 问题：哲学家进餐问题  是怎么样的？解决方案是什么

#### 问题：读者-写者问题是怎么样的？解决方案是什么？

> 读写锁

#### 问题：进程通信有哪几种方式？



#### 问题：线程是怎么样的？

> 需要内核支持线程。cpu的时间片轮转线程。一个进程至少一个线程。
>
> 线程有线程控制块，记录寄存器信息
>
> golang用户级线程，能获得更多的cpu执行时间。

#### 问题：作业调度调度算法有哪些？

> 程序首先增加作业控制块，通过调度算法，从外存调入内存
>
> 作业调度算法：
>
> 先来先服务算法、短作业优先、作业优先级、响应比高者优先算法

#### 问题：进程调度方式有哪些？

> 非抢占式：线程分配给它，不管它运行多长时间、都让他一直运行下去
>
> ​		除非 1、执行完毕 2、发生IO请求 3、进程通信或同步执行某种原语
>
> ​		golang协程属于这种凡是
>
> 抢占式：基于某种原则来执行，更加公平。
>
> ​       比如：优先权、短作业、时间片

#### 问题：调度实现方式？调度模型是怎么样？使用什么样的数据结构？

#### 问题：产生死锁的原因？产生死锁的必要条件？

> 1、竞争资源
>
> 2、进程间推进顺序非法。请求和释放资源顺序不当。
>
> 必要条件：
>
> 1、互斥条件
>
> 2、请求和保持条件
>
> 3、不剥夺条件
>
> 4、环路等待条件

#### 问题：如何避免死锁？

> 使用银行家算法避免

#### 问题：如何检测死锁？

> 系统要记录资源请求和分配信息-资源分配图
>
> 提供算法检测死锁
>

#### 问题：如何解除死锁？

> 方法1、剥夺资源。从其他进程剥脱足够资源给死锁进程，解除死锁
>
> 方法2、撤销进程。

#### 问题：程序变成进程的过程？

> 程序通过编译，链接link，汇编
>
> 编译：是将本代码编译成汇编代码
>
> 链接：本代码使用了共享的代码段，根据是否链接进来，分为静态链接和动态链接
>
> 汇编：把汇编代码转化为二进制代码

#### 问题：程序装入过程？

> 采用动态运行装入方式
>
> 程序中包含逻辑地址，成为进程时，在1GB内核空间中分配pcb(task结构体)和页表，每次涉及地址操作时，会通过页表找到真正的物理地址。
>
> 程序的代码段是在低地址，BSS段（未初始化全局变量、static），堆段，栈段。这些放在3G的用户空间
>
> PCB和页表放在内核空间，高地址1GB中。内核空间也叫低端内存，用户空间叫高端内存。

#### 问题：什么是快表？

> cpu通过mmu内存管理单元将逻辑地址转化为物理地址
>
> 转化使用了内核空间的页表，页表还是内存中，内存读取速度是比较慢的。
>
> 快表将页表信息存储于高速缓存中

#### 问题：什么是缺页中断？什么是页面置换？页面置换算法有哪些？

> 开始运行时，不会把所有的程序中页都载入内存，只有用到时发现内存没有，发生缺页中断，从外存中取到内存
>
> 内存比较满了，把内存页放到swap分区中就是页面置换过程。
>
> 先进先出、最久未使用置换算法

#### 问题：如何访问硬盘数据的过程是怎么样的？

> 会设立缓冲区
>
> 如果是写入硬盘，cpu先把内存数据放到缓存区内存中，命令DMA从缓冲区数据写入硬盘
>
> 如果是从硬盘读取，DMA先将数据写入缓冲区，cpu再从缓冲区获取数据。

#### 问题：硬盘分区的作用？

> 每个分区变成了独立的逻辑磁盘，从0开始
>
> 每个分区起始扇区和大小都记录在磁盘0扇区的主引导记录。
>
> 可以从硬盘引导系统

#### 问题：硬盘格式化的作用？

> 设置引导块
>
> 设置根目录、空文件系统

### linux内核设计与实现

#### 问题：程序的数据段放了哪些数据？

> 全局变量、打开文件
>
> 比如golang mheap结构体

#### 问题：进程在内核中是如何管理？

> 进程和线程的结构体是task_struct, 每个task_struct组成了双向循环链表
>
> task_stuct包含进程状态、pid，ppid
>
> 进程有内核栈和用户空间的栈。当触发系统调用时，就用到了内核栈。如果是用户态的程序调用，使用用户栈。
>
> 为进程建立页表

#### 问题：什么是程序虚拟内存地址？

> 每个程序都是从0地址开始编码，分成代码段，数据段，堆，栈
>
> 虚拟内存地址转化成物理地址，通过mmu内存管理单元和页表

#### 问题：如何查看程序各个段的内存映射？

```
cat /proc/进程/status
cat /proc/进程id/maps
```

#### 问题：什么是内核线程？

> 内核需要执行的操作，交给内核线程执行

#### 问题：什么是孤儿线程？

> 父进程在子进程之前退出，子进程会找init做他们的父进程。

#### 问题：什么是抢占与上下文切换？

> 有非抢占式多任务 和 抢占式多任务。
>
> 抢占：进程挂起
>
> 让步：进程主动挂起
>
> 上下文切换：一个可执行切换到另一个可执行进程。保存和恢复栈信息和寄存器信息。

#### 问题：什么是用户抢占和内核抢占？

> 用户态进程会被抢占。2.6版本前内核不会发生抢占

#### 问题：linux有哪些调度策略？

> 有优先级和时间片调度机制

#### 问题：定时器和节拍器

> 1、有周期性事件
>
> 2、推迟事件 - 节拍器
>
> 如果节拍率为1000Hz  1秒钟会中断1000次，节拍率提升，中断频度也会变高。系统周期性事件准确性会提高。

#### 问题：什么是页高速缓存和页回写？

> 将数据写到磁盘中的过程：是先写到固定内存中，再合适时机由DMA写入硬盘，即页回写。
>
> 读取过程也是如此，判断内存中有没有缓存即页高速缓存。

### CCNA

#### 问题：什么冲突域？

> 在同一个冲突域的设备，其中一台发送帧时，其他设备必须监听它
>

#### 问题：什么是广播域？

> 是指一个网段中所有设备组成的集合、其中一台向广播地址发送帧时，这些设备侦听该网段中的广播。
>
> 路由器的一个端口内是一个广播域，vlan划分的子网是一个广播域

#### 问题：什么是广播？

> 一台主机发送网络广播时，网络中所有设备必须读取和处理这个广播
>
> 是硬件广播
>
> 广播是帧，帧的目标mac为：ff:ff:ff:ff
>
> 路由器的接口收到广播后会将广播丢弃，起到分割广播域的作用

#### 问题：什么是组播？

> 将消息或数据发给IP组播地址，路由器将分组的副本从每个接口转发出去，给订阅了该组播的主机。
>
> 不同于广播，路由器不转发广播

#### 问题：什么是网关？

> 路由器接口的ip或者vlan虚拟子网中等同路由器接口的ip
>
> 网关不同于广播地址

#### 问题：路由器的作用？

> 路由器是三层设备，对IP分组进行过滤和交换
>
> 1、分组交换
>
> 2、分组过滤
>
> 3、网络间通信
>
> 4、路径选择，ip路由

#### 问题：交换机的作用？

> 交换机是转发或过滤帧，帧主要字段是mac地址
>
> 交换机的每个端口都是一个独立冲突域
>
> 交换机是多端口的网桥
>
> 网桥是从自身设备一个端口进来的数据，使其从另一个端口出去

#### 问题：OSI模型各个层的作用

> 应用层：展示给用户
>
> 表示层：对数据进行编码和转换功能
>
> 会话层：建立、管理和终止会话
>
> 传输层：将数据分段并重组为数据流
>
> 网络层：确定最佳的数据传输路径，传输分组。确定网络位置，建立路由表。还要获悉目标主机的mac地址，通过arp协议。
>
> 数据链路层：使用硬件mac地址将帧传输到正确设备。确定设备的位置，建立mac地址过滤表
>
> 物理层：发送和接受比特

#### 问题：传输层保证TCP是可靠的？

> 流量控制
>
> ​	1.握手阶段，双方协商连接参数， 窗口大小=发送方最多一次发送n个数据段
>
> 确认与重传机制
>
> ​	保证数据不会漏发

#### 问题：半双工与全双工的区别

> 半双工使用一条导线，全双工使用二条导线
>
> 半双工好比单车道公路，一个时刻只能处于发送/接收
>
> 全双工好比多车道公路，一个时刻可以通知发送和接受
>
>   集线器用的是半双工，其他设备是全双工

####   问题：以太帧Ethernet_II帧有哪些字段？

![6-191106130541362](./6-191106130541362.gif)

![20190613214942454_](.\20190613214942454_.png)

| 字段           | 含义                                                         |
| -------------- | ------------------------------------------------------------ |
| 前同步码       | 用来使接收端的适配器在接收 MAC 帧时能够迅速调整时钟频率，使它和发送端的频率相同。前同步码为 7 个字节，1 和 0 交替。 |
| 帧开始定界符   | 帧的起始符，为 1 个字节。前 6 位 1 和 0 交替，最后的两个连续的 1 表示告诉接收端适配器：“帧信息要来了，准备接收”。 |
| 目的地址       | 接收帧的网络适配器的物理地址（MAC 地址），为 6 个字节（48 比特）。作用是当网卡接收到一个数据帧时，首先会检查该帧的目的地址，是否与当前适配器的物理地址相同，如果相同，就会进一步处理；如果不同，则直接丢弃。 |
| 源地址         | 发送帧的网络适配器的物理地址（MAC 地址），为 6 个字节（48 比特）。 |
| 类型           | 上层协议的类型。由于上层协议众多，所以在处理数据的时候必须设置该字段，标识数据交付哪个协议处理。例如，字段为 0x0800 时，表示将数据交付给 IP 协议。 |
| 数据           | 也称为效载荷，表示交付给上层的数据。以太网帧数据长度最小为 46 字节，最大为 1500 字节。如果不足 46 字节时，会填充到最小长度。最大值也叫最大传输单元（MTU）。  在 Linux 中，使用 ifconfig 命令可以查看该值，通常为 1500。 |
| 帧检验序列 FCS | 检测该帧是否出现差错，占 4 个字节（32 比特）。发送方计算帧的循环冗余码校验（CRC）值，把这个值写到帧里。接收方计算机重新计算 CRC，与 FCS 字段的值进行比较。如果两个值不相同，则表示传输过程中发生了数据丢失或改变。这时，就需要重新传输这一帧。 |

#### 问题：如何构造帧、ip分组、数据段？

> 通过golang的github.com/google/gopacket

#### 问题：什么情况下用直通电缆、交叉电缆

> 主机或者路由器与交换机或集线器相连，用直通电缆
>
> 其他情况用交叉电缆

#### 问题：OSI模型的数据封装流程？

![1209537-20180316141535710-1359862908](.\1209537-20180316141535710-1359862908.png)

> 网络层负责获悉目标硬件地址，指明分组发送到本地网络主机或者本地网关，可通过arp协议获取到目标地址的mac地址
>
> 网络层将分组传给数据链路层，一同传递的还有本地网络主机或者网关硬件地址

#### 问题：什么是TLS？

> tls 传输层安全 前身 ssl安全套接字层

#### 问题：什么是DHCP？

> 实现一个主机加入一个网络时，自动获得一个 IP 地址的功能，流程如下
>
> 1. DHCP 客户端广播一个 **DHCP 发现消息**，寻找本网络中的 DHCP 服务器。
>
> 　　2. DHCP 服务器收到消息，并广播一个 **DHCP 提供消息**，其中包括一个预分配个 DHCP 客户端的 IP 地址。
>
> 　　3. DHCP 客户端收到提供消息，如果接受该 IP 地址，就广播一个 **DHCP 请求消息**。
>
> 　　4. DHCP 服务器广播 **DHCP 确认消息**，告知其他主机，我正式把一个 IP 地址分配给新来的客户机。

#### 问题：tcp数据段格式？

![OIP](.\OIP.jpg)

> 数据偏移：整个TCP首部的长度，20字节的固定首部+选项（长度可变）

> 建立虚电路，可靠传输
>
> 虚电路：三次握手 + 4次挥手，建立连接
>
> 可靠传输：流量控制 + 确认和重传机制
>
> 虚电路：1个字节的标志位
>
> 流量控制：窗口大小
>
> 确认和重传机制：序号和确认号

#### 问题：udp数据段格式？

![OIP_1](.\OIP_1.jpg)

> UDP长度：整个UDP首部字段，包含8字节+UDP数据总长度

#### 问题：udp和tcp的比较，如何使udp成为tcp？

> udp在传输信息，占用网络资源更少
>
> 只要在应用层实现 虚电路建立，流量控制，确认与重传机制，便可以使udp变成tcp

#### 问题：ip数据报格式？

> 如果IP分组太大无法放入一个帧中，ip会将一个ip分组进行分片操作
>
> 协议区分不同的数据报，tcp或者udp
>
> 生存时间：分组到达目的地前经历跳数

![de4031fe3c32ebffc7c260f87ff8d796_r](.\de4031fe3c32ebffc7c260f87ff8d796_r.png)

> 协议：
>
> ICMP  1
>
> tcp 3
>
> igrp 9
>
> udp 17
>
> EIGRP 88
>
> OSPF  89
>
> IPv6  41
>
> L2TP 115

#### 问题：ARP协议过程？

> 发送3层广播，随后发送帧广播，目标主机监听广播，回复ip
>
> 是由网络层发出arp协议

![arp](.\arp.jpg)

#### 问题：有类路由选择？

> 规定：
>
> 第一个字节范围
>
> A类地址:0xxxxxxx => 0000 0000 ~ 0111 1111 0~127.开头
>
> B类地址:10xx xxxx => 1000  0000 ~ 1011 1111 128~191 开头
>
> C类地址:110x xxxx => 1100 0000 ~ 1101 1111 192~223 开头



#### 问题：什么是无类路由选择？

> 英文：CIDR  : 192.168.19.24/29
>
> 每个子网必须要第一个子网和最后一个广播地址
>
> 目的是：使用逻辑网络编制方案
>
> A类地址子网划分：比如 10.1.3.65/23
>
> B类地址子网划分：比如 172.16.0.0/20
>
> C类地址子网划分：比如 192.168.19.24/29
>
> /29 是确定了子网掩码

#### 问题：子网掩码作用？

> 划分出网络部分和子网部分，提高地址空间使用效率
>
> 一旦确定子网掩码就确定了以下几个部分
>
> 1、将创建多少个子网？/192   方式1：256/（256-192）= 4个子网 方式2 2^2 = 4个
>
> 2、每个子网包含多少台主机？ 256-192 = 64个
>
> 3、由哪些合法的子网？每隔64台，0、64、128 ...
>
> 4、子网的广播地址是？子网地址？每个子网0、64、128 ... 子网最后一个地址是广播地址
>
> 5、子网可包含的主机地址？

#### 问题：无类组网

> 路由器要支持无类路由，路由选择协议有RIPv2、EIGRP、OSPF。支持路由器每个接口上使用不同子网掩码。
>
> 邻接路由器之间发送路由更新，IP层网络层协议类型有OSPF和EIGRP，就是这类信息。
>
> ccna 129页
>
> 邻接路由器通告的汇总地址和子网掩码，方法：确定块大小，汇总地址为块中第一个地址，子网掩码为块大小对应的子网掩码
>
> 汇总地址子网块中第一个子网地址
>
> 邻接路由器之间使用/30的子网掩码即可

### 路由器

#### 问题：如何进入路由器用户EXEC模式、特权模式、全局配置模式？

```
Router>enable
Router#config
Configuring from terminal, memory, or network [terminal]? terminal
?Must be "terminal", "memory" or "network"
Router#disable
```

#### 问题：如何配置接口、子接口、路由选择协议？

```
Router# config t
Enter configuration commands, one per line.  End with CNTL/Z.
Router(config)#interface fastEthernet 0/0
Router(config-if)#exit
Router(config)#interface fastEthernet 0/0.1
Router(config-subif)# exit
Router(config)# router ospf
```

#### 问题：如何配置快速以太口，串口并启用、配置ip？

```
Router(config)#interface fastEthernet 0/1 插槽1
Router(config-if)#no shutdown
Router(config-if)#do show int f0/1
Router(config)#interface s0/1/0 插槽1
Router(config-if)#ip address 192.168.3.254 255.255.255.0
Router(config-if)#do show int f0/1
```





### linux系统排查

```
源代码部分

program部分可用的排查工具:
gdb 调试工具
ldd 查看程序依赖库
lsof 一切皆文件
nm 目标文件格式分析
readelf elf文件格式分析
objdump 二进制文件分析
size 查看程序内存映像大小

process部分可用的排查工具：
对process : ps 进程查看器
对栈：pstack 跟踪进程栈
对进程间通信: ipcs 查询进程间通信

linux系统系统排查:
sar 找出系统瓶颈利器
cpu top
io iostat 监视io
memory vmstat 监视内存使用情况 free 查询可用内存
对系统调用: strace 跟踪进程中的系统调用



ps 进程查看器

```

- nginx
```
nginx 主要就是三大模块 http(7层) stream（4层 tcp层） mail（邮件模块）
比如：http和stream 都有pass_proxy指令，但在不同模块。
能做tcp代理的有nignx, haproxy ,twempory

http 模块下的指令
1. location指令，=,^~,~,~*,顺序
2. rewrite指令,url重写, regex,replace last|break|redirect|
3. 配置php-fpm关键指令, fastcgi_param SCRIPT_FILENAME $document_root/foo/index.php
4. proxy_pass与upstream
5. 理解listen 127.0.0.1:80 与 listen 80 区别
```

- mysql
```
mysql innodb适合读多写少，可以增加缓存。写多读少，低价值数据使用nosql,高价值数据使用tokudb存储引擎。

MySQL如何实现事务ACID？通过redo log和undo log
redo log叫做重做日志，是用来实现事务的持久性。当事务提交之后会把所有修改信息都会存到该redo log日志中。发生断电，可以根据此日志恢复。redo log是用来恢复数据的 用于保障，已提交事务的持久化特性。
undo log是用来回滚数据的用于保障未提交事务的原子性。undo log记录事务修改之前版本的数据信息，因此假如由于系统错误或者rollback操作而回滚的话可以根据undo log的信息来进行回滚到没被修改前的状态。

事务4个特性ACID
锁和MVCC。锁分为表锁，行锁。lock in share mode （共享锁），for update（排他锁）。
（Atomicity ） 原子性： 事务是最小的执行单位，不允许分割。原子性确保动作要么全部完成，要么完全不起作用；
（Consistency）一致性： 执行事务前后，数据保持一致；
（Isolation）隔离性： 并发访问数据库时，一个事务不被其他事务所干扰。
（Durability）持久性: 一个事务被提交之后。对数据库中数据的改变是持久的，即使数据库发生故障。

因为存在事务并发，所以要事务隔离去保证？
事务隔离级别
未提交读	一个事务还没提交时，它做的变更就能被别的事务看到。要达到这个效果，增加了读写锁。脏读针对另一个事务的update操作，解决脏读可以mysql的读写锁lock in share或者for update
提交读	一个事务提交之后，它做的变更才会被其他事务看到。要达到这个效果，增加了读写和间隙锁。解决脏读问题，还有幻读问题。想一下幻读的原因，其实就是行锁只能锁住行，幻读针对另一个事务的insert操作，但新插入记录这个动作，要更新的是记录之间的“间隙”
可重复读	一个事务中，对同一份数据的读取结果总是相同的，无论是否有其他事务对这份数据进行操作，以及这个事务是否提交。 要达到这个效果，增加了读写和间隙锁和MVCC。InnoDB默认级别 。
		针对本事务重复读取数据，通过MVCC多版本的并发控制，在每行记录增加隐藏版本字段，每开启事务时获取版本号，达到可重复读效果。
		MVCC保证事务的隔离性
串行化	
	事务串行化执行，每次读都需要获得表级共享锁，读写相互都会阻塞，隔离级别最高，牺牲系统并发性。


1. sql语句，创建用户并授于增删改查所有库表的权限
1.1 修改密码update user ''@'' set password = password('')
2. sql语句，创建唯一的联合索引
3. 索引引擎区别，btree索引与hash索引的区别
innodb和myisam都是用b+tree索引，不同的是myisam的b+tree不带数据需要回表，
b+tree索引带数据不需要回标，聚餐索引。innodb支持行锁，有更高的并发
innodb的辅助索引记录的是主键id，查本身的索引b+tree得到主键id，再去主键索引b+tree树获得数据。
联合索引的存储结构参考https://blog.csdn.net/weixin_30531261/article/details/79329722
3.1 b+树非叶子节点保留指针、索引值，叶子节点保留数据、整行数据、数据块地址+行号
3.2 innodb使用聚餐索引。聚餐索引：主键索引树保存在内存中，同时会将叶子节点保存着数据，可以不用去磁盘查找。myisam没有使用聚餐索引，需要去磁盘查

Hash 索引在计算 Hash 值的时候是组合索引键合并后再一起计算 Hash 值，而不是单独计算 Hash 值，所以通过组合索引的前面一个或几个索引键进行查询的时候，Hash 索引也无法被利用。索引的检索可以一次定位，不像B-Tree 索引需要从根节点到枝节点.

innodb 是mysql5.5以后默认存储引擎，使用场景
1).需要支持事务的业务(例如转账,付款)
2).行级锁定对于高并发有很好的适应能力,但是需要保证查询是通过索引完成.
	因为有行锁，对写多读少场景更加友好。
3).数据读写及更新都比较频繁的场景,如:BBS,SNS,微博,微信等.
4).数据一致性要求很高的业务.如:转账,充值等.
5).硬件设备内存较大,可以很好利用InnoDB较好的缓存能力来提高内存利用率,尽可能减少磁盘IO的开销.


4. 索引最左原则
4.1 or左右二边字段都是索引列会走索引
4.2 like 不以%开头的话，会使用索引
大表分页的limit问题：获取select max(1)获取
使用子查询或者where id
行锁颗粒小，但是维护成本高，大量写入时，选用表锁
5. 什么样的列适合做为索引列，高区分度
6. sql语句，如何设置慢日志,访问日志
	#开启慢查询 slow_query_log值为1或on表示开启，为0或off为关闭
	slow_query_log=on 
	#设置慢查询日志放在哪里
	slow_query_log_file=mysql-slow 
	#设置sql执行时间多长为慢查询
	long_query_time=2
	# 设置
	SET GLOBAL slow_query_log = ON
	SHOW VARIABLES LIKE 'general%';
	set GLOBAL general_log='ON';
	general_log：日志功能是否开启，默认关闭OFF
	general_log_file：日志文件保存位置

覆盖索引
覆盖索引是select的数据列只用从索引中就能够取得，不必读取数据行，换句话说查询列要被所建的索引覆盖。

7.慢日志分析工具用过的分析工具 
	pt-query-digest 慢日志分析工具
	参考文章：https://blog.csdn.net/seteor/article/details/24017913
8. 主从同步配置有哪几种，日志复制，事务复制，日志复制的步骤
9. 分表的规则，（hash，range二种形式）
10. innodb与myisam引擎的区别，索引的聚簇与非聚簇，行锁
11. 如何分析一条语句的性能？explain
type
	性能逐渐提高
	ALL 进行完整的表扫描,性能最差
	index 在索引树全扫描
	range 在索引树扫描，获取索引树的一部分，比如：uid有索引，下面语句使用range
	explain select * from uchome_space where uid in (1,2)
	ref 可以用于单表扫描或者连接,连接字段非索引
	eq_ref 可以用于单表扫描或者连接，唯一索引或者主键索引
	const where 后面的连接字段，主键或者唯一键
possible_keys：可能会使用的索引
keys：使用的索引
rows：MYSQL执行查询的行数，简单且重要，数值越大越不好
Extra：
	using index 只使用索引树中的信息而不需要进一步搜索读取实际的行来检索表中的信息
	using where 未建立索引
	using temporary 需要创建一个临时表来容纳结果,典型情况如查询包含可以按不同情况列出列的GROUP BY和ORDER BY子句时。此时需要优化。
12. 对于mysql数据存储这块，自己有做过哪些事情，项目?

13. 数据库存储补充
操作系统按照8kB大小数据块为一个基本单位，一个数据块中存有数据库的几行数据其中有数据的行号。
对于聚餐索引，主键索引的叶子节点和非叶子节点是一个数据块，8KB大小。叶子节点（1个数据块）保存了几行数据
对于非聚簇索引，主键索引的叶子节点和非叶子节点是一个数据块，8KB大小。叶子节点（1个数据块）保存了几行数据的数据块地址和行号。
根据索引找数据，首先需要将通过一次io或多次io，将索引节点（数据块）读取到内存中，然后找到真正数据（非聚簇索引，还需要数据块地址和行号去找）
（聚餐索引，节点数据就保存着整行数据）

14. 乐观锁与悲观锁
乐观锁：
使用数据版本（Version）记录机制实现，即为数据增加一个版本标识，一般是通过为数据库表增加一个数字类型的 “version” 字段来实现。先查询，更新update把version+1，作为where条件。
另一种做法增加时间字段timestamp来实现先查询，更新update把timestamp字段作为where条件。
where条件不满足就不会更新。
update set where version=
悲观锁：（行锁）
悲观锁分二种：
共享锁：
	select * lock in share mode 获取锁，再操作
排他锁
	select for update 获取锁，再更新


15、解决问题：分库分表分布式主键id自增解决办法
1、基于数据库的实现方案
适合的场景：你分库分表就俩原因，要不就是单库并发太高，要不就是单库数据量太大；
除非是你并发不高，但是数据量太大导致的分库分表扩容，你可以用这个方案，
因为可能每秒最高并发最多就几百，那么就走单独的一个库和表生成自增主键即可。

2、uuid
UUID 太长了、占用空间大，作为主键性能太差了

3、snowflake 算法
了解了雪花算法的主键 ID 组成后不难发现，这是一种严重依赖于服务器时间的算法，而依赖服务器时间的就会遇到一个棘手的问题：时钟回拨
雪花算法如何解决时钟回拨

服务器时钟回拨会导致产生重复的 ID，SNOWFLAKE 方案中对原有雪花算法做了改进，增加了一个最大容忍的时钟回拨毫秒数。

如果时钟回拨的时间超过最大容忍的毫秒数阈值，则程序直接报错；如果在可容忍的范围内，默认分布式主键生成器，会等待时钟同步到最后一次主键生成的时间后再继续工作。

最大容忍的时钟回拨毫秒数，默认值为 0，可通过属性 max.tolerate.time.difference.milliseconds 设置。

16、分库分表采用主键作为range
```

- redis
```
1. redis二种数据备份持久化的机制以及简述?
	rdb:每隔一段时间改变次数到达一定次数，落盘。
	aof:写操作就去落盘
2. redis有主从复制机制，慢日志机制。redis哨兵模式，出现故障时将从服务器作为主服务器减少人工干预。主从机器内存中存储相同数据，浪费内容。集群模式则共享内存。

集群模式
采用去中心化思想，数据按照 slot 存储分布在多个节点，节点间数据共享，可动态调整数据分布;

可扩展性：可线性扩展到 1000 多个节点，节点可动态添加或删除;

高可用性：部分节点不可用时，集群仍可用。通过增加 Slave 做 standby 数据副本，能够实现故障自动 failover，节点之间通过 gossip 协议交换状态信息，用投票机制完成 Slave 到 Master 的角色提升;

降低运维成本，提高系统的扩展性和可用性。

2.1 redis代理
分成client代理，server代理:twemproxy
代理基本原理是：通过中间件的形式，Redis客户端把请求发送到代理，代理根据路由规则发送到正确的Redis实例，最后代理把结果汇集返回给客户端。

基于客户端的方案任何时候都要慎重考虑，在此我们不予推荐。

基于twemproxy的方案虽然看起来功能挺全面，但是实际使用中存在的问题同样很多，具体见上述，目前也不推荐再用twemproxy的方案。

redis cluster自redis 3.0推出以来，目前已经在很多生产环境上得到了应用，目前来讲，构建redis集群，推荐采用redis cluster搭配一款支持redis cluster的代理方案。

3. key的过期策略？
3.1 主动定时删除
3.2 取key时，检查删除
3.3 key淘汰机制
redis针对内存满了，有哪几种处理机制？ 一般是1、不移除，2、随机移除带有过期时间的key 3、根据lru移除带有过期时间的key
	# volatile-lru -> 利用LRU算法移除设置过过期时间的key (LRU:最近使用 Least Recently Used )
	# allkeys-lru -> 利用LRU算法移除任何key
	# volatile-random -> 移除设置过过期时间的随机key
	# allkeys->random -> remove a random key, any key 
	# volatile-ttl -> 移除即将过期的key(minor TTL)
	# noeviction -> 不移除任何可以，只是返回一个写错误
4. redis有哪几种数据结构？写出每种数据结构set命令
	string, set foo bar
	hash, hset foo age 24
	set, sadd foo bar
	sort set, zadd foo bar 1， ZRANGE foo 0 10 WITHSCORES
	list, lset foo bar
5. 缓存和数据库双写问题（redis保证最终一致性）
“数据一致”一般指的是：缓存中有数据，缓存的数据值 = 数据库中的值。

redis用来只读缓存，并发量不大情况可以采用“更新数据库+删除缓存用被动更新策略。去数据库取数据的时候，可以加个锁可以避免缓存穿透。
并发量大会出现缓存穿透，所以采用“更新数据库+更新缓存”主动缓存策略策略。
如果担心删除或者更新redis操作失败，采用消息队列或者binlog作为失败补偿和重试。

根据是否接收写请求，可以把缓存分成读写缓存和只读缓存。

只读缓存：只在缓存进行数据查找，即使用 “更新数据库+删除缓存” 策略；
	分成二步1.更新数据库 2.删除缓存 如果假设第2步会失败了，则在第一步成功后，删除redis操作写入消息队列，借助消息队列失败重试功能。还可以使用 写数据库后使用消息队列+异步重试 进行补偿（binlog日志等方式）。进来的第一个进程上锁，从数据库取数据。
读写缓存：需要在缓存中对数据进行增删改查，即使用 “更新数据库+更新缓存”策略。
	分成二步1.更新数据库 2.更新缓存 如果假设第2步会失败了，则在第一步成功后，删除redis操作写入消息队列，借助消息队列失败重试功能。
https://cloud.tencent.com/developer/article/1917325
5.1 为了没有脏数据，采用先写数据库后删除缓存，还可以使用 写数据库后使用消息队列+异步重试 进行补偿（binlog日志等方式）

6. 穿透和雪崩该如何处理？
- 被动缓存：
	1. 先更新数据库再删除redis，过期时间设置随机。
	2. 进来的第一个进程上锁，从数据库取数据。
- 主动缓存：
	1. 脚本主动从数据库取数据，更新缓存，保证缓存不失效

7.dis集群并发竞争key的问题该如何处理？
	redis是单进程程序，多个set操作同时进来，由于操作顺序不一致出现数据不一致问题。
	解决方案：
		1. 分布式锁- redis-setnx
		2. 消息队列 - 并发操作变成并行操作
```

- rocketmq
```
//初始化
ps.Producer, err = rocketmq.NewProducer(
	producer.WithInstanceName(conf.Name+"Producer"),
	producer.WithGroupName(conf.Name+"ProducerGroup"),
	producer.WithNameServer([]string{addr}),
	producer.WithRetry(2),
)
if err != nil {
	return err
}
if err = ps.Producer.Start(); err != nil {
	return err
}
//健康检查
msg := primitive.NewMessage(conf.Topic, []byte("startTime:"+time.Now().Format(time.RFC3339Nano)))
msg.WithKeys([]string{conf.Topic + ":pid:" + strconv.Itoa(os.Getpid())})
_, pingErr := ps.Producer.SendSync(context.Background(), msg)
if pingErr != nil {
	return err
}

// send
msg := primitive.NewMessage(ps.conf.Rocket.Topic, value)
result, err := ps.Producer.SendSync(context.Background(), msg)

// subsribe
consumerObject, err := rocketmq.NewPushConsumer(
	consumer.WithNameServer([]string{addr}),
	consumer.WithInstance(fmt.Sprintf("%sConsumer%d", conf.Name, i)),
	consumer.WithGroupName(conf.Name+"ConsumerGroup"),
	consumer.WithPullInterval(time.Duration(conf.ConsumeInterval)*1000*time.Millisecond), //拉消息间隔，单位需要是millisecond
	consumer.WithConsumerOrder(true),
	consumer.WithConsumeFromWhere(consumer.ConsumeFromFirstOffset),
	consumer.WithConsumerModel(consumer.Clustering), //消费模式，默认为clustering
	//consumer.WithPullBatchSize(1),              //一个queue一次最多拉取多少条消息，默认值32，设置了超过32时似乎也不会生效
	consumer.WithConsumeMessageBatchMaxSize(1), //一次消费多少条消息，默认值1，超过32就无意义了，这一批消息将拥有同一个消费状态，即如果消息的消费状态返回的是CONSUME_SUCCESS，则它们都消费成功，而如果返回的是RECONSUME_LATER，则它们都将再次投递。
)
if err != nil {
	return err
}
err = consumerObject.Subscribe(conf.Topic, consumer.MessageSelector{}, cs.SubCommunicateSendMsg)
if err := consumerObject.Start(); err != nil {
	return err
}

为什么要使用MQ？
1、解耦 
2、异步：不需要同步执行的远程调用可以有效提高响应时间
3、削峰：请求达到峰值后，后端service还可以保持固定消费速率消费，不会被压垮

由哪些角色组成，每个角色作用和特点是什么？
角色	作用
Nameserver	无状态，动态列表；这也是和zookeeper的重要区别之一。zookeeper是有状态的。
Producer	消息生产者，负责发消息到Broker。
Broker	就是MQ本身，负责收发消息、持久化消息等。
Consumer	消息消费者，负责从Broker上拉取消息进行消费，消费完进行ack。
topic对应多个queue，queue分布式存储在多个broker
架构介绍示意图：https://blog.csdn.net/wui66655/article/details/123091578

RocketMQ Broker中的消息被消费后会立即删除吗？
不会，每条消息都会持久化到CommitLog中，每个Consumer连接到Broker后会维持消费进度信息。
消息被消费后，更新当前Consumer的消费进度（CommitLog的offset）

追问：那么消息会堆积吗？什么时候清理过期消息？
默认，凌晨4点去删除过期48小时的commitlog的消息

RocketMQ消费模式有几种？
集群消费
1.一条消息只会被同Group中的一个Consumer消费
2.多个Group同时消费一个Topic时，每个Group都会有一个Consumer消费到数据

广播消费
消息将对一 个Consumer Group 下的各个 Consumer 实例都消费一遍。

消费消息是push还是pull？
RocketMQ没有真正意义的push，都是pull，虽然有push类，但实际底层实现采用的是长轮询机制，即拉取方式
broker端属性 longPollingEnable 标记是否开启长轮询。默认开启

追问：为什么要主动拉取消息而不使用事件监听方式？
如果broker主动推送消息的话有可能push速度快，消费速度慢的情况。


RocketMQ如何做负载均衡？
topic对应多个queue，queue可以分布在不同broker
Producer负载均衡
Producer端，每个实例在发消息的时候，默认会轮询所有的message queue发送，以达到让消息平均落在不同的queue上。而由于queue可以散落在不同的broker，所以消息就发送到不同的broker下.
Consumer负载均衡
在集群消费模式下，每条消息只需要投递到订阅这个topic的Consumer Group下的一个实例即可,queue都是只允许分配只一个实例。

广播模式下要求一条消息需要投递到一个消费组下面所有的消费者实例，所以也就没有消息被分摊消费的说法。



消息重复消费
影响消息正常发送和消费的重要原因是网络的不确定性。

引起重复消费的原因：
ACK
正常情况下在consumer真正消费完消息后应该发送ack，通知broker该消息已正常消费，从queue中剔除
当ack因为网络原因无法发送到broker，broker会认为词条消息没有被消费，此后会开启消息重投机制把消息再次投递到consumer
消费模式
在CLUSTERING模式下，消息在broker中会保证相同group的consumer消费一次，但是针对不同group的consumer会推送多次

解决方案：
数据库表（推荐）
解决办法：利用数据库的唯一索引存储消息主键
处理消息前，使用消息主键在表中带有约束的字段中insert
Map
单机时可以使用map ConcurrentHashMap -> putIfAbsent guava cache
Redis
分布式锁搞起来

如何让RocketMQ保证消息的顺序消费
首先多个queue只能保证单个queue里的顺序，queue是典型的FIFO，天然顺序。多个queue同时消费是无法绝对保证消息的有序性的。所以总结如下：
同一topic，同一个QUEUE，发消息的时候一个线程去发送消息，消费的时候 一个线程去消费一个queue里的消息。

RocketMQ如何保证消息不丢失
首先在如下三个部分都可能会出现丢失消息的情况：
Producer端
Broker端
Consumer端

Producer端如何保证消息不丢失
采取send()同步发消息，发送结果是同步感知的。
发送失败后可以重试，设置重试次数。默认3次。

Broker端如何保证消息不丢失
修改刷盘策略为同步刷盘。默认情况下是异步刷盘的。
flushDiskType = SYNC_FLUSH
集群部署，主从模式，高可用。

Consumer端如何保证消息不丢失
完全消费正常后在进行手动ack确认。


rocketMQ的消息堆积如何处理?
下游消费系统如果宕机了，导致几百万条消息在消息中间件里积压，此时怎么处理?
你们线上是否遇到过消息积压的生产故障?如果没遇到过，你考虑一下如何应对?
定位问题，修改bug，增加消费者

追问：堆积时间过长消息超时了？
未被消费的消息不会存在超时删除这情况

追问：堆积的消息会不会进死信队列？
不会，消息在消费失败后会进入重试队列（%RETRY%+ConsumerGroup），16次（默认16次）才会进入死信队列（%DLQ%+ConsumerGroup）。

Broker把自己的信息注册到哪个NameServer上？
因为Broker会向所有的NameServer上注册自己的信息，而不是某一个，是每一个，全部！


RocketMQ在分布式事务支持这块机制的底层原理?
最终一致性方案
查看这张图片，解释分布式事务过程：https://pic1.zhimg.com/v2-4defd36bc842d453308b22667e38a421_1440w.jpg?source=172ae18b
```

- v2ray
```
https://wkzqn.gitee.io/2020/11/15/Ubuntu%E4%B8%ADv2ray%E5%AE%A2%E6%88%B7%E7%AB%AF%E9%85%8D%E7%BD%AE/

```

- git
```
1. 工作区，暂存区，本地分支

2. 如何取消一个文件的修改？
	git reset HEAD <file> // 抵消 add
	git checkout -- filename
2. 一个文件提交到版本库了，如何撤回？
	版本回退，git reset或者 git revert
3. 分支回滚命令git revert和git reset的区别？
	git revert 是对一次commit逆操作，分支继续往前进
	git reset 是分支后退，回退到某一个commit
4. git rebase作用
	merge过分支后，历史事件重新排序变成直线
	合并分支，将分支的所有commit提交汇集成一个commit
	git rebase -i --autosquash master
5、项目分支管理策略
	采用阿里AoneFlow。有环境分支，有发布窗口分支，有特性分支

```

- mongo
```
1. 将select * from a where id > 1翻译成mongo语句?
	db.a.find({"id":{$gt:1}})
2. 为a集合的userid,ctime字段创建联合索引语句
	db.a.createIndex({"userid":-1,"ctime":-1})
3. 查看a集合有哪些索引
	db.a.getIndex();
4. 有没有mongo本身做过项目或者事情?
```

- vim,sed
```
1. 替换一个文件中的一段文字,有几种方式?
	vim %s/old/new/gc,sed命令
```

- tcp
```
1. tcp状态时序图
参考文章：https://blog.csdn.net/abc_ii/article/details/18603469
参考文章：https://blog.csdn.net/qq_40281445/article/details/109039566
三次握手
	1. 客户端发送syn包，自身状态变成syn_sent
	2. 服务端收到syn包，返回syn+ack包,自身状态变为syn_revd
	3. 客户端接收到syn+ack,返回ack包，自身状态变为established
	4. 服务端收到ack包，自身状态变为established
四次挥手
	1. 客户端发送fin包，自身状态变为fin_wait_1
	2. 服务端收到fin包，返回fin+ack,自身状态变成closing
	3. 客户端接收到fin+ack，自身状态变成fin_wait_2
	3. 服务端自身关闭时，发送fin包,自身装填变成close_wait
	4. 客户端接收到fin包，返回fin+ack包,自身变成time_wait,等2msl变成closed
	5. 服务端接收到fin+ack包，自身变成closed

SYN Flood攻击
	client向server发送SYN但就是不回server，最后使得server的SYN（半连接）队列耗尽，无法处理正常的建立连接的请求。

因为TCP是全双工协议，也就是说双方都要关闭，每一方都想对方发送FIN和回应ACK，所以看起来就是四次。

主动关闭方的状态是FIN_WAIT_1到FIN_WAIT_2,然后再到TIME_WAIT状态，等2msl到CLOSED。

被动关闭方是CLOSE_WAIT到LAST_ACK状态，再到CLOSED。

服务器主动关闭大量连接，那么会出现大量的资源占用，需要等到2MSL才会释放资源

服务端尽量不要主动关闭连接，把关闭连接的请求放到客户端来做，减少服务端出现TIME_WAIT状态的连接出现的机率，提高服务端的资源利用率。

2MSL，即两个最大报文段生存时间。
TIME_WAIT状态为什么是2MSL的时长？避免异常情况。如果少于2MSL关闭，又重新建立了连接，此时服务端会重传FIN
因为客户端不知道服务端是否能收到ACK应答数据包，服务端如果没有收到ACK，会进行重传FIN，考虑最坏的一种情况：第四次挥手的ACK包的最大生存时长(MSL)+服务端重传的FIN包的最大生存时长(MSL)=2MSL

2. 在服务端抓取与某一个客户端来往的tcp,80包？
	tcpdump -X -s 0 -iany host xxx.xxx  -w '/tmp/tcp.cap' 在把tcp.wap用wireshark打开
3. tcp有哪些字段
3.1 来源端口
3.2 目标端口
3.3 序列好和确认序列号
3.4 包长度
3.5 tcp标志位，ack，fin，syn，rst
3.6 滑动窗口，流量控制
3.7 校验和
http://www.ruanyifeng.com/blog/2017/06/tcp-protocol.html
https://www.cnblogs.com/ellisonzhang/p/10402863.html - 推荐
4. 一个帧中数据包 最大1500字节 加上帧头 14字节，加上帧尾 4字节。标准只有576字节。
所以 UDP 单个包过大，会在ip层进行分包，会有丢失可能，UDP要控制数据应用在 1500 - 20（IP首部长度） - 8（UDP首部长度） 以下
最好控制在 576 - 20（IP首部长度） - 8（UDP首部长度） 以下
5. tcp 不需要控制 应用数据大小，因为tcp会进行流量控制，序列号。
tcp首部长度 20 ，所以一个数据长度 1500 - 20（IP首部长度） - 20（tcp首部长度）
6. 端口号最大值，为什么？
2的16次方，因为在tcp首部字段中只分配给了16个位用于存储端口号
7. wireshark抓包分析
7.1 可以 statistic -> flow graph 直观查看发送过程
7.2 wireshark fiter : 有三个主要实体 ip, tcp, http。分别对应ip首部，tcp首部，http首部字段。
比如 tcp.flags.syn == 1 && tcp.flags.ack == 1， ip.src == 192.168.200.231
7.3 tcp.stream eq 0 和 follow tcp stream
```

- ip层首部字段
```
1. version 版本号
2. header lenth 长度，20字节 tcp首部字段长度也是20字节，udp首部字段长度8个字节
3. fragment offset 分片偏移
4. proto 协议
5. checksum 奇偶校验
6. 源ip
7. 目标ip
```

- ipv4,ipv6协议层面
```
ipv4是4字节存放ip地址，ipv6是16字节
https://www.jianshu.com/p/fab7404ba73b

ipv4:版本号,生存时间TTL（8位）,协议（8位）,.源地址（32位）,目的地址（32位）
ipv6:版本号,生存时间TTL（8位）,.源地址（32位）,目的地址（32位）
```

- https握手流程
```
https://zhuanlan.zhihu.com/p/240389098
1.客户端提交https请求

2.服务器响应客户,并把服务器公钥发给客户端

3.客户端验证公钥的有效性

4.有效后，客户端会生成一个会话密钥(一个随机数)

5.用服务器公钥加密这个会话密钥后，发送给服务器

6.服务器收到公钥加密的密钥后，用私钥解密，获取会话密钥

7.客户端与服务器利用会话密钥对传输数据进行对称加密通信

```
-客户端如何检验公钥是不是合法呢？
```
客户端其实需要预置CA签发的根证书，这个根证书中保存了CA的公钥.
客户端接收到服务器证书后，使用预置的CA签发的根证书进行验签
```
- nginx配置https
```
http {
    include       mime.types;
    default_type  application/octet-stream;
    sendfile        on;
    keepalive_timeout  65;
	server {
		#监听443端口
		listen 443;
		#你的域名
		server_name huiblog.top; 
		ssl on;
		#ssl证书的pem文件路径
		ssl_certificate  /root/card/huiblog.top.pem;
		#ssl证书的key文件路径
		ssl_certificate_key /root/card/huiblog.top.key;
		location / {
		proxy_pass  http://公网地址:项目端口号;
		}
	}
	server {
		listen 80;
		server_name huiblog.top;
		#将请求转成https
		rewrite ^(.*)$ https://$host$1 permanent;
	}
}
```

- shell
```
pwd=/workspace
cd $pwd
for i in ` mysql -h xxx -uxxx -pxxx -e 'select * from xxx' | awk '{print $1}'  | awk -F '.flv' '{print $1}' | awk -F '/' '{print $2}'`
do	
	if [ ! -d $pwd$i ];then
		mkdir $pwd$i;
		cd $pwd$i;
		// do something
		rm -rf $i.flv;
	fi
done
```

- docker
```
Dockerfile：用来生成镜像
1. docekr build -t imageName .
镜像：好比是容器的存档
1. docekr images
2. docker rmi xxx
镜像运行变容器:
1. docker run -d --name --privileged -p -v --rm --link=mysql:mysql image_name
容器:
1. docker ps
2. docker container ls -a
3. docker rm
容器变镜像:
1. docekr commit con 
仓库:
1. docker pull centos:6
2. docker push
3. docker login

Docker 架构及工作原理
Docker 在运行时分为 Docker 引擎（服务端守护进程） 和 客户端工具，我们日常使用各种 docker 命令，其实就是在使用 客户端工具 与 Docker 引擎 进行交互。


Docker与虚拟机有何不同?
docker Engine可以简单看成对Linux的NameSpace、Cgroup、镜像管理文件系统操作的封装。docker并没有和虚拟机一样利用一个完全独立的Guest OS实现环境隔离，
它利用的是目前linux内核本身支持的容器方式实现资源和环境隔离。简单的说，docker利用namespace实现系统环境的隔离；利用Cgroup实现资源限制；利用镜像实现根目录环境的隔离。
虚拟机完全独立的操作系统环境。docker利用linux的namespace,cgroup技术实现环境和资源的隔离。

Docker技术三大要点：cgroup, namespace和unionFS的理解
namespace：眼睛
另一个维度的资源隔离技术，大家可以把这个概念和我们熟悉的C++和Java里的namespace相对照。
如果CGroup设计出来的目的是为了隔离上面描述的物理资源，那么namespace则用来隔离PID(进程ID),IPC,Network等系统资源。
在不同命名空间内启动的程序可以做到pid允许为1

cgroup：手
CGroups 全称control group，用来限定一个进程的资源使用，由Linux 内核支持，可以限制和隔离Linux进程组 (process groups) 所使用的物理资源 ，比如cpu，内存，磁盘和网络IO，是Linux container技术的物理基础。

unionfs: 脚
镜像分层
而新镜像就是从基础镜像上一层层叠加新的逻辑构成的。这种分层设计，一个优点就是资源共享。
1. boot file system （bootfs）：包含操作系统boot loader 和 kernel。用户不会修改这个文件系统。
一旦启动完成后，整个Linux内核加载进内存，之后bootfs会被卸载掉，从而释放出内存。
同样内核版本的不同的 Linux 发行版，其bootfs都是一致的。
2. root file system （rootfs）：包含典型的目录结构，包括 /dev, /proc, /bin, /etc, /lib, /usr, and /tmp

可写的容器层？
镜像分层设计，可以被用做缓存。当容器启动时，一个新的可写层被加载到镜像的顶部。这一层通常被称作“容器层”，“容器层”之下的都叫“镜像层”。

Dockerfile中的命令COPY和ADD命令有什么区别?
一般而言，虽然ADD并且COPY在功能上类似，但是首选COPY。那是因为它比ADD更易懂。COPY仅支持将本地文件复制到容器中，而ADD具有一些额外的功能(如仅限本地的tar提取和远程URL支持)，这些功能并不是很明显。因此，ADD的最佳用途是将本地tar文件自动提取到镜像中，如ADD rootfs.tar.xz /。COPY与ADD的区别COPY的SRC只能是本地文件，其他用法一致

容器与主机之间的数据拷贝命令？
Docker cp命令用于穷奇与主机之间的数据拷贝
主机到容器：docker cp /www 96f7f14e99ab:/www/
容器到主机：docker cp 96f7f14e99ab:/www /tmp

如何批量清理临时镜像文件？
可以使用sudo docker rmi $(sudo docker images -q -f danging=true)命令

可以在一个容器中同时运行多个应用进程吗？
一般不推荐在用以容器内运行多个应用进程，如果有类似需求，可以用过额外的进程管理机制，比如supervisord来管理所运行的进程。

如何控制容器占用系统资源（CPU，内存）的份额？
在使用docker create命令创建容器或使用docker run 创建并运行容器的时候，可以使用-c|-spu-shares[=0]参数来调整同期使用SPU的权重，使用-m|-memory参数来调整容器使用内存的大小。

docker引擎配置文件：/etc/docker 
docker默认存储位置：/var/lib/docker 
于docker相关的本地资源存在/var/lib/docker/目录下，其中container目录存放容器信息，graph目录存放镜像信息，aufs目录下存放具体的镜像底层文件。

docker inspect
查看各种容器信息

六种减小Docker镜像大小的方法
1. 使用Alpine Linux作为基础镜像。
2. 只安装最少的依赖  --no-install-recommends，指定这个参数后，有一些非必须的依赖将不会被一起安装
3. 命令写在一行，减少层数
4、多阶段编译：编译和运行基础镜像分离
COPY --from=builder /usr/src/target/shirodemo-1.0-SNAPSHOT.jar /shirodemo-1.0-SNAPSHOT.jar
```

kubernetes
```
架构设计
https://www.kubernetes.org.cn/kubernetes%e8%ae%be%e8%ae%a1%e6%9e%b6%e6%9e%84
Kubernetes主要由以下几个核心组件组成：

etcd保存了整个集群的状态；
apiserver提供了资源操作的唯一入口，并提供认证、授权、访问控制、API注册和发现等机制；
controller manager负责维护集群的状态，比如故障检测、自动扩展、滚动更新等；Node controller, pod controller, namespace controller,replication controller
scheduler负责资源的调度，按照预定的调度策略将Pod调度到相应的机器上；
kubelet负责维护容器的生命周期，同时也负责Volume（CVI）和网络（CNI）的管理；
Container runtime负责镜像管理以及Pod和容器的真正运行（CRI）；
kube-proxy负责为Service提供cluster内部的服务发现和负载均衡；
除了核心组件，还有一些推荐的Add-ons：

kube-dns负责为整个集群提供DNS服务
Ingress Controller为服务提供外网入口
Heapster提供资源监控
Dashboard提供GUI
Federation提供跨可用区的集群
Fluentd-elasticsearch提供集群日志采集、存储与查询

概述：
node:
1、CRI:docker 负责容器运行
2、kubelet：接收master指令在本节点执行，比如管理容器网络
3、kube-proxy: 内部service的负载均衡

master:
1、etcd：保存集群状态
2、apiserver：cli，gui指令
3、controller: 集群状态，控制pod。
4、scheduler：pod调度


Kubernetes的核心技术概念和API对象
API对象是K8s集群中的管理操作单元。K8s集群系统每支持一项新功能，引入一项新技术，一定会新引入对应的API对象，支持对该功能的管理操作。例如副本集Replica Set对应的API对象是RS。

即所有的操作都是声明式（Declarative）的而不是命令式（Imperative）的。声明式操作在分布式系统中的好处是稳定，不怕丢操作或运行多次，例如设置副本数为3的操作运行多次也还是一个结果，而给副本数加1的操作就不是声明式的，运行多次结果就错了。

Pod
最重要的也是最基础的是微服务Pod。Pod是在K8s集群中运行部署应用或服务的最小单元，它是可以支持多容器的。
Pod的设计理念是支持多个容器在一个Pod中共享网络地址和文件系统，可以通过进程间通信和文件共享这种简单高效的方式组合完成服务。

Pod是K8s集群中所有业务类型的基础，可以看作运行在K8s集群中的小机器人，不同类型的业务就需要不同类型的小机器人去执行。目前K8s中的业务主要可以分为长期伺服型（long-running）、批处理型（batch）、节点后台支撑型（node-daemon）和有状态应用型（stateful application）；分别对应的小机器人控制器为Deployment、Job、DaemonSet和PetSet，本文后面会一一介绍。

pod代表着一个集群中节点上运行的进程.

部署(Deployment)
部署表示用户对K8s集群的一次更新操作。部署是一个比RS应用模式更广的API对象，可以是创建一个新的服务，更新一个新的服务，也可以是滚动升级一个服务。滚动升级一个服务，实际是创建一个新的RS，然后逐渐将新RS中副本数增加到理想状态，将旧RS中的副本数减小到0的复合操作；这样一个复合操作用一个RS是不太好描述的，所以用一个更通用的Deployment来描述。以K8s的发展方向，未来对所有长期伺服型的的业务的管理，都会通过Deployment来管理。

服务（Service）：用做负载均衡，外部通过nodeIP访问pod，也可以是内部pod访问外部mysql都会用到service
RC、RS和Deployment只是保证了支撑服务的微服务Pod的数量，但是没有解决如何访问这些服务的问题。一个Pod只是一个运行服务的实例，随时可能在一个节点上停止，在另一个节点以一个新的IP启动一个新的Pod，因此不能以确定的IP和端口号提供服务。要稳定地提供服务需要服务发现和负载均衡能力。服务发现完成的工作，是针对客户端访问的服务，找到对应的的后端服务实例。在K8s集群中，客户端需要访问的服务就是Service对象。每个Service会对应一个集群内部有效的虚拟IP，集群内部通过虚拟IP访问一个服务。在K8s集群中微服务的负载均衡是由Kube-proxy实现的。Kube-proxy是K8s集群内部的负载均衡器。它是一个分布式代理服务器，在K8s的每个节点上都有一个；这一设计体现了它的伸缩性优势，需要访问服务的节点越多，提供负载均衡能力的Kube-proxy就越多，高可用节点也随之增多。与之相比，我们平时在服务器端做个反向代理做负载均衡，还要进一步解决反向代理的负载均衡和高可用问题。
任务（Job）：批处理
Job是K8s用来控制批处理型任务的API对象。批处理业务与长期伺服业务的主要区别是批处理业务的运行有头有尾，而长期伺服业务在用户不停止的情况下永远运行。Job管理的Pod根据用户的设置把任务成功完成就自动退出了。成功完成的标志根据不同的spec.completions策略而不同：单Pod型任务有一个Pod成功就标志完成；定数成功型任务保证有N个任务全部成功；工作队列型任务根据应用确认的全局成功而标志成

定时任务（CronJob）

后台支撑服务集（DaemonSet）：每个node都有该任务
长期伺服型和批处理型服务的核心在业务应用，可能有些节点运行多个同类业务的Pod，有些节点上又没有这类Pod运行；而后台支撑型服务的核心关注点在K8s集群中的节点（物理机或虚拟机），要保证每个节点上都有一个此类Pod运行。节点可能是所有集群节点也可能是通过nodeSelector选定的一些特定节点。典型的后台支撑型服务包括，存储，日志和监控等在每个节点上支持K8s集群运行的服务。


持久存储卷（Persistent Volume，PV）和持久存储卷声明（Persistent Volume Claim，PVC）
pv: 存储的提供者。pvc: 使用
PV和PVC使得K8s集群具备了存储的逻辑抽象能力，使得在配置Pod的逻辑里可以忽略对实际后台存储技术的配置，而把这项配置的工作交给PV的配置者，即集群的管理者。存储的PV和PVC的这种关系，跟计算的Node和Pod的关系是非常类似的；PV和Node是资源的提供者，根据集群的基础设施变化而变化，由K8s集群管理员配置；而PVC和Pod是资源的使用者，根据业务服务的需求变化而变化，有K8s集群的使用者即服务的管理员来配置。

节点（Node）
K8s集群中的计算能力由Node提供，最初Node称为服务节点Minion，后来改名为Node。K8s集群中的Node也就等同于Mesos集群中的Slave节点，是所有Pod运行所在的工作主机，可以是物理机也可以是虚拟机。不论是物理机还是虚拟机，工作主机的统一特征是上面要运行kubelet管理节点上运行的容器。

密钥对象（Secret）
Secret是用来保存和传递密码、密钥、认证凭证这些敏感信息的对象。使用Secret的好处是可以避免把敏感信息明文写在配置文件里。在K8s集群中配置和使用服务不可避免的要用到各种敏感信息实现登录、认证等功能，例如访问AWS存储的用户名密码。为了避免将类似的敏感信息明文写在所有需要使用的配置文件中，可以将这些信息存入一个Secret对象，而在配置文件中通过Secret对象引用这些敏感信息。这种方式的好处包括：意图明确，避免重复，减少暴漏机会。

InitContainer：
处理pod的初始化工作的容器

ingress controller: 将客户端请求直接转发到service对应的后端pod。7层。在每个node启动ingress的daemonSet。替换nodeIP+servicePort。
```

基于docker运行k8s
```
https://www.kubernetes.org.cn/doc-5


yamls

apiVersion: v1
kind: ConfigMap
metadata:
  name: hto-common-env-cm
  namespace: chuan-prod
data:
  port: "7685"
  configPath: ./conf/config.yaml
---
apiVersion: v1
kind: ConfigMap
metadata:
  name: hto-config-file
  namespace: chuan-prod
data:
  config.yaml: |
	debug: true
---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: hto-common
  namespace: chuan-prod
spec:
  selector:
    matchLabels:
      app: hto-common
  replicas: 1
  template:
    metadata:
      labels:
        app: hto-common
    spec:
      containers:
        - name: hto-common
          image: <hto-common_image>  # 部署时替换
          imagePullPolicy: IfNotPresent
          command: [ "./hto" ]
          workingDir: /app
          ports:
            - containerPort: 7685
          envFrom:
            - configMapRef:
                name: hto-common-env-cm
          volumeMounts:
            - name: hto-config-file
              mountPath: /app/conf

          readinessProbe:     # 就绪探针
            initialDelaySeconds: 20       # 容器启动后要等待多少秒后存活和就绪探测器才被初始化，默认是 0 秒，最小值是 0。
            periodSeconds: 5              # 执行探测的时间间隔（单位是秒）。默认是 10 秒。最小值是 1。
            timeoutSeconds: 10            # 探测的超时后等待多少秒。默认值是 1 秒。最小值是 1。
            successThreshold: 1           # 探测器在失败后，被视为成功的最小连续成功数。默认值是 1。 存活和启动探测的这个值必须是 1。最小值是 1。
            failureThreshold: 5           # 当探测失败时，Kubernetes 的重试次数。 存活探测情况下的放弃就意味着重新启动容器。 就绪探测情况下的放弃 Pod 会被打上未就绪的标签。默认值是 3。最小值是 1
            tcpSocket:
              port: 7685
            
          livenessProbe:    # 存活探针
            initialDelaySeconds: 40
            periodSeconds: 5
            timeoutSeconds: 5
            failureThreshold: 3
            tcpSocket:
              port: 7685

      volumes:
        - name: hto-config-file
          configMap:
            name: hto-config-file
            items:
              - key: config.yaml
                path: config.yaml
      imagePullSecrets:
        - name: tssl-prod    # 私有镜像仓库，需提前创建secret
```


- php
```
1. 问一个解题思路？
2. linux下如何安装一个redis扩展，具体步骤？
3. 有没有做过php本身相关的项目，事情？php业务开发过程中遇到过的比较难问题？
```

- golang
```
0. 中级golang开发者知识点：https://gobyexample.com/
1. golang知识图谱 https://github.com/gocn/knowledge
2. GOROOT ，GOPATH, PATH
	GOROOT: go安装包根目录
	PATH = $GOROOT/bin
	GOPATH: go的工作目录 $gopath/src,$gopath/pkg,$gopath/bin
3. go执行过程
4. interface与反射
	reflect.TypeOf reflect.ValueOf,类型强转
5. 常用包
	文件读取 os.OpenFile
	时间日期 time.Time().Unix()
	json解析，
	字符串处理，正则处理，锁与sync包，网络处理，国际化
	
6. 进阶 
	GPM模型，内存布局，CGO，反射，内存管理，GC，go调度，channel调度,Go编译共享库so
7. 面试题
	1. https://blog.csdn.net/yuanqwe123/article/details/81737180
	2. https://blog.csdn.net/itcastcpp/article/details/80462619
	
8. 数组:
定义：var a1 [5]int, a1:= [...]int{}

9. slice：
定义: var s1 []string, s1 := []string{"foo","bar"}
增加k,v s1=append(s1, v)
删除i: s1 = append(s1[:i], s1[i+1:]...)
遍历slice：
for i,v := range s1 {

}
长度： len(s1)
容量：cap(s2)
问题1：slice如何增加一个元素，删除一个元素

10. map：
定义： m1 := make(map[string]string)
增加k,v m1["foo"] = bar
删除v delete(m1, "foo")
判断k存在 value, ok := m1["foo"]
遍历map: 
for k,v := range m1 {

}
问题1：如何判断键是否存在？

11. 包：
一个目录下只能有一个包名
目录名称可以和包名不同
不同的二个目录可以有相同的包名 - 非常不推荐

import 基于src目录，具体跟的是文件夹路径

12. go不用去关心分配在堆上还是栈上

13. go仅支持封装，不支持继承和多态

14. 可变参数的获取，通过range遍历参数

15. go get 和 go install 区别
	go get -x
	1. 下载代码 GOPATH/src/<input-package>
	2. 编译,生成.a
	3. 安装,生成.exe
	go install library
	1. 编译,生成.a
	2. 安装,生成.exe

16. GPM 模型怎么样的
17. 内存回收机制？如何监控结构体的内存空出来了？ 
	三色，引用计数，达到内存阈值，stop the world
18. 队列出现饥饿情况怎么办？
19. goroutine的调度机制，如果P一直抢占了M 怎么办？

1. make(chan struct{}) struct{}空结构体，长度为0，用于消息通知
3. 多个goroutine同时访问一个map, 会出现致命错误，fatal error。数据同步问题要加锁，锁颗粒要越小越好。
4. 如何分析死锁？
	使用debug.printStack()打印goroutine的堆栈信息，看goroutine运行时长
5. 如何分析资源竞争？
5. 闭包：匿名函数 + 数据 一起封装了
6、make(chan int) 与 make(chan int, 1) 区别，后者第一个goroutine不会阻塞
7、队列出现饥饿情况怎么办？
从其他p拿取goroutine和全局队列中拿取
8、goroutine的调度机制，如果P一直抢占了M 怎么办？
检测占用时间

golang标准包：
bufio: 普通io封装成带缓冲io，可以按行读取与写入
bytes: 封装对[]byte的操作
archive,compress: 归档和压缩
container
	heap: 比如数组实现len,swap,push,pop操作后，就可以使用heap.Init,构建最大堆，最小堆，优先级堆
	list: 封装了列表
	ring: 封装了环
context: 上下文。用于协程之间或者方法之间取消，超时取消，传递k-v
crypto
	hmac:hamc算法看做是加盐的hash算法（加盐是将一个随机字符串放在需要加密的密文前面或者后面，然后对这个拼接后的密文进行加密得到hash值）。但它们的加密原理肯定不一样，虽然达到的效果是一样的，都是对密文混入一个第三方值，然后得到一个hash值。
	sha256Hash := sha256.New()
	sha256Hash.Write([]byte("hello world"))
	fmt.Printf("%x\n", sha256Hash.Sum(nil))
	fmt.Printf("%x\n", sha256Hash.Sum([]byte("!")))

	hmacHash := hmac.New(sha256.New, nil)
	hmacHash.Write([]byte("hello world"))
	fmt.Printf("%x\n", hmacHash.Sum(nil))
	fmt.Printf("%x\n", hmacHash.Sum([]byte("!")))

	b94d27b9934d3e08a52e52d7da7dabfac484efe37a5380ee9088f7ace2efcde9
	21b94d27b9934d3e08a52e52d7da7dabfac484efe37a5380ee9088f7ace2efcde9
	c2ea634c993f050482b4e6243224087f7c23bdd3c07ab1a45e9a21c62fad994e
	21c2ea634c993f050482b4e6243224087f7c23bdd3c07ab1a45e9a21c62fad994e
	write()函数往hash块写数据，sum()函数往hash结果前加前缀
embed：
	读取文件中内容到变量
	//go:embed version.txt
	var version string
	func main() {
		fmt.Printf("version %q\n", version)
	}
encoding:
	base64:
		msg := "Hello, 世界"
		encoded := base64.StdEncoding.EncodeToString([]byte(msg))
	json:
	hex
	binary:大端，小端序
errors:
	wraps():包裹错误
	is():判断二个错误是否相等
	as():将一个错误转成另一个错误
flag:
	处理命令行参数
fmt:
	标准输入包
html.template:
	s := `<script>alter("xss")</script>`
	es := html.EscapeString(s)
	t.Log(es)
	t.Log(html.UnescapeString(es))
	预防xss注入
io: 将磁盘读入内存，内存写入磁盘
ioutil:读取文件或者目录的工具方法，ReadDir(),ReadFile()
http: client, request, response核心结构体。response := client.DO(request) 
	values.add(key1, value1), values.encode()
	header, handler,url.Values，URL结构体
	http.Client{
		&http.Transport{
			DialContext: (&net.Dialer{
			Timeout:   30 * time.Second, // 连接超时时间
			KeepAlive: 60 * time.Second, // 保持长连接的时间
		}).DialContext, // 设置连接的参数
		MaxIdleConns:          500, // 最大空闲连接
		IdleConnTimeout:       60 * time.Second, // 空闲连接的超时时间
		ExpectContinueTimeout: 30 * time.Second, // 等待服务第一个响应的超时时间
		MaxIdleConnsPerHost:   100, // 每个host保持的空闲连接数
		}
	}
	Transport的主要功能:
	底层是一个连接池,缓存了长连接，用于大量http请求场景下的连接复用
net:
	l, err := net.Listen("tcp", ":8088")
	if err != nil {
		log.Fatal(err)
	}
	for {
		// 等待下一个连接,如果没有连接,l.Accept会阻塞
		conn, err := l.Accept()
		// conn 为三次握手的连接
	}
os:
	File，Dir核心结构体
path：处理文件系统
plugin:应用场景,编译出so文件
	1.通过plugin我们可以很方便的对于不同功能加载相应的模块并调用相关的模块;
	2.针对不同语言(英文,汉语,德语……)加载不同的语言so文件,进行不同的输出;
	3.编译出的文件给不同的编程语言用(如：c/java/python/lua等).
	4.需要加密的核心算法,核心业务逻辑可以可以编译成plugin插件
	5.黑客预留的后门backdoor可以使用plugin:
	6.函数集动态加载
reflect:
	变量
	1.reflect.Valueof() reflect.Typeof()
regexp:
	1.正则
	Compile:最左最短，会返回error
	CompilePOSIX：最左最长
	MustCompile:最左最短，不会返回error
runtime:
	1.runtime.GC()
	2.runtime.NumCPU():逻辑CPU数量
	3.runtime.GOMAXPROCS():设置P数量
	4.runtime.Gosched():让出调度
sort:
	基础结构实现swap(),len(),就可以对struct进行排序
strconv:
	将字符串转换成其他类型。其他类型转成string，调用string()
strings:
	字符串的工具方法集合
sync:
	map,mutex,rwmutex,once,pool,waitgroup
atomic:
	int32,int64,uint32,uint64,uintptr,unsafe.Pointer原子操作，进行增减，比较交换
time:
	Duration,Location,Ticker,Timer核心结构体
unicode:
	utf8编码
unsafe:
	Pointer, uintptr区别
范型：
	不同类型的业务执行逻辑是一样的，才引出范型
	查看3176890972-62448cded247e_fix732.png
	声明时 声明行参类型
	调用时 指定类型
单元测试：
	1、面向interface{},解除依赖
	2、打桩
	3、表单测试框架
模糊测试：
	在单元测试里，因为测试输入是固定的，你可以知道调用Reverse函数后每个输入字符串得到的反转字符串应该是什么，然后在单元测试的代码里判断Reverse的执行结果是否和预期相符。例如，对于测试用例Reverse("Hello, world")，单元测试预期的结果是 "dlrow ,olleH"。

	但是使用fuzzing时，我们没办法预期输出结果是什么，因为测试的输入除了我们代码里指定的用例之外，还有fuzzing随机生成的。对于随机生成的测试输入，我们当然没办法提前知道输出结果是什么。
```

- 分布式框架
```
go-zero
0、nginx作为对外统一网关
	auth_request /auth
	auth_request_set $user $upstream_http_x_user 
	将需要健全请求进行鉴权
1、api：向各个rpc请求，聚合结果。
2、rpc：真正实现逻辑
3、etcd：作为服务注册中心
4、prometheus + grafana: 分布式监控
5、jaega: 分布式链路追踪
6、dtm: saga分布式事物。dtm是一个全局事物管理，先生成一个全局事务id给dtm，由dtm调用各个子事务，如果各个子事务返回成功，全局事务也会完成。
如果其中一个子事务失败了，其他事务进行补偿回滚。全局事务失败。
saga事务：正向操作与逆向操作（回滚操作）
tcc事务：相比较saga事务，多了一步try（锁定资源），commit（正向操作），cancel（回滚操作）
		try，commit，cancel是由dtm管理器调用。
		由api向dtm注册全局事务，并向微服务1，2发起try请求
		如果try发生失败，dtm发起回滚全局事务。dtm会调用服务1的cancel方法
		commit，cancel失败则dtm管理器进行重试，达到最终一致，重试3次人工介入
		https://dtm.pub/practice/tcc.html#%E5%A4%B1%E8%B4%A5%E5%9B%9E%E6%BB%9A
	
tcc模式下：
	空回滚：微服务没有收到try请求，收到了cancel请求。微服务要保证正常。
	空悬挂：由于网络原因，微服务先收到cancel请求再收到try请求。微服务要保证正常。try相当于把资源锁定，悬挂起来
	幂等：微服务try，commit,cancel请求，允许重复请求不出错。

为了实现空回滚、防止业务悬挂，以及幂等性要求。我们必须在数据库记录冻结金额的同时，记录当前事务id和执行状态，为此我们设计了一张表：


CREATE TABLE `account_freeze_tbl` (
  `xid` varchar(128) NOT NULL COMMENT '事务id',
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户id',
  `freeze_money` int(11) unsigned DEFAULT '0' COMMENT '冻结金额',
  `state` int(1) DEFAULT NULL COMMENT '事务状态，0:try，1:confirm，2:cancel',
  PRIMARY KEY (`xid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

Try业务
记录冻结金额和事务状态0到account_freeze表
扣减account表可用金额
Confirm业务
根据xid删除account_freeze表的冻结记录(因为如果一个事务confirm那么记录就没有意义了)
Cancel业务
修改account_freeze表，冻结金额为0，state为2
修改account表，恢复可用金额
如何判断是否空回滚
cancel业务中，根据xid查询account_freeze，如果为null则说明try还没做，需要空回滚
如何避免业务悬挂
try业务中，根据xid查询account_freeze ，如果已经存在则证明Cancel已经执行，拒绝执行try业务

7、接口幂等性：一个接口，多次发出同一个请求，必须保证操作只执行一次
7.1、token机制
功能上允许重复提交,但要保证重复提交不产生副作用,比如点击n次只产生一条记录,具体实现就是进入页面时申请一个token,然后后面所有的请求都带上这个token,后端根据token来避免重复请求。
token存放在redis中
接口每次要先获取一下token
也可以由前端自动产生一个token
7.2、利用业务上存在业务id，可以使用mysql唯一索引，主键唯一
7.3、状态机：来了一个上一个状态的变更，理论上是不能够变更的。

8、分布式锁
排他性

锁的基本特性，并且只能被第一个持有者持有。

防死锁

高并发场景下临界资源一旦发生死锁非常难以排查，通常可以通过设置超时时间到期自动释放锁来规避。

可重入

锁持有者支持可重入，防止锁持有者再次重入时锁被超时释放。

高性能高可用

锁是代码运行的关键前置节点，一旦不可用则业务直接就报故障了。高并发场景下，高性能高可用是基本要求。


1、利用mysql
2、利用redis setnx 适合高频次持锁时间短的抢锁场景，适合在高并发场景下，用来争抢一些“唯一”的资源。不阻塞，可以使用重试机制，重试加锁
	锁key
	-- ARGV[1]: 锁value,随机字符串
	-- ARGV[2]: 过期时间
	-- 判断锁key持有的value是否等于传入的value
	-- 如果相等说明是再次获取锁并更新获取时间，防止重入时过期
	-- 这里说明是“可重入锁”
3、zookeeper或者etcd能否写入节点，进行加锁。通过一致性协议保证数据可靠性，较低的吞吐量和较高的延迟。
```

golang设计模式
```
https://juejin.cn/post/7095581880200167432
设计模式的“道”

23种设计模式 “术”
开闭原则：对系统进行扩展，而无需修改现有的代码
里氏替换原则：任何基类可以出现的地方，子类一定可以出现。
依赖倒置原则：面向接口编程，抽象不应该依赖于具体类，具体类应当依赖于抽象。
单一职责原则：一个类应该只有一个发生变化的原因。
最少知道原则：一个实体应当尽量少地与其他实体之间发生相互作用。
接口分离原则：使用多个专门的接口，而不使用高耦合的单一接口。

// 单例实例
type singleton struct {
  Value int
}
// 构造方法，用于获取单例模式对象
func GetInstance(v int) Singleton {
  once.Do(func() {
    instance = &singleton{Value: v}
  })

  return instance
}

```

- 算法
```
1. 二叉树的时间复杂度是多少 O(n*lgn)
2. 一千万条数据，找到top100的数据？排序。（快排和堆排序）
3. 10亿条数据中，查找一个存不存在数据。hash O（1），布隆过滤器
布隆过滤器：https://www.jianshu.com/p/2104d11ee0a2
通常你判断某个元素是否存在用的是什么？应该蛮多人回答 HashMap 吧，确实可以将值映射到 HashMap 的 Key，然后可以在 O(1) 的时间复杂度内返回结果，效率奇高。但是 HashMap 的实现也有缺点，例如存储容量占比高，考虑到负载因子的存在，通常空间是不能被用满的，而一旦你的值很多例如上亿的时候，那 HashMap 占据的内存大小就变得很可观了。
4. 广度搜索 与 深度搜索 怎么弄？前序遍历 + 队列，中序遍历 + 栈
```
- 算法问题
```
旅行家问题：从起点城市到终点城市。
解法：
1. 要找到经过最少城市节点，使用图的广度搜索
树也是图的特殊一种情况。广度搜索使用队列数据结构。
2. 要找到最短时间或者最短路径到终点。是带权边的图
使用迪杰斯特拉算法。图的广度搜索同时，不断刷新从一个节点到另一个节点的权重。
2.1 不能有环
2.2 不能有负权边，有使用贝曼算法

集合覆盖问题：广播覆盖区域有重叠，找到最大覆盖面积的最少广播台。
教室排课问题：一个课堂最大利用率，每节课有时间段。贪婪算法：上一堂结束后，下一堂课才开始。
解法：
1. 最优解，要遍历所有情况，耗费时间最久。
2. 使用近似算法。贪婪算法是近似算法一种。
2.1 贪婪算法每次找局部的最优解。注意局部最优解不是全局最优解，所以是一种近似算法。

背包问题：4磅的背包装物体，求装的物体价值最大。
最长子串，最长公共子序列：二个字符串相似程度。
解法：
动态规划：问题进行分割。状态转移方程：上一个值 vs （当前物品价值 + 剩余空间能容纳的最大价值）
解动态规划问题的步骤：
1.找出状态转移方程
2.设计自顶而下的递归算法 （Top-down approach）
3.改写成自底而上的迭代算法（Bottom-up approach）
缺陷：
1. 物品要么拿要么不拿走
2. 物品不能是连续，如果连续可以使用贪婪算法。

推荐算法：根据已有的特征推荐给他类似的内容。将他进行分类，分组。
解法：
将他的特征抽离，根据距离公式，最近的k个人是在哪个分组，则把他分入改组。
```

- 职业生涯
```
1. 处于什么目的离职
```

- 剑指offer
```
面试形式
1、电话面试
	一定要大胆向面试官多提问，直到弄清面试官意图为止
2、远程桌面面试
	思考清楚再开始编码
	能够进行单元测试
3、现场面试
	5轮面试可以准备饮料
	
	行为面试：
		参照过往经验。性格特点，不问技术难题，暖场。
		1分钟介绍主要学习、工作经历
		项目简历如何写？
			采用STAR模型。
			S：项目背景
			T：自己完成的任务。参与，负责
			A：为完成任务自己做了哪些工作，是怎么做的
			R：自己的贡献
		面试官追问问题：
			1、项目中碰到最大问题是什么，怎么解决
			2、从这个项目中学到了什么？
		简历上有项目背景，突出介绍自己完成的工作以及取得的成绩
		应聘者掌握的技能
			1、了解：没做过实际项目，熟悉：做过实际项目，精通
		准备“为什么跳槽”
			了解应聘者性格。
			避免以下4个原因
				1、老板苛刻
				2、同事难想处
				3、加班
				4、工资低。面试不是谈工资的时候
	技术面试：现场写代码，技术问题。简历中技术点很透彻
		1、扎实的基础知识
			编程语言
			数据结构
				链表，树，栈，队列，哈希表。链表，二叉树是重点
			算法
		2、高质量的代码
			注重边界条件和特殊输入，具有鲁棒的程序
		3、分析问题思路清晰
			举例子让自己理解
			使用画图
		4、优化时间和空间效率
		5、学习沟通能力
			面试过程中主动询问，弄清楚题目表现自己沟通能力
			面试官不会喜欢高傲或者轻视合作
			知识迁移。前面的问题为后面问题准备
	应聘者提问：准备几个问题
		不要问薪水，问结果
		问跟岗位相关问题

```

- 面试题目
```
注意减少时间复杂度，一般O（n2）无法获得offer
1、singleton 单例
2、数组中重复的数字。哈希表
3、链表。链表20行代码就能实现，适合面试
4、从尾到头打印链表。使用栈

```

- 回答语句
```
当清楚：它应该是xxxx
当不确定：这点不太确定，但凭我的理解我想说说看
当完全不清楚：这点不太清楚，说不上来

```



