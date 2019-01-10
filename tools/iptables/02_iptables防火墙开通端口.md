###### 配置防火墙端口

```
# vi /etc/sysconfig/iptables
// 开启80端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
// 开启3306端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT 
// 开启21端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 21 -j ACCEPT
// 开启被动接口
-A OUTPUT -p tcp --sport 4000:5000 -j ACCEPT
-A INPUT -p tcp --dport 4000:5000 -j ACCEPT
// 重启防火墙
# service iptables restart
```
