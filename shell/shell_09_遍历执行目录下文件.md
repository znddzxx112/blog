- 执行sh.d文件夹下的shell脚本,本脚本中变量在*.sh同样可以用
```
for file in $HOME/bin/sh.d/*.sh
do
        echo ${file}
        source $(file)
done
```
