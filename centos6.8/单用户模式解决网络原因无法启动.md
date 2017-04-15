- 进入单用户模式
```
# 启动centos,按下e，进入grud菜单界面
# 选中linux kernel,按下e
# 输入 空格 single 然后按下回车，再按esc
# 按下b，继续boot引导系统
```

- 如果需要修改root密码
- 在单用户模式下
```
# passwd root 即可
```

- 虚拟机网卡的网卡设置新的mac地址
```
 Edit virtual machine settings-->Hardware-->Network Adapter-->Advanced..(右侧)-->Mac Address(为新的虚拟网卡的MAC)
 
 ```
 
 - 在单用户模式中完成以下操作
 ```
 1. 删除 /etc/udev/rules.d/70-persistent-net.rules

2. 删除 /etc/sysconfig/network-scripts/ifcfg-eth0 （做好备份）

3. 重新启动服务器，然后重建ifcfg-eth0（使用新的mac address）
 ```
 
 - 配置ip地址（重建ip地址）
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

- 如果因为rc.local造成重启不了
```
#在单用户模式下直接修改/etc/rc.d/rc.local即可
```
