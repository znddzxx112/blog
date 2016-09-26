#### vsftp

- 参考文章：http://blog.rekfan.com/articles/264.html
- 参考文章：http://www.jb51.net/article/47795.htm

##### 传文件的几种方式
- scp 利用ssh传文件
- ftp 

##### 判断是否安装

```
# rpm -qa | grep vsftpd
```

##### 安装

```
# yum -y  install vsftpd
```

##### 配置防火墙

```
# vi /etc/sysconfig/iptables
// 开启21端口
-A INPUT -m state --state NEW -m tcp -p tcp --dport 21 -j ACCEPT
// 开启被动接口
-A OUTPUT -p tcp --sport 4000:5000 -j ACCEPT
-A INPUT -p tcp --dport 4000:5000 -j ACCEPT
// 重启防火墙
# service iptables restart

```

- 前提关闭 selinux

##### 配置文件-增加vsftp用户

- /etc/vsftpd/vsftpd.conf 主配置文件

- /etc/vsftpd/ftpusers 指定哪些用户不能访问FTP服务器

- /etc/vsftpd/user_list 文件中指定的用户是否可以访问ftp服务器由vsftpd.conf文件中的userlist_deny的取值来决定。 

```
# groupadd www
// 设置不可切换
// 建议只允许www为上传代码，apache设置user,group为www
# useradd www -d /usr/local/src/bitcao -s /sbin/nologin -g www
# passwd www //设置登录密码
# chown -R bitcao:www /usr/local/src/bitcao

// 设置软链接，上传代码处连接此处
# ln -s /usr/local/httpd/htdocs/ /usr/local/src/bitcao/

 // 修改vsftpd配置文件 
# vi /etc/vsftpd/vsftpd.conf   

// 不允许匿名登录
annoymous_enable=no

// 最底下增加三条
tcp_wrappers=YES
pasv_enable=yes
pasv_min_port=4000
pasv_max_port=5000
userlist_deny=no // 设立能登录的白名单，最底下增加
//写上能登录的名单
# vi /etc/vsftpd/user_list

// 所有用户不能切换 
chroot_list_enable = yes
# vi chroot_list
www // 写上www不能出根目录

// 加上硬链接
# ln  /usr/local/src/* /home/www/
```

##### 限制连接ip(尚未实践)

```
# vi /etc/vsftpd/vsftpd.conf  
tcp_wrappers=yes    // 限制ip地址
# vi /etc/hosts.deny    // 限制
vsfpd:all:deny
# vi /etc/hosts.allow
vsfpd:192.168.1.*:Allow
```

##### 服务启动与自启动

```
# service vsftpd start
# chkconfig --level 345 vsftpd on
# chkconfig --list vsftpd
```

##### 卸载vsftpd

```
# rpm -qa|grep vsftpd
# rpm -e vsftpd
```

##### 知识点 - 配置文件详解

```
# cd /etc/vsftpd/vsftpd.conf 这就是vsftpd的核心配置文件

anonymous_enable=YES/no 是否允许匿名用户登录

anonymous_enable=yes/no 是否允许匿名上传文件

local_enable= YES/no 是否允许本地用户登录

write_enable= YES/no 是否允许本地用户上传

guest_enable=yes/no 是否允许虚拟用户登录;

local_mask=022 设置本地用户的文件生成掩码为022,默认值为077

dirmessage_enable= YES 设置切换到目录时显示.message隐含文件的内容

xferlog_enable= YES 激活上传和下载日志

connect_from_port_20=YES 启用FTP数据端口连接

pam_service_name=vsftpd 设置PAM认证服务的配置文件名称, 该文件存放在/etc/pam.d目录下

userlist_enable= YES 允许vsftpd.user_list文件中的用户访问服务器

userlist_deny= YES 拒绝vsftpd.user_list文件中的用户访问服务器

listen= YES/no 是否使用独占启动方式(这一项比较重要)

tcp_wrappers= YES/no 是否使用tcp_wrappers作为主机访问控制方式

最主要的就是这些设置了。(这是一般都是默认的不是太懂的不要动)

大家可以设置下面的设置:

ftpd_banner=welcome to ftp service 设置连接服务器后的欢迎信息

idle_session_timeout=60 限制远程的客户机连接后，所建立的控制连接，在多长时间没有做任何的操作就会中断(秒)

data_connection_timeout=120 设置客户机在进行数据传输时,设置空闲的数据中断时间

accept_timeout=60 设置在多长时间后自动建立连接

connect_timeout=60 设置数据连接的最大激活时间，多长时间断开，为别人所使用;

max_clients=200 指明服务器总的客户并发连接数为200

max_per_ip=3 指明每个客户机的最大连接数为3

local_max_rate=50000(50kbytes/sec)

anon_max_rate=30000 设置本地用户和匿名用户的最大传输速率限制

pasv_min_port=端口

pasv-max-prot=端口号 定义最大与最小端口，为0表示任意端口;为客户端连接指明端口;

listen_address=IP地址 设置ftp服务来监听的地址，客户端可以用哪个地址来连接;

listen_port=端口号 设置FTP工作的端口号，默认的为21

chroot_local_user=YES 设置所有的本地用户可以chroot

chroot_local_user=NO 设置指定用户能够chroot

chroot_list_enable=YES

chroot_list_file=/etc/vsftpd.chroot_list(只有/etc/vsftpd.chroot_list中的指定的用户才能执行 )

local_root=path 无论哪个用户都能登录的用户，定义登录帐号的主目录, 若没有指定，则每一个用户则进入到个人用户主目录;

chroot_local_user=yes/no 是否锁定本地系统帐号用户主目录(所有);锁定后，用户只能访问用户的主目录/home/user,不能利用cd命令向上转;只能向下;

chroot_list_enable=yes/no 锁定指定文件中用户的主目录(部分),文件：/chroot_list_file=path 中指定;

userlist_enable=YES/NO 是否加载用户列表文件;

userlist_deny=YES 表示上面所加载的用户是否允许拒绝登录;

userlist_file=/etc/vsftpd.user_list 列表文件

这些就是高级设置了。大家可以适当的更改。

#vi /etc/hosts.allow

vsftpd:192.168.5.128:DENY 设置该IP地址不可以访问ftp服务(vsftpd在独占启动方式下支持tcp_wrappers主机访问控制方式)

时间限制：

#cp /usr/share/doc/vsftpd-1.1.3/vsftpd.xinetd /etc/xinetd.d/vsftpd

#vi /etc/xinetd.d/vsftpd/

修改 disable = no

access_time = hour:min-hour:min (添加配置访问的时间限制(注：与vsftpd.conf中listen=NO相对应)

例: access_time = 8:30-11:30 17:30-21:30 表示只有这两个时间段可以访问ftp 
```



