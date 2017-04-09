- 创建指定用户组和家目录的不可登录的用户
```
mkdir -p /home/wenjingjing
useradd -d /var/wenjingjing -g www -s /sbin/nologin wenjingjing
```

- 创建组
```
# groupadd wenjia
```

- 修改用户主组，离开其他组
```
# usermod -g www wenjingjing
```

- 向组增加组员,不离开当前组（增加副组）
```
# usermod -a -G wenjia wenjingjing
```

- 新的家目录
```
# usermod -d /home/wenjingjing wenjingjing
```

- 新的登录shell
```
# usermod -s /bin/bash wenjingjing
```
