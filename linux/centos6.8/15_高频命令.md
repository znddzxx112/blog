* 修改拥有者，组拥有者
```
# chown -R user:group dir
# chown user:group file
```
* 修改权限
```
# chmod -R 777 dir
# chmod 777 file
```

* 发送/接收
```
# sz // 发送
# rz // 接收
```
* vim常用命令
```
显示行号
:set number
关闭行号
:set nonumber
多行复制
:100,112 co 188
多行剪切
:100,112 m 188 
多行删除
:100,112 de
跳转到指定行
:12
查找字符串
/str
新开一行
o
跳转文章头
gg
跳转文章尾
G
剪切
：2dd
复制
：2yy
查找
：/str
全局替换，确认
:%s/str1/str2/gc
```
* less命令
```
# less
b 上一页
空格 下一页
```
* ls命令
```
ls a*
```
* grep
```
grep -n "正则"

-a ：将 binary 档案以 text 档案的方式搜寻数据
-c ：计算找到 '搜寻字符串' 的次数
-i ：忽略大小写的不同，所以大小写视为相同
-n ：顺便输出行号
-v ：反向选择，亦即显示出没有 '搜寻字符串' 内容的那一行！

[abc]           ：表示“a”或“b”或“c”
[0-9]           ：表示 0~9 中任意一个数字，等价于[0123456789]
[\u4e00-\u9fa5] :表示任意一个汉字
[^a1<]          :表示除“a”、“1”、“<”外的其它任意一个字符
[^a-z]          :表示除小写字母外的任意一个字符

# grep -n 't[ae]st' regular_express.txt 

# grep -n '^#' regular_express.txt
```
* 内存编辑器
```
sed 不会对源文件进行操作，除非-i
```

* zip打包
```
# zip -r ./avatar.zip ./avatar
# sz ./avatar.zip
# rz
```
* git
```
$git config --global user.name "caokelei"
$git config --global user.email "caokelei@myhexin.com"
$git config -l
$ssh-keygen -t rsa -C "caokelei@myhexin.com"
版本回退
git reset --hard 3628164
远程分支回滚
加入-f参数，强制提交，远程端将强制跟新到reset版本
git push -f origin 分支名称
git reset --hard HEAD^
```
* redis
```
set key value

查询key
get key

查询keys
keys *
keys sns* 模糊查找

删除key
del key1

是否存在key
exists key

设置生命周期
expire key 整数值：设置key的生命周期以秒为单位

redis过期时间
查询key过期时间
ttl key

设置过期时间
expire key sconends 秒数
pexpire key mcsecond 毫秒数
expireat key time 
pexpire key microtime

键值过期策略总结：
1.定时删除，内存友好，cpu不友好
2.惰性删除，cpu友好，内存不友好
3.定期删除，折中
redis采用 惰性删除和定期删除这二种策略
```
* mongodb
```
> show dbs；
> use dbname;
> db.getCollectionNames();
> db.quickReply.find();
> db.quickReply.update({"":""},{$set:{"":""}});
> db.quickReply.update({"_id":ObjectId("")},{$set:{"":""}});
// 删除数据库 - 选择数据库，删除数据库
> use dbname:
> db.dropDatabase();
// 删除collection数据
> db.quickreply.remove({"userid":""})
```
