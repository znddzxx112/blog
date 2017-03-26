#! /bin/bash

# 参考文件 http://www.cnblogs.com/craftor/p/3811648.html

# test EXPRESSION

#test是关键字，表示判断；
#EXPRESSION是被判断的语句。
#关于EXPRESSION的说明，参考如下：

# http://www.cnblogs.com/craftor/p/3811648.html

val1=10

# 数值判断
#n1 -eq n2 检查n1是否与n2相等 (equal) 
#n1 -ge n2 检查n1是否大于或等于n2 (greater and equal) 
#n1 -gt n2 检查n1是否大于n2 (greater than) 
#n1 -le n2 检查n1是否小于或等于n2 (less and equal) 
#n1 -lt n2 检查n1是否小于n2 (less than) 
#n1 -ne n2 检查n1是否不等于n2 (not equal) 

if [ $val1 -eq 10 ]
then
	echo 'val1 eq 10'
else
	echo 'val1 ne 10'
fi

# 字符串比较
# str1 = str2 检查str1是否和str2相同 
# str1 != str2 检查str1是否和str2不同 
# str1 < str2 检查str1是否比str2小 
# str1 > str2 检查str1是否比str2大 
# -n str1 检查str1的长度是否非0 
# -z str1 检查str1的长度是否为0 

if [[ 'helloshell' = 'helloshell' ]]; then
	echo 'str eq';
fi

if [[ 'helloshell' < 'Helloshell' ]]; then
	echo 'helloshell is less than Helloshell'
fi

# 文件比较
#-d file 检查file是否存在并是一个目录 
#-e file 检查file是否存在 
#-f file 检查file是否存在并是一个文件 
#-r file 检查file是否存在并可读 
#-s file 检查file是否存在并非空 
#-w file 检查file是否存在并可写 
#-x file 检查file是否存在并可执行 
#-O file 检查file是否存在并属当前用户所有 
#-G file 检查file是否存在并且默认组与当前用户相同 
#file1 -nt file2 检查file1是否比file2新 
#file1 -ot file2 检查file1是否比file2旧 

if [ -d $HOME ]
then
	echo $HOME
	echo '$HOME is directory'
fi

# 判断对象是否存在 -e 适用于目录对象，-f适用于是否是文件
if [ -e $HOME ]
then
	echo '-e $HOME exit'
fi

if [ -f $HOME ]
then
	echo '$HOME is file';
else
	echo '$HOME is not file';
fi

# -s 判断是否为空
# -r -w -x -O -G判断是否可读，可写，写执行，你是否属主，默认组
if [[ -e '/root/mount.sh' ]];then
	if [[ -O '/root/mount.sh' ]]; then
		echo '/root/mount.sh owner you';
	else
		echo '/root/mount.sh owner not root';
	fi
else
	echo '/root/mount.sh not exist';
fi

if [[ -G '/root/mount.sh' ]]; then
	echo 'group is root'
fi
