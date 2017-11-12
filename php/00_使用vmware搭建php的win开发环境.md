- 安装vmtools,在宿主机中执行
```
mount /dev/cdrom /mnt/cdrom
cd /mnt/cdrom
cp /mnt/cdrom/vm-tools.tar.bz /usr/local/src/
tar -zxvf vm-tools.tar.bz
cd vmware-tools-distrib/
./vmware-install.pl --default
/etc/vmware-tools/services.sh start
```

- 映射共享目录

```
 mount -t vmhgfs .host:/basecode /mnt/hgfs/
虚拟机设置文件夹共享目录
```

- nginx配置,root指定/mnt/hgfs
```
location ~ \.php$ {
            root           /mnt/hgfs/basecode;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        } 
```
