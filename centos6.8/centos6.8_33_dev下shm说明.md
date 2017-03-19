
- dev/shm文件夹
```
存放在内存中，快速读取，重新消失，大小上限为内存的一半
```

- 查看挂载目录以及对应大小
```
df -Th
df -h /dev/shm
mount /dev/shm
umount /dev/shm
fuser -m /dev/shm
```

- 命令查找 http://man.linuxde.net/
