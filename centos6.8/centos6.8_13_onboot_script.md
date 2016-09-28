#### centos6.8服务器配置-开机启动脚本制作

##### 编写sh文件

```
# cd /etc/init.d/
# vi testbitcaoauto.sh 
#!/bin/sh

#add for chkconfig
#chkconfig: 2345 70 30
#description: the description of the shell
#processname: testbitcaoauto

status() {
        echo -n "hello"
        echo "wold"
}

echo "okok"

case "$1" in
    status)
        status
    ;;
esac

```

##### 设置开机启动

```
# chkconfig --add testbitcaoauto.sh
# chkconfig --level 345 testbitcaoauto.sh on
# chkconfig --list testbitcaoauto.sh 
# chmod +x testbitcaoauto.sh 
# service testbitcaoauto.sh status
```
