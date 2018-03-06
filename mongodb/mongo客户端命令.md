#### mongo客户端命令

##### 1)启动mongodb
```
     命令:mongod  --dbpath [你的mongodb数据存放的目录
      然后另开一个标签输入:mongo  
       前提是你已经将mongodb添加到环境变量中,否则需到mongodb安装目录的bin文件夹下去执行以上命令
```

##### 链接数据库
```
./mongo --port
./mongo 192.168.1.102
```

##### 停止mongodb
```
db.shutdownServer();
```

##### 显示mongodb中有哪些数据库
```
> show dbs
```

##### 显示当前正在使用的数据库
```
> db
```

##### 选择使用的数据库
```
>use 你要使用的数据库名
```

##### 登陆你要使用的数据库

```
>db.auth(username,password)  username为用户名,password为密码
```

##### 查看当前数据库有哪些表

```
>db.getCollectionNames()
```

##### 显示数据库有哪些操作
```
>db.help()
```

##### 查看数据库下的表有哪些操作
```
>db.CollectionName.help()   CollectionName为要操作的表,以下CollectionName均为表名
```

##### 查询操作

```
>db.CollectionName.find({}).pretty()  大括号里是查询条件,pretty()以格式化的形式输出
>db.CollectionName.find({},{}).pretty() 第一个大括号为查询条件,第二个大括号为要输出的字段,要输出的字段就将其值设为1,没写的字段默认为不输出,_id字段默认为总是输出,如果不想输出就将其值设为0
>db.CollectionName.find({}).count() 输出查询到的数据的条数
>db.CollectionName.findOne({});
获取一条
>db.CollectionName.find().count();
获取到的总条数数量
>db.CollectionName.find().limit(3);
获取指定条数
```

##### 修改操作
```
>db.CollectionName.update({name:"mongo"},{$set:{name:"mongo_new"}}) //只更新一条
>db.CollectionName.update({name:"mongo"},{$set:{name:"mongo_new"}},false,true) //更新多条
```

###### 删除操作
```
>db.CollectionName.remove({name:"mongo"});
```

##### 等待处理命令
```
10)特殊查询条件
>$gt  大于
>$lt   小于
>$gte  大于等于
>$lte   小于等于
>$elemMatch  嵌套查询值为列表
11)删除数据
>db.CollectionName.remove({}) 大括号为条件
12)删除表
>db.CollectionName.drop()
13)建索引
>db.CollectionName.ensureIndex({}) 大括号里为要建索引的字段名,1为升序,-1为降序
14)插入数据
>db.CollectionName.insert({})
15)更新数据
>db.CollectionName.update({},{})   第一个大括号为更新条件,第二个为更新的内容,$set为更新原有数据,$inc为插入新数据
```

##### 条件操作符
```
db.collection.find({ "field" : { $gt: value } } ); // 大于: field > value
db.collection.find({ "field" : { $lt: value } } ); // 小于: field < value
db.collection.find({ "field" : { $gte: value } } ); // 大于等于: field >= value
db.collection.find({ "field" : { $lte: value } } ); // 小于等于: field <= value
db.collection.find({ "field" : { $gt: value1, $lt: value2 } } ); // value1 < field < value
```

##### all操作
```
db.users.find({age : {$all : [6, 8]}});
// 必须全部满足
```

##### $exists判断字段是否存在
```
db.users.find({age: {$exists: true}});
```

##### $ne不等于
```
db.things.find( { x : { $ne : 3 } } );
```

##### $in包含
```
db.things.find({x:{$in: [2,4,6]}});
```

##### $nin不包含
```
db.things.find({x:{$nin: [2,4,6]}});
```

##### 正则表达式匹配
```
db.users.find({name: {$regex: /^B.*/}});
```

##### skip限制返回记录的起点
```
db.users.find().skip(3).limit(5);
```

##### sort排序
```
以年龄升序asc
db.users.find().sort({age: 1});
以年龄降序desc
db.users.find().sort({age: -1});
```

##### 支持存储过程

##### GridFs 
```
透明的，分布式文件存储，有效保存大文件对象，巨大文件，视频，高清图片。
```
