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
