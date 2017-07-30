- 执行sh.d下的shell脚本，本shell变量在shell中同样可以使用
```
for file in $HOME/bin/sh.d/*.sh
do
        echo ${file}
        source $(file)
done
```
