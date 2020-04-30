- 导出数据
```
// 只导出表结构
# mysqldump -uwww -pwww -d phpdb article > /tmp/art_dir.sql
// 导出表结构和数据
# mysqldump -uwww -pwww phpdb article > /tmp/art_dir.sql
```

- 导入数据
```
# mysql -uwww -pwww
# source /tmp/art_dir.sql
```

- 导出是gz打包

```bash
导出数据库
 mysqldump -hxxx-uroot -pxxx --databases wallet | gzip > ~/wallet-`date +%Y-%m-%d_%H%M%S`.sql.gz 
 
scp ./wallet-2020-04-15_134031.sql.gz root@xxxx:/tmp/

 echo "drop database if exists wallet; create database wallet" | mysql -uroot -proot

 gunzip < wallet-2020-04-15_115508.sql.gz | mysql -uroot -pxxx wallet
```

