
- mount命令
- 参考文章 ：http://www.jb51.net/os/RedHat/1109.html
- http://tutu.spaces.eepw.com.cn/articles/article/item/70737
```
mount [-t vfstype] [-o options] device dir
device 为设备
dir 为挂载点，通常通过新建目录来增加
mount --help
```

- umount命令
- 参考文章 : http://www.linuxso.com/command/umount.html

- 挂载windows共享资源
- 参考文章:https://wiki.centos.org/zh/TipsAndTricks/WindowsShares
```
挂载
mount -t cifs -o username=share,password=share,uid=500,gid=501,rw //10.0.4.13/sns /home/caokelei/sns

查看已经挂载
# mount -l 
卸载sns
umount -l //10.0.4.13/sns
或者
umount //10.0.4.13/sns
强制卸载
umount -f //10.0.4.13/sns
```
