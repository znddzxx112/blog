- 参考文章：https://docs.mongodb.com/manual/indexes/


- 查看索引
```
db.result.getIndexes();
```

- 当前数据库中的所有索引
```
> db.system.indexes.find()
```

- 创建索引
```
db.results.createIndex({simple_url:-1})
```

- 唯一索引
```
> db.things.ensureIndex({firstname:1,lastname:1},{unique:true})
```

- 删除索引
```
db.results.dropIndex({simple_url:1})
```
- 删除所有索引
```
db.results.dropIndexes();
```
