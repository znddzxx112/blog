#### centos6.8服务器配置-公钥登录

- 参考文章:http://jingyan.baidu.com/article/e5c39bf5ba78e639d760330e.html

##### 生成公私钥 【参考其他博客命令】


##### 服务器上

```
# vi /etc/ssh/sshd_config
PubkeyAuthentication  yes  #启用PublicKey认证。

AuthorizedKeysFile       .ssh/authorized_keys  #PublicKey文件路径。

PasswordAuthentication  no  #不适用密码认证登录。

# service sshd restart
```

###### 在你需要的登录的用户家目录的.ssh目录下，编辑authorized_keys文件，将开始我们生成密钥对的公钥写到这个文件中

```
# mkdir ./.ssh
# cd ./.ssh
// 将公钥复制进来
# vi authorized_keys
# chmod 600 /home/sshcao/.ssh/authorized_keys
```

- 可以给每位用户都使用ssh只要在家目录.ssh添加authorized即可
- 密钥替换明文密码给其他人
- 定期更换密钥，公钥保证服务器安全
