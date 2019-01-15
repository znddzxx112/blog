#### 锁

参考文章《深入浅出mysql》

##### 表级锁

- 表级锁： 开销小， 加锁快； 不会出现死锁； 锁定粒度大， 发生锁冲突的概率最高,并发
度最低。

- MySQL 的表级锁有两种模式： 表共享读锁（ Table Read Lock） 和表独占写锁（ Table Write Lock）。

```
lock table film_text write;

unlock tables;
```
- MyISAM 在执行查询语句（ SELECT） 前， 会自动给涉及的所有表加读锁， 在执行更新操作
（ UPDATE、 DELETE、 INSERT 等） 前， 会自动给涉及的表加写锁， 这个过程并不需要用户干
预， 因此， 用户一般不需要直接用 LOCK TABLE 命令给 MyISAM 表显式加锁。 在本书的示例
中， 显式加锁基本上都是为了方便而已， 并非必须如此。

- 二条语句需要锁
```
Lock tables orders read local, order_detail read local;
Select sum(total) from orders;
Select sum(subtotal) from order_detail;
Unlock tables;
```

##### 行级锁

- 行级锁： 开销大， 加锁慢； 会出现死锁； 锁定粒度最小， 发生锁冲突的概率最低,并发
度也最高。

- 获取Innodb行锁征用情况
```
show status like 'innodb_row_lock%';
```

- 加锁
```
select actor_id,first_name,last_name
from actor where actor_id = 178 lock in share
mode;
```

##### 页面锁

- 页面锁： 开销和加锁时间界于表锁和行锁之间； 会出现死锁； 锁定粒度界于表锁和行锁
之间， 并发度一般。

##### 比较

- 表级锁更适合于以查询为主， 只有少量按索引条件更新数据的应用， 如
Web 应用； 而行级锁则更适合于有大量按索引条件并发更新少量不同数据
