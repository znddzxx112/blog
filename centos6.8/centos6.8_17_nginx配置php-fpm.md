##### nginx配置php-fpm

```
# vim /usr/local/nginx/conf/nginx.conf
user nobody
location ~ \.php$ {
            root           /var/www/;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }

# nginx -s reload
```

```

文件夹共享
// 安装samba
# yum install samba system-config-samba samba-client samba-common
// 检查是否安装samba
# rpm -q samba

// windows设置共享文件夹,明确用户和密码

// 挂载目录
# mkdir /var/www/vmshare
# mount -t cifs -o username=ckl,password=123456,gid=500,uid=500 //192.168.1.120/vmshare /var/www/vmshare
```
