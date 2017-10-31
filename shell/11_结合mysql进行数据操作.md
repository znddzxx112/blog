```
#!/bin/bash
// 确定工作目录
pwd=/workspace
cd $pwd
for i in ` mysql -h xxx -uxxx -pxxx -e 'select * from xxx' | awk '{print $1}'  | awk -F '.flv' '{print $1}' | awk -F '/' '{print $2}'`
do	
	if [ ! -d $pwd$i ];then
		mkdir $pwd$i;
		cd $pwd$i;
		// do something
		rm -rf $i.flv;
	fi
done
```
