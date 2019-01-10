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