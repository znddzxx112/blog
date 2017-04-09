- 客户端ssh登录
- getty判断客户端输入的用户名和密码
- login 或者 nologin
- login后使用具体bash 如/bin/bash
- 读取/etc/profile全局的shell
```
会去读取/etc/profile.d/*.sh文件
如：/etc/profile.d/lang.sh去读取系统语系
```
- 读取个人的~/.bash_profile
```
会去执行 . .bashrc
```


- bashrc模版
```
位置在/etc/skel/.bashrc
```
