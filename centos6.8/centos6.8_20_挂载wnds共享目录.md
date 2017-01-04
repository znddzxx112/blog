##### windows新建共享目录
```
在相应的目录右键->属性->共享文件
如文件夹basecode
```

##### centos新建挂载点并挂载
```
# id xxx //获取uid，gid
# mount -t cifs -o username=xxx,password=xxx,uid=0,gid=0,rw //192.168.1.120/basecode /var/www/basecode
```

##### 卸载挂载点
```
# umount //192.168.1.120/basecode
```

##### 编写mount.sh脚本
```
# vim mount.sh

#! /bin/bash

umount //192.168.1.120/basecode

sleep 5

mount -t cifs -o username=xxx,password=xxx,uid=0,gid=0,rw //192.168.1.120/basecode /var/www/basecode

# chmod 755 mount.sh
```
