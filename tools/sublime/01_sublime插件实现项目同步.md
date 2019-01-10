- sublime安装sftp插件
```
ctrl + alt + p
install package
输入 sftp
```

- 配置sftp
```
在目录的文件下 右键->sftp->setup server,配置好username和
```

- 使用ssh上传 - 推荐方式（简单，实用）
```
ctrl + alt + p
install package
输入 sublimesimplesync
```

- 配置sublimeSimpleSync
```
Preferences -> Package Setting
->Sublime Simple Sync->Setting Default
```
```
// Please add key map: 
// { "keys": ["alt+s"], "command": "sublime_simple_sync"}
// { "keys": ["alt+shift+s"], "command": "sublime_simple_sync_path"}
{
  "config": {
    "autoSync": false,
    "debug": false,
    "timeout": 10
  },
  "rules": [
  {
    "type": "ssh", "host": "192.168.0.119", "port": "22",
    "username": "username", "password": "password", // support windows/Mac/linux
    "local" : "D:\\wamp\\www\\localtt",
    "remote" : "/root/localtt"
  },
  {
    "type" : "local",
    "local" : "E:\\projectFolder\\projectA",
    "remote" : "D:\\bakup\\projectA"
  }
  ]
}
```

- 使用快捷键alt + s实现上传
```
增加快捷键: Preferences > Key Buildings - User, 添加一行, 比如:
{ "keys": ["alt+s"], "command": "sublime_simple_sync"},
```

- 建立链接
```
# ln -s /root/localtt /var/www/tt
```
