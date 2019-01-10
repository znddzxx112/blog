- 设计目的
```
从内核出发，高效率解决ip/网络，服务，端口
有filter表（本机进出）,net表（本机当路由时），默认filter表
```

- 查看方法
```
# iptables -L
# vim /etc/sysconfig/iptables
或者
# iptables-save
```

- 修改方法一
```
# vim /etc/sysconfig/iptables
:INPUT ACCEPT [0:0]
:FORWARD ACCEPT [0:0]
:OUTPUT ACCEPT [0:0]
-A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
-A INPUT -p icmp -j ACCEPT
-A INPUT -i lo -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 22 -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT
-A INPUT -j REJECT --reject-with icmp-host-prohibited
-A FORWARD -j REJECT --reject-with icmp-host-prohibited
COMMIT
# service iptables restart
```

- 修改方法二
```
增加一个端口开发
# iptables -A INPUT -m state --stat New -p tcp --dport 1218 -j ACCEPT
# /etc/init.d/iptables save //把临时的修改，持久化,可以在/etc/sysconfig/iptables中查看
```
