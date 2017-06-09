```
create user 'reader'@'127.0.0.1' identified by 'Reader@123456';
// 赋予权限
GRANT SELECT ON *.* TO 'reader'@'127.0.0.1';
// 显示权限
show grants for 'reader'@'127.0.0.1';
// 再赋予权限
 GRANT INSERT ON *.* TO 'reader'@'127.0.0.1';
 // 回收权限
 REVOKE INSERT ON *.* FROM 'reader'@'127.0.0.1';
// 重新赋予权限后一定要刷新权限
flush privileges;
// 删除用户
drop user 'reader'@'127.0.0.1';
```
