- 创建指定用户组和家目录的不可登录的用户
```
mkdir -p /home/tt
useradd -d /var/tt -g www -s /sbin/nologin tt
```

- 创建家目录和制定使用的shell
```
mkdir -p /home/tt
useradd -d /home/tt -s /bin/bash tt
```

- 不允许登录没有家目录并制定用户组
```
useradd -M -s /sbin/nologin -g www www
```

- 参数说明
```
-d 指定家目录位置
-M 不指定家目录
-s 指定使用的shell
-g 指定使用的用户组

```
