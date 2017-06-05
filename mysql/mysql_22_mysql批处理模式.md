- 批处理可以用于脚本（每周，每日）
- 适用于shell脚本中使用
```
#mysql -uwww -p -e ""
#mysql -uwww -p < batch-file
#mysql -uwww -p < batch-file > out
```

- 进程的输入应用，输出管道的应用

- 交互式使用脚本
```
mysql > source batch-file
```
