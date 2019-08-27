- 参考文章：https://docs.mongodb.com/manual/indexes/

> 查看索引：
```
db.feed.getIndexes();
```
> 创建稀疏索引：
```
db.feedlive.createIndex({userid:1},{spare:true});
```
> 创建组合索引：
```
db.feedlive.createIndex({userid:1,_id:-1}, {background: true});
```
> 创建唯一索引:
```
db.feedlive.createIndex({userid:1,_id:-1}, {unique:true});
```
> 删除索引:
```
db.feedlive.dropIndex({userid:1});
```
> 重建索引:
```
db.feedlive.reIndex();
```
