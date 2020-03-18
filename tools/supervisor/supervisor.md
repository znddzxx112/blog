

> https://www.cnblogs.com/luxiaoxun/p/7514428.html



```bash
supervisorctl -c /etc/supervisord.conf
```

上面这个命令会进入 supervisorctl 的 shell 界面，然后可以执行不同的命令了：

```bash
> status    # 查看程序状态
> stop usercenter   # 关闭 usercenter 程序
> start usercenter  # 启动 usercenter 程序
> restart usercenter    # 重启 usercenter 程序
```

